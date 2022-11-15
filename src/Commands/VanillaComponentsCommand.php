<?php

namespace Flavorly\VanillaComponents\Commands;

use Illuminate\Console\Command;

class VanillaComponentsCommand extends Command
{
    public $signature = 'laravel-vanilla-components';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
