<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class CharacterProfileData extends Data
{
    public function __construct(
        public string $name,
        public string $age,
        public string $birthday,
        public string $eyes,
        public string $hair,
        public string $skin,
        public string $handedness,
        public string $gender,
        public string $height,
        public string $weight,
        public string $player_name,
        public string $tech_level,
    ) {}
}
