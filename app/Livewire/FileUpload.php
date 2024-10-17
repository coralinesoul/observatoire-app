<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public $file;
    public $tempFilePath;
    public $originalFileName;
    public $pdfId;

    public function updatedFile()
    {
        // Réinitialiser les erreurs avant la validation
        $this->resetErrorBag('file');

        $this->validate([
            'file' => 'required|mimes:pdf|max:20480',  // Validation du fichier PDF
        ]);

        // Enregistrer temporairement le fichier dans livewire-tmp
        $this->tempFilePath = $this->file->store('livewire-tmp');
        $this->originalFileName = $this->file->getClientOriginalName();

        $this->dispatch('fileUploaded', [
            'tempFilePath' => $this->tempFilePath,
            'originalFileName' => $this->originalFileName
        ]);

    }

    public function removePdf()
    {
        // Émettre un événement vers le composant parent pour retirer l'entrée PDF
        $this->dispatch('removePdfFromList', $this->pdfId);
    }

    public function render()
    {
        return view('livewire.file-upload');
    }
}
