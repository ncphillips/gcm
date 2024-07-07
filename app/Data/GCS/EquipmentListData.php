<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class EquipmentListData extends Data
{
    public function __construct(
        public string $type,
        public int $version,
        #[DataCollectionOf(EquipmentData::class)]
        public array $rows,
    ) {
    }
}
