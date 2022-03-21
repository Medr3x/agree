<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mo = Category::create([
            'name' => 'Monstruo',
            'sku_id' => '001'
        ]); 

        Category::create([
            'name' => 'Normales',
            'sku_id' => '004',
            'parent_id' => $mo->id
        ]); 

        Category::create([
            'name' => 'Efecto',
            'sku_id' => '005',
            'parent_id' => $mo->id
        ]); 

        Category::create([
            'name' => 'Fusión',
            'sku_id' => '006',
            'parent_id' => $mo->id
        ]); 

        $ma = Category::create([
            'name' => 'Mágica',
            'sku_id' => '002'
        ]); 

        Category::create([
            'name' => 'Normales',
            'sku_id' => '007',
            'parent_id' => $ma->id
        ]); 

        Category::create([
            'name' => 'Continua',
            'sku_id' => '008',
            'parent_id' => $ma->id
        ]); 

        Category::create([
            'name' => 'Equipo',
            'sku_id' => '009',
            'parent_id' => $ma->id
        ]); 

        $ta = Category::create([
            'name' => 'Trampa',
            'sku_id' => '003'
        ]); 

        Category::create([
            'name' => 'Normales',
            'sku_id' => '010',
            'parent_id' => $ta->id
        ]); 

        Category::create([
            'name' => 'Continuas',
            'sku_id' => '011',
            'parent_id' => $ta->id
        ]); 

        Category::create([
            'name' => 'Contraefecto',
            'sku_id' => '012',
            'parent_id' => $ta->id
        ]); 
    }
}
