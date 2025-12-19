<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Coiffure',
            'Couches',
            'Defrisant',
            'Savons & OMO',
            'Biscuits',
            'Chaussures',
            'Meches',
            'Ustensiles',
            'Nutrition',
            'Liqueurs',
            'Vins',
            'Canettes',
            'Sacs',
        ];

        foreach ($categories as $key => $categorie) {
            Categorie::firstOrCreate([

                'nom' => $categorie,
                'description' => '',

            ]);
        }
    }
}
