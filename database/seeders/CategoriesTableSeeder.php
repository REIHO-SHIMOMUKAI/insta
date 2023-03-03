<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     private $category;
     public function __construct(Category $category){
        $this->category = $category;
     }

    public function run()
    {
        $categories = [
            [
                'name' => 'Health',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'name' => 'Theatre',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Cooking',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        //insert() - adds multiple records
        $this->category->insert($categories);
    }
}
