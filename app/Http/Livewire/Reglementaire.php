<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Etude;
class Reglementaire extends Component
{
    
    public $selectedOption ='all';

    public function getselect()
    {
        $this->selectedOption ;
    }

    public function render()
    {
        if ($this->selectedOption !== 'all') {
            $etudes = Etude::where('reglementaire', $this->selectedOption)->get();
        } else {
            $etudes = Etude::all();
        }

        return view('livewire.reglementaire', [
            'etudes' => $etudes]);
    }
}
