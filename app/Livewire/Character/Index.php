<?php

namespace App\Livewire\Character;

use App\Models\Character;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{
    /**
     * @var Collection<Character>
     */
    public Collection $characters;

    public function render()
    {
        $this->characters = Character::all();

        return view('livewire.characters.index');
    }
}
