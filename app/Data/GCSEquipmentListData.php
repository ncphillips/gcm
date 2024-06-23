<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class GCSEquipmentListData extends Data
{
    public function __construct(
        public string $type,
        public int $version,
        #[DataCollectionOf(EquipmentData::class)]
        public array $rows,
    ) {
    }
}
