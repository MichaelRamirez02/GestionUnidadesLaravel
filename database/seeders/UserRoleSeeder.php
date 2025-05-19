<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $adminRole = new Role();
        $adminRole->name = 'Administrador';
        $adminRole->save();

        //Servicios Role
        $serviciosRole = new Role();
        $serviciosRole->name = 'Gestor de Servicios';
        $serviciosRole->save();

        $serviciosPermission = Permission::where('module', '=', 'Servicios')
                                     ->get();

        foreach($serviciosPermission as $permission) {

            $rolePermission = new RolePermission();
            $rolePermission->role_id = $serviciosRole->id;
            $rolePermission->permission_id = $permission->id;
            $rolePermission->save();
        }

        // Sections Role
        $sectionsRole = new Role();
        $sectionsRole->name = 'Gestor de Secciones';
        $sectionsRole->save();

        $sectionPermissions = Permission::where('module', '=', 'Secciones')
                                        ->get();

        foreach($sectionPermissions as $permission) {

            $rolePermission = new RolePermission();
            $rolePermission->role_id = $sectionsRole->id;
            $rolePermission->permission_id = $permission->id;
            $rolePermission->save();
        }

        // Users

        $user = new User();
        $user->first_name = 'Michael';
        $user->last_name = 'Ramirez';
        $user->document = '1023624784';
        $user->email = 'michaelr@yopmail.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('1234');
        $user->role_id = $adminRole->id;
        $user->save();

        $user = new User();
        $user->first_name = 'Mateo';
        $user->last_name = 'Becerra';
        $user->document = '1017924375';
        $user->email = 'mateob@yopmail.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('1234');
        $user->role_id = $serviciosRole->id;
        $user->save();

        $user = new User();
        $user->first_name = 'Jhon';
        $user->last_name = 'Doe';
        $user->document = '3333';
        $user->email = 'jhond@yopmail.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('1234');
        $user->role_id = $sectionsRole->id;
        $user->save();

    }
}
