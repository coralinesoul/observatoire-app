<?php

namespace App\Http\Livewire;

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

    // Initialiser les valeurs sélectionnées
    $this->selectedThemes = $etude->themes()->pluck('id')->toArray();
    $this->selectedParametres = $etude->parametres()->pluck('id')->toArray();
    $this->selectedMatrices = $etude->matrices()->pluck('id')->toArray();

    // Déterminer les groupes sélectionnés en fonction des paramètres déjà choisis
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

    // Filtrer les paramètres en fonction des thèmes sélectionnés
    $filteredParametres = $this->parametres->filter(function ($parametre) {
        return $parametre->themes->pluck('id')->intersect($this->selectedThemes)->isNotEmpty();
    });

    // Filtrer les groupes de paramètres en fonction des paramètres filtrés
    $filteredGp = $filteredParametres->pluck('groupe')->unique();

    // Appliquer un filtrage supplémentaire des paramètres basé sur les groupes sélectionnés
    if (!empty($this->selectedGp)) {
        $filteredParametres = $filteredParametres->filter(function ($parametre) {
            return in_array($parametre->groupe, $this->selectedGp);
        });
    }

    // Même logique pour les matrices
    $filteredMatrices = $this->matrices->filter(function ($matrice) {
        return $matrice->themes->pluck('id')->intersect($this->selectedThemes)->isNotEmpty();
    });

    $filteredGpM = $filteredMatrices->pluck('groupe')->unique();

    if (!empty($this->selectedGpM)) {
        $filteredMatrices = $filteredMatrices->filter(function ($matrice) {
            return in_array($matrice->groupe, $this->selectedGpM);
        });
    }

    // Désélectionner les paramètres/matrices non pertinents
    $this->selectedGp = array_values(array_filter($this->selectedGp, function ($groupe) use ($filteredGp) {
        return $filteredGp->contains($groupe);
    }));

    $this->selectedGpM = array_values(array_filter($this->selectedGpM, function ($groupe) use ($filteredGpM) {
        return $filteredGpM->contains($groupe);
    }));

    $this->selectedParametres = array_values(array_filter($this->selectedParametres, function ($parametreId) use ($filteredParametres) {
        return $filteredParametres->contains('id', $parametreId);
    }));

    $this->selectedMatrices = array_values(array_filter($this->selectedMatrices, function ($matriceId) use ($filteredMatrices) {
        return $filteredMatrices->contains('id', $matriceId);
    }));

    $this->filteredGp = $filteredGp;
    $this->filteredGpM = $filteredGpM;
    $this->filteredParametres = $filteredParametres;
    $this->filteredMatrices = $filteredMatrices;
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
