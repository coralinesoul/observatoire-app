<div>
    <div>
        @if(
            !empty($selectedParametres)
        )
                    <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Paramètres :</h2>
                    @foreach($selectedParametres as $parametreId)
                        <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue1 px-1.5 py-0.5 text-sm font-medium text-white my-1 ml-2">
                            {{ \App\Models\Parametre::find($parametreId)->name }}
                        </span>
                    @endforeach
        @endif
        @if(
            !empty($selectedMatrices)
        )
            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Matrices :</h2>
                @foreach($selectedMatrices as $matriceId)
                    <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue2 px-1.5 py-0.5 text-sm font-medium text-white my-1 ml-2">
                        {{ \App\Models\Matrice::find($matriceId)->name }}
                    </span>
                @endforeach
        @endif
    </div>
    <div class="rounded-none bg-blue2 bg-opacity-5 shadow-md p-6">
        <div>
            <label class="m-1 block text-base font-medium text-blue1" for="theme">Thème(s)</label>
            @foreach($themes as $theme)
                <div class="flex items-center">
                    <input type="checkbox" id="theme_{{ $theme->id }}" name="themes[]" value="{{ $theme->id }}" 
                           wire:model="selectedThemes" wire:change="updateFilteredOptions">
                    <label for="theme_{{ $theme->id }}" class="ml-2 text-sm text-gray-700">{{ $theme->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3">
            <div class="px-6 pt-3">
                @if(!empty($selectedThemes) && count($selectedThemes) > 0 && count($filteredGp)>0)
                    <label class="m-1 block text-base font-medium text-blue1" for="parametre">Type(s) de paramètre(s) suivi(s)</label>
                    @foreach($filteredGp as $groupe)
                        <div class="flex items-center">
                            <input type="checkbox" id="{{$groupe}}" name="selectedGp" value="{{$groupe}}" wire:model="selectedGp" wire:change="updateFilteredOptions" wire:model="selectedParametres">
                            <label class="ml-2 text-sm text-gray-700">{{$groupe}}</label>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="px-6 pt-3">
                @if(!empty($selectedGp) && count($selectedGp) > 0 && count($filteredParametres)>0)
                    <label class="m-1 block text-base font-medium text-blue1" for="parametre">Paramètre(s) suivi(s)</label>
                    @foreach($filteredParametres as $parametre)
                        <div class="flex items-center">
                            <input type="checkbox" id="parametre_{{ $parametre->id }}" name="parametres[]" value="{{ $parametre->id }}"
                            wire:model="selectedParametres" wire:change="updateFilteredOptions" class="h-4 w-4 text-blue2 border-gray-300 rounded focus:ring-blue2"
                                @if(in_array($parametre->id, $selectedParametres)) checked @endif>
                            <label for="parametre_{{ $parametre->id }}" class="ml-2 text-sm text-gray-700">{{ $parametre->name }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3">
            <div class="px-6 pt-3" >
                @if(!empty($selectedThemes) && count($selectedThemes) > 0 && count($filteredGpM)>0)
                    <label class="m-1 block text-base font-medium text-blue1">Type(s) de matrice(s) suivie(s)</label>
                    @foreach($filteredGpM as $groupe)
                        <div class="flex items-center">
                            <input type="checkbox" id="{{$groupe}}" name="selectedGpM" value="{{$groupe}}" wire:model="selectedGpM" wire:change="updateFilteredOptions" wire:model="selectedParametres">
                            <label class="ml-2 text-sm text-gray-700">{{$groupe}}</label>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="px-6 pt-3">
                @if(!empty($selectedGpM) && count($selectedGpM) > 0 && count($filteredMatrices)>0)
                    <label class="m-1 block text-base font-medium text-blue1">Matrice(s) suivie(s)</label>
                    @foreach($filteredMatrices as $matrice)
                        <div class="flex items-center">
                            <input type="checkbox" id="matrice_{{ $matrice->id }}" name="matrices[]" value="{{ $matrice->id }}"
                            wire:model="selectedMatrices" wire:change="updateFilteredOptions" class="h-4 w-4 text-blue2 border-gray-300 rounded focus:ring-blue2"
                                @if(in_array($matrice->id, $selectedMatrices)) checked @endif>
                            <label for="matrice_{{ $matrice->id }}" class="ml-2 text-sm text-gray-700">{{ $matrice->name }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>