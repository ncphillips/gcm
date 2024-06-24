<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class GCSSkillListData extends Data
{
    public function __construct(
        public string $type,
        public int $version,
        #[DataCollectionOf(SkillData::class)]
        public array $rows,
    ) {
    }
}
