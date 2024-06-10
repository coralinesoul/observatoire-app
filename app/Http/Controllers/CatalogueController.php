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

    // Ajouter d'autres filtres ici si nécessaire

    $etudes = $query->paginate(4);
    $allSources = Source::select('id', 'name')->get(); // Pour le formulaire de filtrage

    return view('catalogue.index', [
        'etudes' => $etudes,
        'allSources' => $allSources,
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
