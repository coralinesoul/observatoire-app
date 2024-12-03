<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Theme;
use App\Models\Parametre;
use App\Models\Matrice;
use App\Models\Etude;

class FormFilter extends Component
{
    public $etude;
    public $selectedThemes = [];
    public $selectedParametres = [];
    public $selectedMatrices = [];
    public $selectedGp = [];
    public $selectedGpM = [];

    public $themes;
    public $parametres;
    public $matrices;
    public $filteredGp;
    public $filteredGpM;
    public $filteredParametres;
    public $filteredMatrices;

    // Méthode de montage pour initialiser les propriétés avec les valeurs passées
    public function mount($etude, $themes, $parametres, $matrices)
    {
        $this->etude = $etude;
        $this->themes = $themes;
        $this->parametres = $parametres;
        $this->matrices = $matrices;
    
        // Charger les valeurs sélectionnées depuis la session ou depuis l'étude
        $this->selectedThemes = session()->get('selectedThemes', $etude->themes()->pluck('id')->toArray());
        $this->selectedParametres = session()->get('selectedParametres', $etude->parametres()->pluck('id')->toArray());
        $this->selectedMatrices = session()->get('selectedMatrices', $etude->matrices()->pluck('id')->toArray());
    
        // Déterminer les groupes sélectionnés
        $this->selectedGp = $this->parametres->whereIn('id', $this->selectedParametres)
                                              ->pluck('groupe')
                                              ->unique()
                                              ->toArray();
    
        $this->selectedGpM = $this->matrices->whereIn('id', $this->selectedMatrices)
                                              ->pluck('groupe')
                                              ->unique()
                                              ->toArray();
    
        // Initialiser les groupes filtrés
        $this->filteredGp = $this->parametres->pluck('groupe')->unique();
        $this->filteredGpM = $this->matrices->pluck('groupe')->unique();
        
        // Initialiser les paramètres et matrices filtrés
        $this->updateFilteredOptions();
    }
    
    public function updateFilteredOptions()
    {
        if (empty($this->selectedThemes)) {
            $this->resetFilters();
            return;
        }
    
        // Filtrer les paramètres selon les thèmes sélectionnés
        $filteredParametres = $this->parametres->filter(function ($parametre) {
            return $parametre->themes->pluck('id')->intersect($this->selectedThemes)->isNotEmpty();
        });
    
        $filteredGp = $filteredParametres->pluck('groupe')->unique();
    
        if (!empty($this->selectedGp)) {
            $filteredParametres = $filteredParametres->filter(function ($parametre) {
                return in_array($parametre->groupe, $this->selectedGp);
            });
        }
    
        $filteredMatrices = $this->matrices->filter(function ($matrice) {
            return $matrice->themes->pluck('id')->intersect($this->selectedThemes)->isNotEmpty();
        });
    
        $filteredGpM = $filteredMatrices->pluck('groupe')->unique();
    
        if (!empty($this->selectedGpM)) {
            $filteredMatrices = $filteredMatrices->filter(function ($matrice) {
                return in_array($matrice->groupe, $this->selectedGpM);
            });
        }
    
        // Désélectionner les groupes qui ne sont plus pertinents
        $this->selectedGp = $filteredGp->filter(fn($groupe) => in_array($groupe, $this->selectedGp))->values()->toArray();
        $this->selectedGpM = $filteredGpM->filter(fn($groupe) => in_array($groupe, $this->selectedGpM))->values()->toArray();
    
        // Désélectionner les paramètres qui ne sont plus pertinents
        $this->selectedParametres = $filteredParametres->pluck('id')->intersect($this->selectedParametres)->values()->toArray();
        $this->selectedMatrices = $filteredMatrices->pluck('id')->intersect($this->selectedMatrices)->values()->toArray();
    
        // Mettre à jour les groupes et matrices filtrés
        $this->filteredParametres = $filteredParametres;
        $this->filteredGp = $filteredGp;
        $this->filteredMatrices = $filteredMatrices;
        $this->filteredGpM = $filteredGpM;
    }
    
    public function saveFiltersInSession()
    {
        session()->put('selectedThemes', $this->selectedThemes);
        session()->put('selectedParametres', $this->selectedParametres);
        session()->put('selectedMatrices', $this->selectedMatrices);
    }

    public function resetFilters()
    {
        $this->filteredGp = collect();
        $this->filteredGpM = collect();
        $this->filteredParametres = collect();
        $this->filteredMatrices = collect();
        $this->selectedGp = [];
        $this->selectedGpM = [];
        $this->selectedParametres = [];
        $this->selectedMatrices = [];
    }

    public function render()
    {
        return view('livewire.form-filter');
    }
}
