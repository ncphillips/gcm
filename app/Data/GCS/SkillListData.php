<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class SkillListData extends Data
{
    public function __construct(
        public string $type,
        public int $version,
        #[DataCollectionOf(SkillData::class)]
        public array $rows,
    ) {
    }
}
