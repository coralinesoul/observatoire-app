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

class CatalogueController extends Controller
{
    public function about()
    {
        return view('home');
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
    public function find(string $slug, Etude $etude) {
        if($etude->slug !== $slug) {

            return to_route('catalogue.find',['slug'=>$etude->slug,'id'=>$etude->id]);
        }

        return view('catalogue.find', [
            'etude'=>$etude
        ]);
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
