<?php

namespace App\Livewire\Character;

use App\Models\Character;
use Livewire\Component;

class Show extends Component
{

    public Character $character;

    public function mount(Character $character)
    {
        $this->character = $character;
    }

    public function render()
    {
        return view('livewire.characters.show');
    }
}
