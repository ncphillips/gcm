<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class AttributeData extends Data
{
    public function __construct(
        public string $attr_id,
        public int    $adj,
        public AttributeCalcData $calc,
    )
    {
    }
}
