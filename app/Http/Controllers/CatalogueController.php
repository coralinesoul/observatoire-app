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
    public function find(string $slug, Etude $etude) {
        if($etude->slug !== $slug) {

            return to_route('catalogue.find',['slug'=>$etude->slug,'id'=>$etude->id]);
        }

        return view('catalogue.find', [
            'etude'=>$etude
        ]);
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

    public function store(FormEtudeRequest $request)
    {
        $data = $request->validated();
    
        // Ajout de l'ID de l'utilisateur authentifié
        $data['user_id'] = Auth::id();
        $etude = Etude::create($data);
    
        // Gestion des fichiers
        if ($request->hasFile('fichiers')) {
            foreach ($request->file('fichiers') as $fichier) {
                if ($fichier->isValid()) {
                    // Stockage du fichier dans le répertoire 'fichiers' sous 'public'
                    $chemin = $fichier->store('fichiers', 'public');
                    
                    // Enregistrement des informations du fichier dans la base de données
                    $etude->fichiers()->create([
                        'nom' => $fichier->getClientOriginalName(),
                        'chemin' => $chemin,
                    ]);
                }
            }
        }
    
        // Gestion des autres relations (zones, types, etc.)
        $etude->zones()->sync($request->validated('zones'));
        $etude->themes()->sync($request->validated('themes'));
        $etude->parametres()->sync($request->validated('parametres'));
        $etude->matrices()->sync($request->validated('matrices'));
        $etude->types()->sync($request->validated('types'));
    
        // Envoi de la notification à l'admin si nécessaire
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

    public function update(Etude $etude, FormEtudeRequest $request)
    {
        // Mise à jour des données de l'étude
        $etude->update($this->extractData($etude, $request));
    
        // Gestion des fichiers
        if ($request->hasFile('fichiers')) {
            foreach ($request->file('fichiers') as $fichier) {
                if ($fichier->isValid()) {
                    $chemin = $fichier->store('fichiers', 'public');
                    $etude->fichiers()->create([
                        'nom' => $fichier->getClientOriginalName(),
                        'chemin' => $chemin,
                    ]);
                }
            }
        }
    
        // Suppression des fichiers non sélectionnés par l'utilisateur
        if ($request->has('fichiers_existants')) {
            $fichiersASupprimer = $etude->fichiers()->whereNotIn('nom', $request->fichiers_existants)->get();
            foreach ($fichiersASupprimer as $fichier) {
                Storage::disk('public')->delete($fichier->chemin);
                $fichier->delete();
            }
        } else {
            // Si aucun fichier existant n'est sélectionné, tous les fichiers sont supprimés
            foreach ($etude->fichiers as $fichier) {
                Storage::disk('public')->delete($fichier->chemin);
                $fichier->delete();
            }
        }
    
        // Mise à jour des autres relations comme sources, zones, etc.
        $this->syncRelations($etude, $request);
    
        return redirect()->route('catalogue.find', ['slug' => $etude->slug, 'etude' => $etude->id])
            ->with('success', "L'étude a bien été modifiée");
    }
    
    private function syncRelations(Etude $etude, FormEtudeRequest $request)
    {
        // Synchronisation des relations
        $etude->sources()->sync($this->getIdsForSync($request->sources, 'name', Source::class));
        $etude->zones()->sync($request->validated('zones'));
        $etude->themes()->sync($request->validated('themes'));
        $etude->parametres()->sync($request->validated('parametres'));
        $etude->matrices()->sync($request->validated('matrices'));
        $etude->types()->sync($request->validated('types'));
    }
    
    private function getIdsForSync(array $items, string $field, string $modelClass)
    {
        return array_map(function($item) use ($field, $modelClass) {
            return $modelClass::firstOrCreate([$field => $item])->id;
        }, $items);
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
