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
use Flarum\Api\Controller\AbstractShowController;
use Flarum\Http\RequestUtil;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class UpdateCriterionController extends AbstractShowController
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

        $id = Arr::get($request->getQueryParams(), 'id');
        $criterion = Criterion::find($id);

        $criterion->last_edited_by_id = $actor->id;
        
        $data = Arr::get($request->getParsedBody(), 'data', []);

        collect(['name', 'description', 'icon', 'actions', 'metrics', 'requirements'])
            ->each(function (string $attribute) use ($criterion, $data) {
                if (($val = Arr::get($data, "attributes.$attribute")) !== null) {
                    $criterion->$attribute = $val;
                }
            });

        $this->validator->assertValid($criterion->getDirty());

        $criterion->save();

        return $criterion;
    }
}
