<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Api\Controller;

use Askvortsov\TrustLevels\Api\Serializer\TrustLevelRangeDriverSerializer;
use Askvortsov\TrustLevels\Range\RangeManager;
use Flarum\Api\Controller\AbstractShowController;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Validation\Factory;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ShowTrustLevelRangeDriversController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = TrustLevelRangeDriverSerializer::class;

    /**
     * @var RangeManager
     */
    protected $ranges;

    public function __construct(RangeManager $ranges)
    {
        $this->ranges = $ranges;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $request->getAttribute('actor')->assertAdmin();

        $drivers = $this->ranges->getDrivers();

        return $drivers;
    }
}
