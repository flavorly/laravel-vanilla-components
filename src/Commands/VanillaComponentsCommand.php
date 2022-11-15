<?php

namespace Flavorly\VanillaComponents\Commands;

use Illuminate\Console\Command;

class VanillaComponentsCommand extends Command
{
    public $signature = 'vanilla-components-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
