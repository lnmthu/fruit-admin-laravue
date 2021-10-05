<?php

use Illuminate\Database\Seeder;

class CategoryPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Laravue\Models\Permission::findOrCreate('view category', 'api');
        \App\Laravue\Models\Permission::findOrCreate('manage category', 'api');
        \App\Laravue\Models\Permission::findOrCreate('view menu category', 'api');

        // Assign new permissions to admin group
        $adminRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_ADMIN);
        $adminRole->givePermissionTo(['view category', 'manage category', "view menu category"]);
        $visitorRole = App\Laravue\Models\Role::findByName(App\Laravue\Acl::ROLE_VISITOR);
        $visitorRole->givePermissionTo('view category');
    }
}