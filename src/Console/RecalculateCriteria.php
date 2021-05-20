<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Console;

use Askvortsov\AutoModerator\CriteriaCalculator;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;
use Illuminate\Console\Command;
use Illuminate\Database\ConnectionInterface;

class RecalculateCriteria extends Command
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var CriteriaCalculator
     */
    protected $calculator;

    public function __construct(ConnectionInterface $connection, CriteriaCalculator $calculator)
    {
        parent::__construct();

        $this->connection = $connection;

        $this->calculator = $calculator;
    }

    /**
     * @var string
     */
    protected $signature = 'criteria:recalculate {--amount=500}';

    /**
     * @var string
     */
    protected $description = 'Recalculate criteria groups of all users.';

    public function handle()
    {
        // Amount is not numeric
        if (!is_numeric($this->option('amount'))) {
            $this->error('Amount should be numeric.');

            return;
        }

        // Initialize variables
        $amount = intval($this->option('amount'));
        $currentBatch = 0;
        $userCount = User::count();
        $expectedBatches = ceil($userCount / $amount);

        // Info
        $this->info('Recalculating levels');
        $this->line("There are currently {$userCount} users. Expect {$expectedBatches} batche(s) with a maximum of {$amount} users at a time");

        // Loop through all batches
        for ($currentBatch = 1; $currentBatch <= $expectedBatches; $currentBatch++) {
            $this->comment("Starting batch {$currentBatch} from {$expectedBatches}");

            $this->batch($currentBatch, $amount);
        }

        // Finished
        $this->info('Finished - Executed '.$expectedBatches.' batches');
    }

    /**
     * @var int Current batch number
     * @var int Max amount of rows to load each batch
     */
    private function batch($batchNumber, $maxRows)
    {
        $timeStarted = microtime(true);

        // Calculate startpoint
        $startFrom = ($batchNumber - 1) * $maxRows;

        // Load users
        $users = User::query()
            ->offset($startFrom)
            ->limit($maxRows)
            ->get();

        // Create a fancy bar
        $bar = $this->output->createProgressBar(count($users));
        $bar->setFormat('very_verbose');
        $bar->start();

        // Start transaction
        $this->connection->beginTransaction();

        // Recalculate
        /** @var User */
        foreach ($users as $user) {
            $this->calculator->recalculate($user, LoggedIn::class);
            $bar->advance();
        }

        $bar->finish();

        // Commit transaction
        $this->connection->commit();

        $finishTime = round(((microtime(true) - $timeStarted)), 2);
        $this->info(" - Finished in {$finishTime} seconds");
    }
}
