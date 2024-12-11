<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class FileAdd extends Component
{
    public $pdfs = []; // PDFs en cours de téléchargement
    public $uploadedPdfs = []; // PDFs déjà téléchargés

    protected $listeners = ['fileUploaded', 'removePdfFromList'];

    // Lors du montage, récupérer les PDF de la session
    public function mount()
    {
        // Charger les PDFs depuis la session, ou un tableau vide si aucun fichier n'est trouvé
        $this->pdfs = Session::get('pdfs', []);
        $this->uploadedPdfs = Session::get('uploadedPdfs', []);
    }

    // Fonction pour ajouter un PDF
    public function addPdf()
    {
        $this->pdfs[] = ['id' => Str::uuid()->toString(), 'tempFilePath' => '', 'originalFileName' => ''];

    }

    // Fonction pour gérer l'upload du fichier PDF
    public function fileUploaded($payload)
    {
        // Ajouter les détails du fichier (chemin et nom)
        foreach ($this->pdfs as &$pdf) {
            if (empty($pdf['tempFilePath'])) {
                $pdf['tempFilePath'] = $payload['tempFilePath'];
                $pdf['originalFileName'] = $payload['originalFileName'];
                break;
            }
        }

        // Mettre à jour la session avec les PDFs téléchargés
        Session::put('uploadedPdfs', $this->pdfs);
    }

    // Fonction pour rendre la vue du composant
    public function render()
    {
        return view('livewire.file-add');
    }
}
