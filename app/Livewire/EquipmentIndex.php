<?php

namespace App\Livewire;

use App\Models\Equipment;
use Illuminate\Support\Collection;
use Livewire\Component;

class EquipmentIndex extends Component
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
