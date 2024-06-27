<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class AttributeCalcData extends Data
{
    public function __construct(
        public int      $value,
        public int      $points,
        public int|null $current = null,
    )
    {
    }
}
