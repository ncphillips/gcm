<?php

namespace Database\Seeders;

use App\Data\GCS\CharacterData;
use App\Models\Character;
use Illuminate\Database\Seeder;

class ExampleGCSCharacterSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop over every .gcs file in  ./character_sheets and decode as JSON
        $files = glob(__DIR__.'/character_sheets/*.gcs');

        foreach ($files as $file) {
            $payloads = json_decode(file_get_contents($file), true);

            $gcs_data = CharacterData::from($payloads);

            Character::create([
                'name' => $gcs_data->profile->name,
                'gcs_data' => $gcs_data,
            ]);
        }
    }
}
