<div>
    <div class="mt-4">
        @if(count($uploadedPdfs) > 0)
            @foreach ($uploadedPdfs as $uploadedPdf)
                @if(!empty($uploadedPdf['originalFileName']))
                    <div class="flex justify-between items-center mb-4 border bg-white rounded-md py-2 px-3">
                        <input type="text" class="w-4/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" value="{{ $uploadedPdf['originalFileName'] }}" readonly>
                        <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removePdf(this, '{{ $uploadedPdf['id'] }}')">x</button>
                    </div>
                @endif
            @endforeach
        @endif
        @if(count($pdfs) > 0)
            @foreach ($pdfs as $pdf)
                <livewire:file-upload :pdfId="$pdf['id']" :key="$pdf['id']" />
                <input type="hidden" name="fichiers_temp[]" value="{{ $pdf['tempFilePath'] }}"> 
                <input type="hidden" name="originalFileNames[]" value="{{ $pdf['originalFileName'] }}"> 
            @endforeach
        @endif

        
    </div>

    <button class="hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold" type="button" wire:click="addPdf">Ajouter un PDF</button>
</div>
