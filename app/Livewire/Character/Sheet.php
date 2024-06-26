<?php

namespace App\Livewire\Character;

use App\Models\Character;
use Livewire\Component;

class Sheet extends Component
{
    public Character $character;

    public function render()
    {
        return view('livewire.characters.sheet');
    }
}
