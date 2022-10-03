<?php

namespace Konnco\SatSet\Commands;

use Illuminate\Console\Command;

class SatSetCommand extends Command
{
    public $signature = 'satset';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
