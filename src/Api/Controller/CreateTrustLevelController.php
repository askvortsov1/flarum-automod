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
use Flarum\Api\Controller\AbstractCreateController;
use Flarum\Group\Group;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreateTrustLevelController extends AbstractCreateController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = TrustLevelSerializer::class;

    /**
     * {@inheritdoc}
     */
    public $include = ['group'];

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
        $request->getAttribute('actor')->assertCan('administrate');

        $data = Arr::get($request->getParsedBody(), 'data', []);

        $groupId = Arr::get($data, 'relationships.group.data.id');

        $trustLevel = TrustLevel::build(
            Arr::get($data, 'attributes.name'),
            Group::find($groupId)
        );

        $trustLevel->min_discussions_entered = (int) Arr::get($data, 'attributes.minDiscussionsEntered');
        $trustLevel->max_discussions_entered = (int) Arr::get($data, 'attributes.maxDiscussionsEntered');
        $trustLevel->min_discussions_participated = (int) Arr::get($data, 'attributes.minDiscussionsParticipated');
        $trustLevel->max_discussions_participated = (int) Arr::get($data, 'attributes.maxDiscussionsParticipated');
        $trustLevel->min_discussions_started = (int) Arr::get($data, 'attributes.minDiscussionsStarted');
        $trustLevel->max_discussions_started = (int) Arr::get($data, 'attributes.maxDiscussionsStarted');
        $trustLevel->min_posts_made = (int) Arr::get($data, 'attributes.minPostsMade');
        $trustLevel->max_posts_made = (int) Arr::get($data, 'attributes.maxPostsMade');

        $this->validator->assertValid($trustLevel->getAttributes());

        $trustLevel->save();

        return $trustLevel;
    }
}
