<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Api\Controller;

use Askvortsov\TrustLevels\Api\Serializer\TrustLevelSerializer;
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
     * @var TrustLevelValidator
     */
    protected $validator;

    /**
     * @param TrustLevelValidator $validator
     * @return void
     */
    public function __construct(TrustLevelValidator $validator)
    {
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

        if (isset($attributes['minDiscussionsEntered'])) {
            $trustLevel->min_discussions_entered = $attributes['minDiscussionsEntered'];
        }

        if (isset($attributes['maxDiscussionsEntered'])) {
            $trustLevel->max_discussions_entered = $attributes['maxDiscussionsEntered'];
        }

        if (isset($attributes['minDiscussionsParticipated'])) {
            $trustLevel->min_discussions_participated = $attributes['minDiscussionsParticipated'];
        }

        if (isset($attributes['maxDiscussionsParticipated'])) {
            $trustLevel->max_discussions_participated = $attributes['maxDiscussionsParticipated'];
        }

        if (isset($attributes['minDiscussionsStarted'])) {
            $trustLevel->min_discussions_started = $attributes['minDiscussionsStarted'];
        }

        if (isset($attributes['maxDiscussionsStarted'])) {
            $trustLevel->max_discussions_started = $attributes['maxDiscussionsStarted'];
        }

        if (isset($attributes['minPostsMade'])) {
            $trustLevel->min_posts_made = $attributes['minPostsMade'];
        }

        if (isset($attributes['maxPostsMade'])) {
            $trustLevel->max_posts_made = $attributes['maxPostsMade'];
        }

        $this->validator->assertValid($trustLevel->getDirty());

        $trustLevel->save();

        return $trustLevel;
    }
}
