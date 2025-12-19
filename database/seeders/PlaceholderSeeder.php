<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PlaceholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::delete(Storage::files('public/'));

        $files = File::files(public_path('images'));

        foreach ($files as $file) {

            $filename = $file->getFilename();

            $fileContent = file_get_contents($file->getPathname());

            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            Storage::put('public/'.$filename, $fileContent);

        }
    }
}
