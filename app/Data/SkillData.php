<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class SkillData extends Data
{
    public function __construct(
        public string $type,
        public string $name,
        public string $reference,
        public string $difficulty,
        public ?array $defaults = [],
        public ?string $tech_level = null,
        public ?string $specialization = null
    ) {}
}
