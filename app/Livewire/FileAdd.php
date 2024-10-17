<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class FileAdd extends Component
{
    public $pdfs = [];

    protected $listeners = ['fileUploaded', 'removePdfFromList'];

    public function addPdf()
    {
        // Ajouter un identifiant unique à chaque PDF pour garder la cohérence
        $this->pdfs[] = ['id' =>  Str::uuid()->toString(), 'tempFilePath' => '', 'originalFileName' => ''];
    }

    public function removePdfFromList($id)
    {
        $this->pdfs = array_values(array_filter($this->pdfs, function ($pdf) use ($id) {
            return $pdf['id'] !== $id;
        }));
    }

    public function fileUploaded($payload)
    {
        // Chercher l'entrée PDF à mettre à jour par rapport à l'ID et ajouter le chemin et le nom
        foreach ($this->pdfs as &$pdf) {
            if (empty($pdf['tempFilePath'])) {
                $pdf['tempFilePath'] = $payload['tempFilePath'];
                $pdf['originalFileName'] = $payload['originalFileName'];
                break;
            }
        }
    }

    public function render()
    {
        return view('livewire.file-add');
    }
}

