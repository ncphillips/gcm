<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class CharacterCalcData extends Data
{
    public function __construct(
        public string $swing,
        public string $thrust,
        public string $basic_lift,
        public array $move,
        public array $dodge,
    ) {}
}
