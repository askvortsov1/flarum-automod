<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Api\Controller;

use Askvortsov\AutoModerator\Api\Serializer\CriterionSerializer;
use Askvortsov\AutoModerator\Metric\MetricManager;
use Askvortsov\AutoModerator\Criterion;
use Askvortsov\AutoModerator\CriterionValidator;
use Flarum\Api\Controller\AbstractCreateController;
use Flarum\Group\Group;
use Flarum\Http\RequestUtil;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreateCriterionController extends AbstractCreateController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = CriterionSerializer::class;

    /**
     * @var MetricManager
     */
    protected $metrics;

    /**
     * @var CriterionValidator
     */
    protected $validator;

    /**
     * @param MetricManager       $metrics
     * @param CriterionValidator $validator
     *
     * @return void
     */
    public function __construct(MetricManager $metrics, CriterionValidator $validator)
    {
        $this->metrics = $metrics;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = RequestUtil::getActor($request);
        $actor->assertAdmin();

        $data = Arr::get($request->getParsedBody(), 'data', []);

        $criterion = Criterion::build(
            Arr::get($data, 'attributes.name'),
            $actor->id,
            Arr::get($data, 'attributes.icon'),
            Arr::get($data, 'attributes.description'),
            Arr::get($data, 'attributes.actions'),
            Arr::get($data, 'attributes.metrics'),
            Arr::get($data, 'attributes.requirements'),

        );

        $this->validator->assertValid($criterion->getAttributes());

        $criterion->save();

        return $criterion;
    }
}
