<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use \App\Models\User;

class AuthController extends Controller
{

    public function submitDemande(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'resume' => 'required|string',
        ]);

        // Préparer les détails de l'email
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'resume' => $request->resume,
            'validation_url' => URL::signedRoute('auth.demande.validate', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]),
        ];

        // Envoi de l'email avec la vue Blade 'emails.demande_validation'
        Mail::send('emails.demande_validation', $details, function($message) {
            $message->to('contact@observatoire-golfe-fos.fr')
                    ->subject('Nouvelle demande de création de compte');
        });

        return back()->with('success', 'Votre demande a été envoyée.');
    }

    public function validateDemande(Request $request)
    {
        // Vérifier que l'URL est bien signée
        if (!$request->hasValidSignature()) {
            abort(401, 'Lien de validation invalide ou expiré.');
        }

        // Vérifier que l'email n'est pas déjà utilisé
        if (User::where('email', $request->email)->exists()) {
            return redirect()->route('catalogue.index')->with('error', 'Ce compte existe déjà.');
        }

        // Créer l'utilisateur dans la base de données
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Déjà hashé dans l'URL
        ]);

        return redirect()->route('catalogue.index')->with('success', 'Le compte utilisateur a été créé avec succès.');
    }

    // Afficher le formulaire de demande de création de compte
    public function showDemandeForm()
    {
        return view('auth.demande_compte');
    }

    // Gérer la soumission du formulaire et envoyer un email
    public function handleRegisterRequest(Request $request)
    {
        // Valider les données
        $request->validate([
            'email' => 'required|email',
            'structure' => 'required|string|max:255',
            'resume' => 'required|string',
        ]);

        // Envoyer l'email
        Mail::raw("Nouvelle demande de compte :\n\nEmail: {$request->email}\nStructure: {$request->structure}\nRésumé: {$request->resume}", function ($message) use ($request) {
            $message->to('contact@observatoire-golfe-fos.fr')
                    ->subject('Nouvelle demande de création de compte');
        });

        return redirect()->route('catalogue.index')->with('success', 'Votre demande a été envoyée. Nous vous contacterons sous peu.');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('catalogue.index'));
        }

        return to_route('auth.login')->withErrors([
            'email' => "Identifiant(s) invalide(s)"
        ])->onlyInput('email');
    }
}
