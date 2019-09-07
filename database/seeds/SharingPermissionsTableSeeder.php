<?php

use App\SharingPermission;
use Illuminate\Database\Seeder;

class SharingPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Add members',
            'View members',
            'Add expenses',
            'View expenses',
            'View charts',
            'Share with other people',
            'Edit household',
            'View household balance',
            'Delete household'
        ];
        foreach($permissions as $perm){
            $permission = new SharingPermission();
            $permission->name = $perm;
            $permission->save();
        }
    }
}
