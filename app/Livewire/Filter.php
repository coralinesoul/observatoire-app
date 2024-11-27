<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Etude;
use App\Models\Theme;
use App\Models\Source;
use App\Models\Parametre;
use App\Models\Matrice;
use App\Models\Type;
use App\Models\Zone;

class Filter extends Component
{
    use WithPagination;

    public $sources;
    public $themes;
    public $parametres;
    public $matrices;
    public $zones;
    public $types;

    public $selectedSource = [];
    public $selectedTheme = [];
    public $selectedParametre = [];
    public $selectedMatrice = [];
    public $selectedGp = [];
    public $selectedGpM = [];
    public $selectedZone = [];
    public $selectedType = [];
    public $selectedReglementaire = [];
    public $selectedFrequence = [];
    public $selectedStartyear = 1960;
    public $selectedStopyear = 2024;


    public $filteredParametres;
    public $filteredGp;
    public $filteredMatrices;
    public $filteredGpM;

    public function mount()
    {
        // Charger toutes les sources disponibles au montage du composant
        $this->sources = Source::all();
        $this->themes = Theme::all();
        $this->parametres = Parametre::all();
        $this->matrices = Matrice::all();
        $this->filteredGp = $this->parametres->pluck('groupe')->unique();
        $this->filteredGpM = $this->matrices->pluck('groupe')->unique();
        $this->types = Type::all();
    }

    public function updateSelectedZone($zoneId)
    {
        // Si la zone est déjà dans la liste, la retirer (désélectionner)
        if (in_array($zoneId, $this->selectedZone)) {
            $this->selectedZone = array_values(array_diff($this->selectedZone, [$zoneId]));
        } else {
            // Si la zone n'est pas dans la liste, l'ajouter (sélectionner)
            $this->selectedZone[] = $zoneId;
            $this->selectedZone = array_values($this->selectedZone); // Réindexe l'array
        }
    }
    

    public function updateFilteredOptions()
    {
        // Initialiser les variables de filtre
        $filteredGp = collect();
        $filteredParametres = collect();
        $filteredGpM = collect();
        $filteredMatrices = collect();

        // Récupérer tous les groupes disponibles si aucun thème n'est sélectionné
        if (empty($this->selectedTheme)) {
            $filteredGp = $this->parametres->pluck('groupe')->unique();
            $filteredGpM = $this->matrices->pluck('groupe')->unique();
        } else {
            // Filtrer les groupes de paramètres et les paramètres en fonction des thèmes sélectionnés
            $filteredParametres = $this->parametres->filter(function($parametre) {
                return $parametre->themes->pluck('id')->intersect($this->selectedTheme)->isNotEmpty();
            });

            // Extraire les groupes uniques à partir des paramètres filtrés
            $filteredGp = $filteredParametres->pluck('groupe')->unique();

            // Filtrer les matrices et les groupes de matrices en fonction des thèmes sélectionnés
            $filteredMatrices = $this->matrices->filter(function($matrice) {
                return $matrice->themes->pluck('id')->intersect($this->selectedTheme)->isNotEmpty();
            });

            // Extraire les groupes uniques à partir des matrices filtrées
            $filteredGpM = $filteredMatrices->pluck('groupe')->unique();
        }

        // Filtrage des paramètres basés sur les groupes de paramètres sélectionnés
        if (!empty($this->selectedGp)) {
            // Si des groupes de paramètres sont sélectionnés, affiner le filtrage des paramètres
            $filteredParametres = $this->parametres->filter(function($parametre) {
                return in_array($parametre->groupe, $this->selectedGp);
            });
        } else {
            // Si aucun groupe n'est sélectionné, vider les paramètres pour ne pas les afficher
            $filteredParametres = collect();
        }

        // Filtrage des matrices basés sur les groupes de matrices sélectionnés
        if (!empty($this->selectedGpM)) {
            // Si des groupes de matrices sont sélectionnés, affiner le filtrage des matrices
            $filteredMatrices = $this->matrices->filter(function($matrice) {
                return in_array($matrice->groupe, $this->selectedGpM);
            });
        } else {
            // Si aucun groupe n'est sélectionné, vider les matrices pour ne pas les afficher
            $filteredMatrices = collect();
        }

        // Mise à jour des listes filtrées
        $this->filteredGp = $filteredGp;
        $this->filteredGpM = $filteredGpM;

        // Filtrer les paramètres pour s'assurer qu'ils sont associés à une étude
        $this->filteredParametres = $filteredParametres->filter(function($parametre) {
            return $this->getSelect()->contains(function($etude) use ($parametre) {
                return $etude->parametres->contains('id', $parametre->id);
                });
            });
        
            // Filtrer les matrices pour s'assurer qu'elles sont associées à une étude
            $this->filteredMatrices = $filteredMatrices->filter(function($matrice) {
                return $this->getSelect()->contains(function($etude) use ($matrice) {
                    return $etude->matrices->contains('id', $matrice->id);
                });
            });

        $this->resetPage();

    }

    public function getSelect()
    {
        // Récupérer les études filtrées par source 'IECP' avec pagination
        return Etude::with('sources', 'themes', 'parametres', 'matrices', 'zones', 'types')
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
            ->when(!empty($this->selectedGp), function ($query) {
                $query->whereHas('parametres', function($query) {
                    $query->whereIn('groupe', $this->selectedGp);
                });
            })
            ->when(!empty($this->selectedParametre), function ($query) {
                $query->whereHas('parametres', function ($query) {
                    $query->whereIn('id', $this->selectedParametre);
                });
            })
            ->when(!empty($this->selectedGpM), function ($query) {
                $query->whereHas('matrices', function($query) {
                    $query->whereIn('groupe', $this->selectedGpM);
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
            ->when($this->selectedStartyear != 1960 || $this->selectedStopyear != 2024, function ($query) {
                $query->where(function ($query) {
                    $query->where(function ($query) {
                        // Exclut les études qui commencent et se terminent après `stopyear`
                        $query->where('startyear', '<', $this->selectedStopyear)
                              ->orWhere('stopyear', '<', $this->selectedStopyear);
                    })
                    ->where(function ($query) {
                        // Exclut les études qui commencent et se terminent avant `startyear`
                        $query->where('startyear', '>', $this->selectedStartyear)
                              ->orWhere('stopyear', '>', $this->selectedStartyear);
                    });
                });
            })
            ->when(!empty($this->selectedReglementaire), function ($query) {
                $query->whereIn('reglementaire', $this->selectedReglementaire);
            })
            ->when(!empty($this->selectedFrequence), function ($query) {
                $query->whereIn('frequence', $this->selectedFrequence);
            })
            ->paginate(16);
    }
    public function removeSelection($type, $value)
    {
        // Supprime la sélection correspondante en fonction du type
        if ($type == 'selectedSource') {
            $this->selectedSource = array_filter($this->selectedSource, fn($v) => $v != $value);
        } elseif ($type == 'selectedTheme') {
            $this->selectedTheme = array_filter($this->selectedTheme, fn($v) => $v != $value);
        } elseif ($type == 'selectedParametre') {
            $this->selectedParametre = array_filter($this->selectedParametre, fn($v) => $v != $value);
        } elseif ($type == 'selectedMatrice') {
            $this->selectedMatrice = array_filter($this->selectedMatrice, fn($v) => $v != $value);
        } elseif ($type == 'selectedZone') {
            $this->selectedZone = array_filter($this->selectedZone, fn($v) => $v != $value);
        } elseif ($type == 'selectedType') {
            $this->selectedType = array_filter($this->selectedType, fn($v) => $v != $value);
        } elseif ($type == 'selectedReglementaire') {
            $this->selectedReglementaire = array_filter($this->selectedReglementaire, fn($v) => $v != $value);
        } elseif ($type == 'selectedFrequence') {
            $this->selectedFrequence = array_filter($this->selectedFrequence, fn($v) => $v != $value);
        } elseif ($type == 'selectedGp') {
            $this->selectedGp = array_filter($this->selectedGp, fn($v) => $v != $value);
        } elseif ($type == 'selectedGpM') {
            $this->selectedGpM = array_filter($this->selectedGpM, fn($v) => $v != $value);
        }

        $this->updateFilteredOptions();
    }

    public function resetYears()
    {
        $this->selectedStartyear = 1960;
        $this->selectedStopyear = 2024;
        $this->updateFilteredOptions();
    }



    public function render()
    {
        // Utilisation de la méthode pour récupérer les études filtrées
        $etudes = $this->getSelect();

        return view('livewire.filter', [
            'etudes' => $etudes,
            'sources' => $this->sources,
            'themes' => $this->themes,
            'parametres' => $this->filteredParametres,
            'matrices' => $this->filteredMatrices,
            'zones' => $this->zones,
            'types' => $this->types,
        ]);
    }
}
