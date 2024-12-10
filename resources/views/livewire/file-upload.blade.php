<div class="relative flex items-center rounded-md border border-[#e0e0e0] bg-white py-3 px-3 mb-6 text-base text-[#6B7280] outline-none">
    <input type="file" wire:model="file">
    
    @if ($file)
        <progress max="100" value="0" wire:loading wire:target="file"></progress>
        <span wire:loading wire:target="file">Chargement...</span>
    @endif
    @error('file') <span class="text-red-500">{{ $message }}</span> @enderror
    <button class="ml-auto border justify-end font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" wire:click="removePdf">x</button>
</div>
