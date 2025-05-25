<?php
namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CategoryAndProductSeeder extends Seeder
{

    public function run()
    {
        
        DB::table('products')->delete();
        DB::table('categories')->delete();

        
        $data = [
            'Periods Care'                 => [
                'Napkins', 'Menstrual Cups', 'Tampons', 'Panty Liners', 'Intimate Wash / Wipes',
                'Period Pain Relief', 'Sanitary Disposal bags', 'Wet Wipes', 'Moisturizers', 'Period Tablets',
            ],
            'Pregnancy Care'               => [
                'Pregnancy Kits','Support belts, pillows',
            ],
            'Postpartum / after pregnancy' => [
                'Maternity wears', 'Maternity underwear', 'Maternity pads', 'Nipple covers',
                'Nipple cream', 'Postpartum Belly Wraps',
                'Stretch Mark Creams & Oils', 'Feeding Pillows',
                'Perineal Spray / Witch Hazel Pads', 'Breast Pumps',
            ],
            'Sexual Wellness'              => [
                'Condoms', 'Lubricants', 'Vaginal Tightening Gel', 'Intimate Massagers',
            ],
            'Personal Care'                => [
                'Shapewears', 'Lounge wears / night wears', 'Push up bras', 'Padded bras',
                'Butt lifts', 'Waist trainers', 'Breast creams', 'Hair removal creams', 'Razor',
                'Facial hair removal kit', 'Nipple concealers', 'Intimate Bleaching Creams',
                'Acne Spot Treatment Patches', 'Antiaging creams', 'Tan removal creams',
                'Ingrown hair creams', 'Pigmentation creams', 'Tummy control under wears',
                'Dark circle creams', 'Skin whitening cream', 'Lip plumping balm',
            ],
        ];

        foreach ($data as $categoryName => $products) {
            $categoryId = DB::table('categories')->insertGetId([
                'name'       => $categoryName,
                'slug'       => $this->createSlug($categoryName),
                'categor_id' => $this->generateCustomId($categoryName),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($products as $productName) {
                DB::table('products')->insert([
                    'category_id' => $categoryId,
                    'name'        => $productName,
                    'slug'        => $this->createSlug($productName),
                    'desc'        => $productName . ' description.',
                    'image'       => null,
                    'status'      => 1,
                    'product_id'   => $this->generateCustomId($productName),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }

    private function generateCustomId($name, $length = 6)
    {
        $prefix     = 'WMNZ3';
        $shortName  = strtoupper(substr(preg_replace('/\s+/', '', $name), 0, 3));
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random     = '';

        for ($i = 0; $i < $length; $i++) {
            $random .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $prefix . $shortName . $random;
    }

    private function createSlug($string)
    {
        return \Str::slug($string, '-');
    }

}
