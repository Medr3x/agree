<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Card;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Card::create([
            'name' => 'Mago Oscuro',
            'sku_id' => 'BIY-S006',
            'first_edition' => 1,
            'serial_code' => '46986414',
            'category_id' => 4,
            'atk' => 2500,
            'def' => 2100,
            'qty_star' => 7,
            'description' => 'El mas grande de los magos en relacion con el ataque y la defensa.',
            'price' => 1000000,
            'card_creation_date' => '1996-01-01 00:00:00'
        ]);

        Card::create([
            'name' => 'Energia XYZ',
            'sku_id' => 'YS11-SP023',
            'first_edition' => 1,
            'serial_code' => '85839825',
            'category_id' => 8,
            'description' => 'Desacopla: material xyz',
            'price' => 11111,
            'card_creation_date' => '1996-01-01 00:00:00'
        ]);
    }
}
