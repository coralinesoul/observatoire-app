<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Etude;
use App\Models\Source;

class Filter extends Component
{
    public $selectedOption = [];
    public $etudes;

    public function mount()
    {
        $this->getselect();
    }

    public function getselect()
    {
        if (empty($this->selectedOption)) {
            // Si aucune source n'est sélectionnée, retourner toutes les études avec leurs sources
            $this->etudes = Etude::with('sources')->get();
        } else {
            // Filtrer les études en fonction des sources sélectionnées
            $this->etudes = Etude::with('sources')->whereHas('sources', function ($query) {
                $query->whereIn('id', $this->selectedOption);
            })->get();
        }
    }

    public function render()
    {
        return view('livewire.filter', ['etudes' => $this->etudes]);
    }
}
