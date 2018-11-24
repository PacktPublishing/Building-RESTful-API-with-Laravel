<?php

use App\Models\Auth\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // name, display_name, description
        $permissions = [
            [ 'query-temperature', 'Query the temperature', 'User can query the temperature from the database' ],
        ];
        foreach ($permissions as $permission) {
            $permissionInstance = Permission::firstOrNew([
                'name' => $permission[0],
            ]);
            $permissionInstance->display_name = $permission[1];
            $permissionInstance->description = $permission[2];
            $permissionInstance->save();
        }

        Model::reguard();
    }
}
