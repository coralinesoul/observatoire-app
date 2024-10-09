<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Etude;

class EtudeCounter extends Component
{
    public $studyCount;

    public function mount()
    {
        // Récupère le nombre d'études dans la base de données
        $this->studyCount = Etude::count();
    }

    public function render()
    {
        return view('livewire.etude-counter');
    }
}

