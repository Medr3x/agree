<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAbilities();
        $this->createRoles();
    }

    protected function createRoles()
    {
        Role::create([
            'name' => 'admin',
            'title' => 'ADMINISTRADOR',
            'guard_name' => 'api'
        ]);

        $player = Role::create([
            'name' => 'player',
            'title' => 'JUGADOR',
            'guard_name' => 'api'
        ]);

        $usuario_de_carga = Role::create([
            'name' => 'card_makers',
            'title' => 'Creador de Cartas',
            'guard_name' => 'api'
        ]);

        $player->syncPermissions([
            'view-card',
            'assign-card',
            'return-card',
            'return-all-cards'
        ]);

        $usuario_de_carga->syncPermissions([
            'view-card',
            'create-card',
            'update-card',
            'delete-card',
            'view-category',
            'create-category',
            'update-category',
            'delete-category'
        ]);

    }

    protected function createAbilities()
    {
        //Cards
        Permission::create([
            'name' => 'view-card',
            'title' => 'Ver Cartas',
            'grouper' => 'App\Models\Card',
            'guard_name' => 'api',
            'grouper_name' => 'Cards',
        ]);

        Permission::create([
            'name' => 'create-card',
            'title' => 'Crear Cartas',
            'grouper' => 'App\Models\Card',
            'guard_name' => 'api',
            'grouper_name' => 'Cards',
        ]);

        Permission::create([
            'name' => 'update-card',
            'title' => 'Modificar Cartas',
            'grouper' => 'App\Models\Card',
            'guard_name' => 'api',
            'grouper_name' => 'Cards',
        ]);

        Permission::create([
            'name' => 'delete-card',
            'title' => 'Eliminar Cartas',
            'grouper' => 'App\Models\Card',
            'guard_name' => 'api',
            'grouper_name' => 'Cards',
        ]);

        Permission::create([
            'name' => 'assign-card',
            'title' => 'Asignar Cartas',
            'grouper' => 'App\Models\Card',
            'guard_name' => 'api',
            'grouper_name' => 'Cards',
        ]);

        Permission::create([
            'name' => 'return-card',
            'title' => 'Devolver Carta',
            'grouper' => 'App\Models\Card',
            'guard_name' => 'api',
            'grouper_name' => 'Cards',
        ]);

        Permission::create([
            'name' => 'return-all-cards',
            'title' => 'Devolver Las Cartas',
            'grouper' => 'App\Models\Card',
            'guard_name' => 'api',
            'grouper_name' => 'Cards',
        ]);

        //categoriess of cards
        Permission::create([
            'name' => 'view-category',
            'title' => 'Ver Categorias y SubCategorias',
            'grouper' => 'App\Models\Category',
            'guard_name' => 'api',
            'grouper_name' => 'Categories',
        ]);

        Permission::create([
            'name' => 'create-category',
            'title' => 'Crear Categorias y SubCategorias',
            'grouper' => 'App\Models\Category',
            'guard_name' => 'api',
            'grouper_name' => 'Categories',
        ]);

        Permission::create([
            'name' => 'update-category',
            'title' => 'Modificar Categorias y SubCategorias',
            'grouper' => 'App\Models\Category',
            'guard_name' => 'api',
            'grouper_name' => 'Categories',
        ]);

        Permission::create([
            'name' => 'delete-category',
            'title' => 'Eliminar Categorias y SubCategorias',
            'grouper' => 'App\Models\Category',
            'guard_name' => 'api',
            'grouper_name' => 'Categories',
        ]);
     }
}
