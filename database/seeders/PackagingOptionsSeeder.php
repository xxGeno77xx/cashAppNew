<?php

namespace Database\Seeders;

use App\Models\PakagingOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackagingOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = ['Entier', 'Demi', 'Quart', 'Quart plus 1', 'Demi plus1'];


        foreach($options as $packaging)
        {
            PakagingOption::firstOrCreate([
                'label' => $packaging, 
            ]);
        }
        
    }
}
