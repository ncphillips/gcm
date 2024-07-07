<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class SkillDefaultData extends Data
{
    public function __construct(
        public string $type,
        public ?int $modifier,
        public ?int $level = null,
        public ?int $adjusted_level = null,
        public ?string $name = null,
        public ?string $specialization = null
    ) {}
}
