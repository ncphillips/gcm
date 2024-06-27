<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class SkillCalcData extends Data
{
    public function __construct(
        public int    $level,
        public string $rsl,
    )
    {
    }
}
