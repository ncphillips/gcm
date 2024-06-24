<?php

namespace Database\Seeders;

use App\Data\GCSSkillListData;
use App\Data\SkillData;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class GCSBasicSetSkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gcs_basic_set_skills_url = "https://raw.githubusercontent.com/richardwilkes/gcs_master_library/master/Library/Basic%20Set/Basic%20Set%20Skills.skl";

        $skills = GCSSkillListData::from(json_decode(file_get_contents($gcs_basic_set_skills_url), true));

        foreach ($skills->rows as $skill) {
            try {
                Skill::create(SkillData::from($skill)->toArray());
            } catch (\Exception $e) {
                dd($skill);
            }
        }

    }
}
