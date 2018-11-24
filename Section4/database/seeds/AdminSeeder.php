<?php

use App\Models\Auth\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin@example.com';

        if(User::where('email', $email)->exists()) {
            echo 'Admin already added' . PHP_EOL;
            return;
        }

        $user = factory(User::class)->times(1)->create([
            'email' => $email
        ])->first();
        $adminRole = Role::where('name', 'root')->first();
        $user->attachRole($adminRole);

        echo 'Admin created. Email: ' . $email;
    }
}
