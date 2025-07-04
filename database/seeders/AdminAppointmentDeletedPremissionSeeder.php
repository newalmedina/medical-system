<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class AdminAppointmentDeletedPremissionSeeder  extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->init();

        // Si los permisos los hemos creados volvemos
        $permExists = Permission::where('name', Str::slug('admin-appointments-deleted'))->first();
        if (!empty($permExists)) {
            return;
        }

        // Módulo de patients
        $permissions = [
            [
                'display_name' => 'Citas eliminadas',
                'name' => Str::slug('admin-appointments-deleted'),
                'description' => 'Citas eliminadas - Módulo'
            ],

            [
                'display_name' => 'Citas eliminadas - listado ',
                'name' => Str::slug('admin-appointments-deleted-list'),
                'description' => 'Citas eliminadas - listado '
            ],
            [
                'display_name' => 'Citas eliminadas - restablecer ',
                'name' => Str::slug('admin-appointments-deleted-restablecer'),
                'description' => 'Citas eliminadas - restablecer '
            ],
            [
                'display_name' => 'Citas eliminadas - eliminar permanentemente ',
                'name' => Str::slug('admin-appointments-deleted-permanent'),
                'description' => 'Citas eliminadas - eliminar permanentemente '
            ],
           
          


        ];
        $MenuChild = $this->insertPermissions($permissions, $this->childAdmin, $this->a_permission_admin);

        // Rol de administrador
        $roleAdmin = Role::where("name", "=", Str::slug('admin'))->first();
        if (!empty($this->a_permission_admin)) {
            $roleAdmin->attachPermissions($this->a_permission_admin);
        }
        $roleUser = Role::where("name", "=", Str::slug('usuario-front'))->first();
        if (!empty($this->a_permission_front)) {
            $roleUser->attachPermissions($this->a_permission_front);
        }
    }
}
