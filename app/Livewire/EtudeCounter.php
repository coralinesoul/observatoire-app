<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Etude;
use App\Models\Source;

class EtudeCounter extends Component
{
    public $studyCount;
    public $sourceCount;

    public function mount()
    {
        // Récupère le nombre d'études dans la base de données
        $this->studyCount = Etude::count();
        $this->sourceCount = Source::count();
    }

    public function render()
    {
        return view('livewire.etude-counter');
    }
}

