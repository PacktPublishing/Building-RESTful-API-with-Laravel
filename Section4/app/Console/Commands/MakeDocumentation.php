<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Tymon\JWTAuth\Facades\JWTAuth;

class MakeDocumentation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:documentation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates api documentation';

    /**
     * Execute the console command.
     *
     * @return mixed
     *
     */
    public function handle()
    {
        $user = User::where('email', 'admin@example.com')->first();
        $token = JWTAuth::fromUser($user);

        $process = new Process('php artisan api:generate --routePrefix="v1" --header="Authorization: Bearer ' . $token
            . '" --router="dingo" --force --output documentation --bindings="user,1|city,London|date,2009-01-01"');

        return $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
