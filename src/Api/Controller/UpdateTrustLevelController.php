<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Api\Controller;

use Askvortsov\TrustLevels\Api\Serializer\TrustLevelSerializer;
use Askvortsov\TrustLevels\Range\RangeManager;
use Askvortsov\TrustLevels\TrustLevel;
use Askvortsov\TrustLevels\TrustLevelValidator;
use Flarum\Api\Controller\AbstractShowController;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class UpdateTrustLevelController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = TrustLevelSerializer::class;

    /**
     * @var RangeManager
     */
    protected $ranges;

    /**
     * @var TrustLevelValidator
     */
    protected $validator;

    /**
     * @param RangeManager $ranges
     * @param TrustLevelValidator $validator
     * @return void
     */
    public function __construct(RangeManager $ranges, TrustLevelValidator $validator)
    {
        $this->ranges = $ranges;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $id = Arr::get($request->getQueryParams(), 'id');
        $request->getAttribute('actor')->assertCan('administrate');

        $trustLevel = TrustLevel::find($id);

        $data = Arr::get($request->getParsedBody(), 'data', []);

        $attributes = Arr::get($data, 'attributes', []);

        if (isset($attributes['name'])) {
            $trustLevel->name = $attributes['name'];
        }

        foreach ($this->ranges->getDrivers() as $name => $driver) {
            $trustLevel->setRange($name, Arr::get($data, "attributes.min$name"), Arr::get($data, "attributes.max$name"));
        }

        $this->validator->assertValid($trustLevel->getDirty());

        $trustLevel->save();

        return $trustLevel;
    }
}
