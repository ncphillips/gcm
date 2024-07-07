<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class EquipmentData extends Data
{
    public function __construct(
        public string $description,
        public string $reference = '',
        public string $notes = '',
        public string $tech_level = '',
        public float  $value = 0,
        public string $weight = '',
    )
    {
    }
}
