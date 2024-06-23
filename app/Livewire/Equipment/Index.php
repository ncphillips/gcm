<?php

namespace App\Livewire\Equipment;

use App\Models\Equipment;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{

    /**
     * @var Collection<Equipment>
     */
    public Collection $equipment;

    public function render()
    {
        $this->equipment = Equipment::all();

        return view('livewire.equipment.index')->layout('layouts.app');
    }
}
