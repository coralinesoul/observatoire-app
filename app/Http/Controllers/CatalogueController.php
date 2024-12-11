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
use PDF;


class CatalogueController extends Controller
{
    public function home()
    {
        return view('home');
    }
    public function about()
    {
        return view('about');
    }
    public function index()
    {
        return view('catalogue.index');
    }
    public function user_tab()
    {
        session()->forget('selectedThemes');
        session()->forget('selectedParametres');
        session()->forget('selectedMatrices');
        session()->forget('pdfs');
        session()->forget('uploadedPdfs');

        if (Auth::user()->is_super_user) {
            $etudes = Etude::orderBy('updated_at', 'desc')->get();
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
        // Générer le PDF en utilisant la vue existante
        $pdf = PDF::loadView('catalogue.archive_pdf', [
            'etude' => $etude,
            'pdf' => true,
        ]);
            
        // Définir le chemin et enregistrer le PDF
        $pdfPath = 'pdf/archives/etude_' . $etude->id . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());
        
        // Détacher les relations et supprimer l'étude
        $etude->themes()->detach();
        $etude->zones()->detach();
        $etude->types()->detach();
        $etude->parametres()->detach();
        $etude->matrices()->detach();
        $sources = $etude->sources;
        $contacts = $etude->contacts;
        $etude->sources()->detach();
        $etude->contacts()->detach();
        $etude->liens()->delete();
        $etude->delete();
        
        // Supprimer les sources et contacts non utilisés
        foreach ($sources as $source) {
            if ($source->etudes()->count() === 0) {
                $source->delete();
            }
        }
        foreach ($contacts as $contact) {
            if ($contact->etudes()->count() === 0) {
                    $contact->delete();
            }
        }
        
        return redirect()->route('catalogue.user_tab')->with('success', 'Étude supprimée avec succès.');
    }
    
}
