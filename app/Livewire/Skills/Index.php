<?php

namespace App\Livewire\Skills;

use App\Models\Skill;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{

    /**
     * @var Collection<Skill> $skills
     */
    public Collection $skills;

    public function render()
    {
        $this->skills = Skill::all();

        return view('livewire.skills.index')->layout('layouts.app');
    }
}
