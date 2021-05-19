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
use Askvortsov\AutoModerator\Criterion;
use Flarum\Api\Controller\AbstractShowController;
use Flarum\Http\RequestUtil;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ShowCriterionController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = CriterionSerializer::class;

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $id = Arr::get($request->getQueryParams(), 'id');
        RequestUtil::getActor($request)->assertCan('administrate');

        return Criterion::findOrFail($id);
    }
}
