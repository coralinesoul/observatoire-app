<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Source;
use App\Models\Zone;

class FilterComponent extends Component
{
    public $selectedSource;
    public $zones = [];

    public function render()
    {
        // Charger les zones disponibles en fonction de la source sélectionnée
        if ($this->selectedSource) {
            $this->zones = Zone::whereHas('etudes', function ($query) {
                $query->whereHas('sources', function ($q) {
                    $q->where('id', $this->selectedSource);
                });
            })->get();
        } else {
            $this->zones = Zone::all(); // Charger toutes les zones si aucune source n'est sélectionnée
        }

        return view('livewire.filter-component', [
            'sources' => Source::all(),
            'zones' => $this->zones,
        ]);
    }
}