<div>
    {{-- Afficher une nouvelle div à chaque ajout --}}
    <div class="mt-4">
        @foreach ($pdfs as $pdf)
                <livewire:file-upload :pdfId="$pdf['id']" :key="$pdf['id']" />
                <input type="hidden" name="fichiers_temp[]" value="{{ $pdf['tempFilePath'] }}"> 
                <input type="hidden" name="originalFileNames[]" value="{{ $pdf['originalFileName'] }}"> 
        @endforeach
    </div>

    <button class="hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold" type="button" wire:click="addPdf">Ajouter un PDF</button>
</div>
