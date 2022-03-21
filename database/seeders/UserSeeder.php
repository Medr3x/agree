<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Medr3x_1',
            'email' => 'admin@agree.com',
            'password' => '112233'
        ])->assignRole('admin');

        User::create([
            'name' => 'Medr3x_2',
            'email' => 'player@agree.com',
            'password' => '112233'
        ])->assignRole('player');

        User::create([
            'name' => 'Medr3x_3',
            'email' => 'card_makers@agree.com',
            'password' => '112233'
        ])->assignRole('card_makers');
    }
}
