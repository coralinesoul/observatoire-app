<?php

namespace App\Http\Controllers;

use \App\Models\Etude;
use \App\Models\Source;
use \App\Models\Type;
use \App\Models\Zone;
use \App\Models\Theme;
use \App\Models\Contact;
use \App\Models\Parametre;
use \App\Models\Matrice;
use \App\Models\User;
use \App\Http\Requests\CatalogueFilterRequest;
use \App\Http\Requests\FormEtudeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CatalogueController extends Controller
{
    
    public function index(Request $request)
{
    $query = Etude::query();

    if ($request->has('source')) {
        $sourceIds = $request->get('source');
        $query->whereHas('sources', function($q) use ($sourceIds) {
            $q->whereIn('id', $sourceIds);
        });
    }

    if ($request->has('theme')) {
        $themeIds = $request->get('theme');
        $query->whereHas('themes', function($q) use ($themeIds) {
            $q->whereIn('id', $themeIds);
        });
    }

    if ($request->has('groupeParametre')) {
        $groupeIds = $request->get('groupeParametre');
        $parametreIds = Parametre::whereIn('groupe', $groupeIds)->pluck('id')->toArray();
        $query->whereHas('parametres', function($q) use ($parametreIds) {
            $q->whereIn('id', $parametreIds);
        });
    }

    if ($request->has('parametre')) {
        $parametreIds = $request->get('parametre');
        $query->whereHas('parametres', function($q) use ($parametreIds) {
            $q->whereIn('id', $parametreIds);
        });
    }

    if ($request->has('groupeMatrice')) {
        $groupeMIds = $request->get('groupeMatrice');
        $matriceIds = Matrice::whereIn('groupe', $groupeMIds)->pluck('id')->toArray();
        $query->whereHas('matrices', function($q) use ($matriceIds) {
            $q->whereIn('id', $matriceIds);
        });
    }

    if ($request->has('matrice')) {
        $matriceIds = $request->get('matrice');
        $query->whereHas('matrices', function($q) use ($matriceIds) {
            $q->whereIn('id', $matriceIds);
        });
    }
    if ($request->has('zone')) {
        $zoneIds = $request->get('zone');
        $query->whereHas('zones', function($q) use ($zoneIds) {
            $q->whereIn('id', $zoneIds);
        });
    }

    if ($request->filled('reglementaire')) {
        $reglementaireFilters = (array) $request->get('reglementaire', []);
        if (in_array('1', $reglementaireFilters) && in_array('0', $reglementaireFilters)) {

        } elseif (in_array('1', $reglementaireFilters)) {
            $query->where('reglementaire', true);
        } elseif (in_array('0', $reglementaireFilters)) {
            $query->where('reglementaire', false);
        }
    }

    if ($request->has('min_year') && $request->has('max_year')) {
        $minYear = $request->get('min_year');
        $maxYear = $request->get('max_year');
        $query->where(function($q) use ($minYear, $maxYear) {
            $q->whereBetween('startyear', [$minYear, $maxYear])
              ->orWhereBetween('stopyear', [$minYear, $maxYear])
              ->orWhere(function($q) use ($minYear, $maxYear) {
                  $q->where('startyear', '<=', $minYear)
                    ->where('stopyear', '>=', $maxYear);
              });
        });
    }
    if ($request->filled('reglementaire')) {
        $reglementaireFilters = (array) $request->get('reglementaire', []);
        if (in_array('1', $reglementaireFilters) && in_array('0', $reglementaireFilters)) {
            
        } elseif (in_array('1', $reglementaireFilters)) {
            $query->where('reglementaire', true);
        } elseif (in_array('0', $reglementaireFilters)) {
            $query->where('reglementaire', false);
        }
    }

    $etudes = $query->paginate(4);
    $allSources = Source::select('id', 'name')->get(); 
    $allThemes = Theme::select('id', 'name')->get(); 
    $allZones = Zone::select('id', 'name')->get(); 
    $allParametres = Parametre::select('id', 'name','groupe')->get(); 
    $allMatrices = Matrice::select('id', 'name','groupe')->get(); 
    $groupesUniques = $allParametres->unique('groupe');
    $groupesMatrices = $allMatrices->unique('groupe');


    return view('catalogue.index', [
        'etudes' => $etudes,
        'allSources' => $allSources,
        'allThemes'=>$allThemes,
        'allZones'=>$allZones,
        'allParametres'=>$allParametres,
        'allMatrices'=>$allMatrices,
        'groupesUniques'=>$groupesUniques,
        'groupesMatrices'=>$groupesMatrices,
    ]);
}
    public function create() {
        $etude = new Etude();
        return view('catalogue.create',[
            'etude'=>$etude,
            'sources'=>Source::select('id','name')->get(),
            'themes'=>Theme::select('id','name')->get(),
            'zones'=>Zone::select('id','name')->get(),
            'types'=>Type::select('id','name')->get(),
            'liens' => $etude->liens()->orderBy('position')->get(),
            'contacts' => $etude->contacts()->get(),
            'parametres' => Parametre::select('*')->get(),
            'matrices' => Matrice::select('*')->get(),
            
        ]);
        
        
    }
    public function store (FormEtudeRequest $request){
        $etude = Etude::create($request->validated());
        $etude-> sources()->sync($request->validated('sources'));
        $etude-> zones()->sync($request->validated('zones'));
        $etude-> themes()->sync($request->validated('themes'));
        $etude-> parametres()->sync($request->validated('parametres'));
        $etude-> matrices()->sync($request->validated('matrices'));
        $etude-> types()->sync($request->validated('types'));

        foreach ($request->link_name as $index => $linkName) {
            $etude->liens()->create([
                'link_name' => $linkName,
                'link_url' => $request->link_url[$index],
                'position' => $index + 1,
            ]);
        }

        $contacts = [];
        if ($request->has('contacts')) {
            foreach ($request->contacts as $contactData) {
                $contact = Contact::firstOrCreate([
                    'nom' => $contactData['nom'],
                    'prenom' => $contactData['prenom'],
                    'mail' => $contactData['mail']
                ], [
                    'diffusion_mail' => $contactData['diffusion_mail']
                ]);
                $contacts[] = $contact->id;
            }
        }
        $etude->contacts()->sync($contacts);
        
        return redirect()->route('catalogue.find',['slug'=> $etude->slug, 'etude'=>$etude->id])->with('success',"L'étude a bien été répertoriée");
    }

    public function edit(Etude $etude) {
        return view('catalogue.edit',[
            'etude'=>$etude,
            'sources'=>Source::select('id','name')->get(),
            'zones'=>Zone::select('id','name')->get(),
            'themes'=>Theme::select('id','name')->get(),
            'types'=>Type::select('id','name')->get(),
            'liens' => $etude->liens()->orderBy('position')->get(),
            'contacts' => $etude->contacts()->get(),
            'parametres' => Parametre::select('*')->get(),
            'matrices' => Matrice::select('*')->get(),
        ]);
    }

    public function find(string $slug, Etude $etude) {
        if($etude->slug !== $slug) {

            return to_route('catalogue.find',['slug'=>$etude->slug,'id'=>$etude->id]);
        }

        return view('catalogue.find', [
            'etude'=>$etude
        ]);
    } 

    public function update(Etude $etude, FormEtudeRequest $request) {
        $etude-> update($request->validated());
        $etude-> sources()->sync($request->validated('sources'));
        $etude-> zones()->sync($request->validated('zones'));
        $etude-> types()->sync($request->validated('types'));
        $etude-> themes()->sync($request->validated('themes'));
        $etude-> parametres()->sync($request->validated('parametres'));
        $etude-> matrices()->sync($request->validated('matrices'));

        $etude->liens()->delete();

        foreach ($request->link_name as $index => $linkName) {
            $etude->liens()->create([
                'link_name' => $linkName,
                'link_url' => $request->link_url[$index],
                'position' => $index + 1,
            ]);
        }

        $contacts = [];
        if ($request->has('contacts')) {
            foreach ($request->contacts as $contactData) {
                $contact = Contact::firstOrCreate([
                    'nom' => $contactData['nom'],
                    'prenom' => $contactData['prenom'],
                    'mail' => $contactData['mail']
                ], [
                    'diffusion_mail' => $contactData['diffusion_mail']
                ]);
                $contacts[] = $contact->id;
            }
        }
        $etude->contacts()->sync($contacts);
    

        return redirect()->route('catalogue.find',['slug'=> $etude->slug, 'etude'=>$etude->id])->with('success',"L'étude a bien été modifiée");
    } 
}
