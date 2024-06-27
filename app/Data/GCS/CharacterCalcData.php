<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class CharacterCalcData extends Data
{
    public function __construct(
        public string      $swing,
        public string      $thrust,
        public string      $basic_lift,
        /** @var array<int> */
        public array $move,
        /** @var array<int> */
        public array $dodge,
        public string|null $dodge_bonus = null,
        public string|null $parry_bonus = null,
        public string|null $block_bonus = null,
    )
    {
    }
}
