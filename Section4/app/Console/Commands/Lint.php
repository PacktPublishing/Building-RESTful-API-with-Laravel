<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Lint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lint';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the syntax of the project';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $timeLimit = 320;
        set_time_limit($timeLimit);

        $process = new Process('vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR .
            'parallel-lint --exclude vendor --exclude _ide_helper.php --exclude .phpstorm.meta.php .');
        $process->setTimeout($timeLimit);

        return $process->run(function ($type, $buffer) {
            echo $type . ' '. $buffer;
        });
    }
}
