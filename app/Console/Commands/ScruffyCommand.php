<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScruffyCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scruffy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->thing('432a');
        $this->thing('432-ba');
        $this->thing('banadna 1');
        $this->thing('21 banadna 13');
    }

    public function thing($value)
    {
        $matches = [];
        $numbers = preg_match('/[^0-9]*([0-9]*)/', $value, $matches);
        dump($matches);
    }
}
