<?php

namespace Database\Seeders;

use App\Data\GCS\EquipmentData;
use App\Data\GCS\EquipmentListData;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class GCSEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basic_set_equipment = "https://raw.githubusercontent.com/richardwilkes/gcs_master_library/master/Library/Basic%20Set/Basic%20Set%20Equipment.eqp";

        $equipment = EquipmentListData::from(json_decode(file_get_contents($basic_set_equipment), true));

        // Iterate through and add to Equipment
        foreach ($equipment->rows as $item) {
            try {
                Equipment::create(EquipmentData::from($item)->toArray());
            } catch (\Exception $e) {
                dd($item);
            }
        }

    }
}
