<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Category;
use DB;

class CatgorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            [
                'categor_id' => 'CAT001',
                'name'       => 'Clothing',
                'slug'       => 'clothing',
                'desc'       => 'Apparel and garments',
                'image'      => null,
                'status'     => 1,
            ],
            [
                'categor_id' => 'CAT002',
                'name'       => 'Beauty',
                'slug'       => 'beauty',
                'desc'       => 'Beauty and personal care products',
                'image'      => null,
                'status'     => 1,
            ],
            [
                'categor_id' => 'CAT003',
                'name'       => 'Jewelry',
                'slug'       => 'jewelry',
                'desc'       => 'Ornaments and accessories',
                'image'      => null,
                'status'     => 1,
            ],
            [
                'categor_id' => 'CAT004',
                'name'       => 'Footwear',
                'slug'       => 'footwear',
                'desc'       => 'Shoes and sandals',
                'image'      => null,
                'status'     => 1,
            ],
            [
                'categor_id' => 'CAT005',
                'name'       => 'Bags',
                'slug'       => 'bags',
                'desc'       => 'Handbags and travel bags',
                'image'      => null,
                'status'     => 1,
            ],
        ];

        Category::insert($categories);
    }
}
