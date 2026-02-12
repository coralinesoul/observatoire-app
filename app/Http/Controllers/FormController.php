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
use \App\Models\Fichier;
use \App\Http\Requests\CatalogueFilterRequest;
use \App\Http\Requests\FormEtudeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
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
            'fichiers' => $etude->fichiers()->get(),
            
        ]);
        
        
    }
    public function edit(Etude $etude) {

        $this->authorize('update', $etude);
        
        return view('catalogue.edit',[
            'etude'=>$etude,
            'sources'=>Source::select('id','name')->get(),
            'themes'=>Theme::select('id','name')->get(),
            'types'=>Type::select('id','name')->get(),
            'liens' => $etude->liens()->orderBy('position')->get(),
            'contacts' => $etude->contacts()->get(),
            'zones' => $etude->zones()->pluck('id')->toArray(),
            'parametres' => Parametre::select('*')->get(),
            'matrices' => Matrice::select('*')->get(),
            'fichiers' => $etude->fichiers()->get(),
        ]);
    }
    public function store (FormEtudeRequest $request){
        
        // Création d'une nouvelle instance d'étude (vide)
        $etude = new Etude();

        // Extraction et préparation des données
        $data = $this->extractData($etude, $request);


        // Ajout de l'ID de l'utilisateur authentifié
        $data['user_id'] = Auth::id();
        $etude = Etude::create($data);

        $this->handleFiles($etude, $request);
    
        // Gestion des sources
        $sources = [];
        if ($request->has('sources')) {
            foreach ($request->sources as $sourceData) {
                $source = Source::firstOrCreate(['name' => $sourceData['name']]);
                $sources[] = $source->id;
            }
        }
        $etude->sources()->sync($sources);
        $etude-> zones()->sync($request->validated('zones'));
        $etude-> themes()->sync($request->validated('themes'));
        $etude-> parametres()->sync($request->validated('parametres'));
        $etude-> matrices()->sync($request->validated('matrices'));
        $etude-> types()->sync($request->validated('types'));
        
        
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

            $details = [
                'title' => $etude->title,
                'slug' => $etude->slug,
                'id' => $etude->id,
                'user' => Auth::user()->name,
            ];

            Mail::send('emails.etude_creee', $details, function($message) {
                $message->to('contact@observatoire-golfe-fos.fr')
                        ->subject('Nouvelle étude créée');
            });

            session()->forget('selectedZones');
            session()->forget('selectedThemes');
            session()->forget('selectedParametres');
            session()->forget('selectedMatrices');

            return redirect()->route('catalogue.find',['slug'=> $etude->slug, 'etude'=>$etude->id])->with('success',"L'étude a bien été répertoriée");
    }

    public function update(Etude $etude, FormEtudeRequest $request)
    {
        $this->authorize('update', $etude);
        
        $etude->update($this->extractData($etude, $request));
    
        $this->handleFiles($etude, $request);

        // Gestion des sources
        $sources = [];
        if ($request->has('sources')) {
            foreach ($request->sources as $sourceData) {
                $source = Source::firstOrCreate(['name' => $sourceData['name']]);
                $sources[] = $source->id;
            }
        }
        $etude->sources()->sync($sources);
    

        $etude->themes()->sync($request->validated('themes'));
        $etude->parametres()->sync($request->validated('parametres'));
        $etude->matrices()->sync($request->validated('matrices'));
        $etude->types()->sync($request->validated('types'));
        $etude->zones()->sync($request->validated('zones'));
    
        // Gestion des contacts
        $contacts = [];
        if ($request->has('contacts')) {
            foreach ($request->contacts as $contactData) {
                $contact = Contact::updateOrCreate([
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

        // Gestion des liens
        if ($request->has('link_name')) {
            $existingLinks = $etude->liens->keyBy('id');
            $submittedLinks = collect($request->link_name)->map(function($linkName, $index) use ($request) {
                return [
                    'link_name' => $linkName,
                    'link_url' => $request->link_url[$index] ?? null,
                    'position' => $index + 1,
                ];
            });
    
            // Mettez à jour ou créez les liens
            foreach ($submittedLinks as $submittedLink) {
                $existingLink = $existingLinks->firstWhere('link_name', $submittedLink['link_name']);
    
                if ($existingLink) {
                    // Si le lien existe, on le met à jour s'il a changé
                    if ($existingLink->link_url !== $submittedLink['link_url']) {
                        $existingLink->update($submittedLink);
                    }
                    // Retirer ce lien de la collection des existants pour les traiter
                    $existingLinks->forget($existingLink->id);
                } else {
                    // Sinon, on le crée
                    $etude->liens()->create($submittedLink);
                }
            }
    
            // Supprimer les liens qui n'ont pas été soumis
            foreach ($existingLinks as $linkToRemove) {
                $linkToRemove->delete();
            }
        }
        session()->forget('selectedZones');
        session()->forget('selectedThemes');
        session()->forget('selectedParametres');
        session()->forget('selectedMatrices');
    
        return redirect()->route('catalogue.find', ['slug' => $etude->slug, 'etude' => $etude->id])
            ->with('success', "L'étude a bien été modifiée");
    }
    
    protected function handleFiles(Etude $etude, Request $request)
    {
        // Récupérer les fichiers temporaires envoyés par Livewire
        if ($request->has('fichiers_temp')) {
            foreach ($request->input('fichiers_temp') as $index => $tempFile) {
                // Récupérer le nom original correspondant
                $originalFileName = $request->input('originalFileNames')[$index] ?? 'fichier_inconnu.pdf';
    
                // Vérifier que le fichier temporaire est bien un chemin valide
                if (str_contains($tempFile, 'livewire-tmp')) {
                    // Construire le chemin complet vers le fichier temporaire
                    $tempPath = storage_path('app/' . $tempFile);
    
                    // Vérifier que le fichier existe
                    if (file_exists($tempPath)) {
                        // Déplacer le fichier dans le répertoire final
                        $newPath = Storage::disk('public')->putFile('fichiers', new \Illuminate\Http\File($tempPath));
    
                        if ($newPath) {
                            // Créer une nouvelle entrée dans la table `fichier` avec le nom original
                            $fichier = Fichier::create([
                                'nom' => $originalFileName,
                                'chemin' => $newPath,
                            ]);
    
                            // Associer le fichier à l'étude
                            $etude->fichiers()->attach($fichier->id);
    
                            // Supprimer le fichier temporaire après déplacement
                            unlink($tempPath);
                        }
                    }
                }
            }
        }
        
        // Suppression des fichiers sélectionnés pour la suppression
        if ($request->filled('pdfsToDelete')) {
            $idsToDelete = explode(',', $request->input('pdfsToDelete'));
            foreach ($idsToDelete as $fileId) {
                $fichier = $etude->fichiers()->find($fileId);
                if ($fichier) {
                    // Supprimer le fichier du disque
                    Storage::disk('public')->delete($fichier->chemin);
                    // Supprimer l'entrée dans la base de données
                    $fichier->delete();
                }
            }
        }
    }
    
    private function extractData(Etude $etude, FormEtudeRequest $request): array
    {
        $data = $request->validated();
    
        /** @var \Illuminate\Http\UploadedFile|null $image */
        $image = $request->file('image');
    
        if ($image) {
            // Stocke l'image dans le répertoire 'public/storage/catalogue' et renvoie le chemin
            $imagePath = $image->store('catalogue', 'public');
    
            // Met à jour le tableau de données avec le chemin de l'image
            $data['image'] = $imagePath;
        } elseif ($etude->exists && $etude->image) {
            // Si l'étude existe déjà et qu'elle a une image, conserver l'image actuelle
            $data['image'] = $etude->image;
        } else {
            // Si aucune image n'a été téléchargée et que l'étude est nouvelle, utiliser une image par défaut
            $data['image'] = 'catalogue/default.png';
        }
    
        return $data; // Ensure the method returns the data array
    }
}