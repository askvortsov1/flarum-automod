<?php

/*
 * This file is part of askvortsov/flarum-trust-levels
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Api\Controller;

use Askvortsov\TrustLevels\Api\Serializer\TrustLevelSerializer;
use Askvortsov\TrustLevels\Metric\MetricManager;
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
     * @var MetricManager
     */
    protected $metrics;

    /**
     * @var TrustLevelValidator
     */
    protected $validator;

    /**
     * @param MetricManager       $metrics
     * @param TrustLevelValidator $validator
     *
     * @return void
     */
    public function __construct(MetricManager $metrics, TrustLevelValidator $validator)
    {
        $this->metrics = $metrics;
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

        foreach ($this->metrics->getDrivers() as $name => $driver) {
            $trustLevel->setMetric($name, Arr::get($data, "attributes.min$name"), Arr::get($data, "attributes.max$name"));
        }

        $this->validator->assertValid($trustLevel->getDirty());

        $trustLevel->save();

        return $trustLevel;
    }
}
