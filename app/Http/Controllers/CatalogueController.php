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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EtudeAjouteeNotification;
class CatalogueController extends Controller
{
    public function about()
    {
        return view('catalogue.about');
    }
    public function index()
    {
        return view('catalogue.index');
    }
    public function user_tab()
    {
        if (Auth::user()->is_super_user) {
            $etudes = Etude::all();
        } else {
            $etudes = Auth::user()->etudes;
        }
        return view('catalogue.user_tab', ['etudes' => $etudes]);
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

    public function store (FormEtudeRequest $request)
    {
        $data = $request->validated();
    
        // Ajout de l'ID de l'utilisateur authentifié
        $data['user_id'] = Auth::id();
        $etude = Etude::create($data);
    
        // Gestion des sources
        $sources = [];
        if ($request->has('sources')) {
            foreach ($request->sources as $sourceData) {
                $source = Source::firstOrCreate(['name' => $sourceData['name']]);
                $sources[] = $source->id;
            }
        }
        $etude->sources()->sync($sources);
    
        $etude->zones()->sync($request->validated('zones'));
        $etude->themes()->sync($request->validated('themes'));
        $etude->parametres()->sync($request->validated('parametres'));
        $etude->matrices()->sync($request->validated('matrices'));
        $etude->types()->sync($request->validated('types'));
    
        if (!empty($request->link_name)) {
            foreach ($request->link_name as $index => $linkName) {
                $linkUrl = $request->link_url[$index] ?? null;
    
                // Vérifiez que le nom et l'URL ne sont pas vides avant de créer le lien
                if (!empty($linkName) && !empty($linkUrl)) {
                    $etude->liens()->create([
                        'link_name' => $linkName,
                        'link_url' => $linkUrl,
                        'position' => $index + 1,
                    ]);
                }
            }
        }
    
        // Gestion des sources (second passage)
        $sources = [];
        if ($request->has('sources')) {
            foreach ($request->sources as $sourceData) {
                $source = Source::firstOrCreate(['name' => $sourceData['name']]);
                $sources[] = $source->id;
            }
        }
        $etude->sources()->sync($sources);
    
        // Gestion des contacts
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
    
        $admin = User::find(3); // Récupère l'utilisateur 3
        if ($admin) {
            $admin->notify(new EtudeAjouteeNotification($etude));
        }    
    
        return redirect()->route('catalogue.find', ['slug' => $etude->slug, 'etude' => $etude->id])
            ->with('success', "L'étude a bien été répertoriée");
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

    public function update(Etude $etude, FormEtudeRequest $request)
    {
        $etude->update($this->extractData($etude, $request));

        // Gestion des sources
        $sources = [];
        if ($request->has('sources')) {
            foreach ($request->sources as $sourceData) {
                $source = Source::firstOrCreate(['name' => $sourceData['name']]);
                $sources[] = $source->id;
            }
        }
        // Synchronise les nouvelles et anciennes sources
        $etude->sources()->sync($sources);


        // Gérer les autres relations de la même manière (zones, types, etc.)
        $etude->zones()->sync($request->validated('zones'));
        $etude->themes()->sync($request->validated('themes'));
        $etude->parametres()->sync($request->validated('parametres'));
        $etude->matrices()->sync($request->validated('matrices'));
        $etude->types()->sync($request->validated('types'));

        // Gestion des contacts
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

        return redirect()->route('catalogue.find', ['slug' => $etude->slug, 'etude' => $etude->id])
            ->with('success', "L'étude a bien été modifiée");
    }

    private function extractData(Etude $etude, FormEtudeRequest $request): array
    {
        $data = $request->validated();
        /** @var \Illuminate\Http\UploadedFile|null $image */
        $image = $request->validated('image');

        // Delete the old image if a new image is uploaded
        if ($image !== null && $image->isValid()) {
            if ($etude->image && Storage::disk('public')->exists($etude->image)) {
                Storage::disk('public')->delete($etude->image);
            }
            $data['image'] = $image->store('catalogue', 'public');
        } else {
            if (!isset($etude->image) || empty($etude->image)) {
                $data['image'] = "catalogue/default.png";
            }
        }

        return $data; // Ensure the method returns the data array
    }
    public function destroy(Etude $etude)
    {
        // Détacher les relations dans les tables pivot (mais ne pas supprimer les entrées dans ces tables)
        $etude->themes()->detach();
        $etude->zones()->detach();
        $etude->types()->detach();
        $etude->parametres()->detach();
        $etude->matrices()->detach();
    
        // Détacher les sources et contacts avant de vérifier si elles doivent être supprimées
        $sources = $etude->sources;
        $contacts = $etude->contacts;
    
        // Détacher les sources et contacts
        $etude->sources()->detach();
        $etude->contacts()->detach();
    
        // Supprimer les liens associés
        $etude->liens()->delete();
    
        // Supprimer l'étude elle-même
        $etude->delete();
    
        // Supprimer les sources non utilisées par d'autres études
        foreach ($sources as $source) {
            if ($source->etudes()->count() === 0) {
                $source->delete();
            }
        }
    
        // Supprimer les contacts non utilisés par d'autres études
        foreach ($contacts as $contact) {
            if ($contact->etudes()->count() === 0) {
                $contact->delete();
            }
        }
    
        return redirect()->route('catalogue.user_tab')->with('success', 'Étude supprimée avec succès');
    }    

}
