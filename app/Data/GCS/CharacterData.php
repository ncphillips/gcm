<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class CharacterData extends Data
{
    public function __construct(
        public string               $type,
        public int                  $version,
        public int                  $total_points,
        public array                $points_record,
        public CharacterProfileData $profile,
        public array                $settings,
        public array                $traits,
        public string               $created_date,
        public string               $modified_date,
        /** @var Array<AttributeData> */
        public array|null                $attributes = null,
        /** @var Array<SkillData> */
        public array|null                $skills = null,
    )
    {
    }
}
