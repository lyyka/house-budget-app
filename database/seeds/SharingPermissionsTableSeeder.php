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
            'Edit members',
            'Delete members',
            'Add expenses',
            'View expenses',
            'Delet expenses',
            'View charts',
            'View household balance',
            'Share with other people',
            'Edit household',
            'Delete household'
        ];
        foreach($permissions as $perm){
            $permission = new SharingPermission();
            $permission->name = $perm;
            $permission->save();
        }
    }
}
