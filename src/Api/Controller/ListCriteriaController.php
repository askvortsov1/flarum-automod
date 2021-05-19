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
use Flarum\Api\Controller\AbstractListController;
use Flarum\Http\RequestUtil;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListCriteriaController extends AbstractListController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = CriterionSerializer::class;

    /**
     * {@inheritdoc}
     */
    public $optionalInclude = [
        'users',
    ];

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = RequestUtil::getActor($request);
        $include = $this->extractInclude($request);

        $actor->assertCan('administrate');

        $criteria = Criterion::query()->whereVisibleTo($actor)->get();

        return $criteria->load($include);
    }
}
