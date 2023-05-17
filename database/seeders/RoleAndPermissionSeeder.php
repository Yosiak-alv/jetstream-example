<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'delete product']);


        $role = Role::create(['name' => 'employee'])
        ->givePermissionTo(['view product', 'create product','edit product']);
        
        $role = Role::create(['name' => 'administrador']);
        $role->givePermissionTo(Permission::all());


        //guarded_name = 'web' con error probar solo con ese seeder despues
       /*  $permissionsByRole = [
            'administrator' => ['view product', 'create product','edit product','delete product'],
            'employee' => ['view product', 'create product','edit product']
        ];

        
        $insertPermissions = fn ($role) => collect($permissionsByRole[$role])
            ->map(fn ($name) => DB::table('permissions')->insertGetId(['name' => $name,'guard_name' => 'web']))
        ->toArray();

        $permissionIdsByRole = [
            'administrator' => $insertPermissions('administrator'),
            'employee' => $insertPermissions('employee'),
        ];

        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $role = Role::whereName($role)->first();
        
            DB::table('role_has_permissions')
                ->insert(
                    collect($permissionIds)->map(fn ($id) => [
                        'role_id' => $role->id,
                        'permission_id' => $id
                    ])
                ->toArray()
            );
        } */
    }
}
