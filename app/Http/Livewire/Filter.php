<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \App\Models\Etude;
use \App\Models\Source;
use \App\Models\Type;
use \App\Models\Zone;
use \App\Models\Theme;
use \App\Models\Parametre;
use \App\Models\Matrice;


class Filter extends Component
{
    public $etudes;

    public $selectedTheme = [];
    public $selectedSource = [];
    public $selectedParametre = [];
    public $selectedMatrice = [];
    public $selectedZone = [];
    public $selectedType = [];
    public $selectedReglementaire =[];
    public $selectedFrequence =[];
    public $selectedStartyear =1960;
    public $selectedStopyear = 2024;

    public $themes;
    public $sources;
    public $parametres;
    public $matrices;
    public $zones;
    public $types;

    public function mount()
    {
        $this->themes = Theme::all();
        $this->sources = Source::all();
        $this->parametres = Parametre::all();
        $this->matrices = Matrice::all();
        $this->zones = Zone::all();
        $this->types = Type::all();

        $this->getselect();
    }

    public function getselect()
    
    {
    
        if (empty($this->selectedSource)  
            && empty($this->selectedTheme) 
            && empty($this->selectedParametre)
            && empty($this->selectedMatrice)
            && empty($this->selectedZone)
            && empty($this->selectedType)
            && empty($this->selectedReglementaire)
            && empty($this->selectedFrequence)
            && ($this->selectedStartyear == 1960 && $this->selectedStopyear == 2024)) {
            // Si aucune source et aucun thème ne sont sélectionnés, retourner toutes les études avec leurs sources et thèmes
            $this->etudes = Etude::with('sources', 'themes','parametres','matrices','zones','types')->get();
        } else {
            // Filtrer les études en fonction des sources et des thèmes sélectionnés
            $this->etudes = Etude::with('sources', 'themes','parametres','matrices','zones','types')
                ->when(!empty($this->selectedSource), function ($query) {
                    $query->whereHas('sources', function ($query) {
                        $query->whereIn('id', $this->selectedSource);
                    });
                })
                ->when(!empty($this->selectedTheme), function ($query) {
                    $query->whereHas('themes', function ($query) {
                        $query->whereIn('id', $this->selectedTheme);
                    });
                })
                ->when(!empty($this->selectedParametre), function ($query) {
                    $query->whereHas('parametres', function ($query) {
                        $query->whereIn('id', $this->selectedParametre);
                    });
                })
                ->when(!empty($this->selectedMatrice), function ($query) {
                    $query->whereHas('matrices', function ($query) {
                        $query->whereIn('id', $this->selectedMatrice);
                    });
                })
                ->when(!empty($this->selectedZone), function ($query) {
                    $query->whereHas('zones', function ($query) {
                        $query->whereIn('id', $this->selectedZone);
                    });
                })
                ->when(!empty($this->selectedType), function ($query) {
                    $query->whereHas('types', function ($query) {
                        $query->whereIn('id', $this->selectedType);
                    });
                })
                ->when(!empty($this->selectedReglementaire), function ($query) {
                    $query->whereIn('reglementaire', $this->selectedReglementaire);
                })
                ->when(!empty($this->selectedFrequence), function ($query) {
                    $query->whereIn('frequence', $this->selectedFrequence);
                })
                ->when($this->selectedStartyear != 1960 || $this->selectedStopyear != 2024, function ($query) {
                    $query->where('startyear', '>=', $this->selectedStartyear)
                          ->where('stopyear', '<=', $this->selectedStopyear);
                })
            
                ->get();
        }
    }

    public function render()
    {

        return view('livewire.filter', 
            ['etudes' => $this->etudes, 
            'sources' => $this->sources, 
            'parametres' => $this->parametres,
            'matrices' => $this->matrices,
            'zones' => $this->zones,
            'types' => $this->types]
        );
    }
}
