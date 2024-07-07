<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class SkillData extends Data
{
    public function __construct(
        public string                $type,
        public SkillCalcData|null    $calc = null,
        public string|null           $difficulty = null,
        public SkillDefaultData|null $defaulted_from = null,
        /** @var string[]|null */
        public array|null            $tags = null,
        /** @var Array<SkillDefaultData>|null */
        public array|null            $defaults = null,
        public SkillDefaultData|null $technique_default = null,
        public string|null           $name = '',
        public string|null           $reference = '',
        public string|null           $reference_highlight = '',
        public ?string               $tech_level = null,
        public ?string               $specialization = null,
        public ?int                  $points = null,
        public ?int                  $limit = null,
        public ?int                  $encumbrance_penalty_multiplier = null,
        /** @var SkillData[]|null */
        public array|null            $children = null
    )
    {
    }

    public function isContainer(): bool
    {
        return $this->type === 'skill_container';
    }
}
