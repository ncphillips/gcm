<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class SkillDefaultData extends Data
{
    public function __construct(
        public string $type,
        public int $modifier,
        public ?string $name = null,
        public ?string $specialization = null
    ) {}
}
