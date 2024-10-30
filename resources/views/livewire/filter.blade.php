<div class="flex w-full">
    <div class=" w-1/5 min-w-64 bg-blue2 shadow-md bg-opacity-5 mr-6 p-6">
        <div>
        <div>Sélection :</div>
        @if(
            !empty($selectedSource) || 
            !empty($selectedTheme) || 
            !empty($selectedParametre) || 
            !empty($selectedMatrice) ||  
            !empty($selectedZone) || 
            !empty($selectedType) || 
            !empty($selectedReglementaire) || 
            !empty($selectedGpM) ||
            !empty($selectedGp) ||
            !empty($selectedFrequence) || 
            ($selectedStartyear != 1960 || $selectedStopyear != 2024)
        )
            <div>
                <ul class="text-gray-500 text-sm flex flex-wrap gap-1">
                    @foreach($selectedSource as $sourceId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Source::find($sourceId)->name }}
                                <button wire:click="removeSelection('selectedSource', {{ $sourceId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach($selectedTheme as $themeId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Theme::find($themeId)->name }}
                                <button wire:click="removeSelection('selectedTheme', {{ $themeId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach ($parametres->groupBy('groupe') as $groupe => $parametresGrouped)
                        @if(in_array($groupe, $selectedGp))
                            <li class="my-1">
                                <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                    {{ $groupe }}
                                    <button wire:click="removeSelection('selectedGp', '{{ $groupe }}')" class="text-red-500 ml-2">&times;</button>
                                </span>
                            </li>
                        @endif
                    @endforeach
                    @foreach($selectedParametre as $parametreId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Parametre::find($parametreId)->name }}
                                <button wire:click="removeSelection('selectedParametre', {{ $parametreId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach ($matrices->groupBy('groupe') as $groupe => $matricesGrouped)
                        @if(in_array($groupe, $selectedGpM))
                            <li class="my-1">
                                <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                    {{ $groupe }}
                                    <button wire:click="removeSelection('selectedGpM', '{{ $groupe }}')" class="text-red-500 ml-2">&times;</button>
                                </span>
                            </li>
                        @endif
                    @endforeach
                    @foreach($selectedMatrice as $matriceId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Matrice::find($matriceId)->name }}
                                <button wire:click="removeSelection('selectedMatrice', {{ $matriceId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach($selectedZone as $zoneId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Zone::find($zoneId)->name }}
                                <button wire:click="removeSelection('selectedZone', {{ $zoneId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach($selectedType as $typeId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Type::find($typeId)->name }}
                                <button wire:click="removeSelection('selectedType', {{ $typeId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach($selectedReglementaire as $reglementaire)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                @if($reglementaire == 'true')
                                    Réglementaire
                                @else
                                    Non réglementaire
                                @endif
                                <button wire:click="removeSelection('selectedReglementaire', '{{ $reglementaire }}')" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach($selectedFrequence as $frequence)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ $frequence }}
                                <button wire:click="removeSelection('selectedFrequence', '{{ $frequence }}')" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @if($selectedStartyear != 1960 || $selectedStopyear != 2024)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ $selectedStartyear }} - {{ $selectedStopyear }}
                                <button wire:click="resetYears" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        @else
            <p class="text-gray-500 text-sm">aucune sélection appliqué</p>
        @endif
    </div>
    <div>
        <br>
        <div>
            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Thèmes</h2>
            @foreach ($themes as $theme)
                <input type="checkbox" id="{{$theme->id}}" name="selectedTheme" value="{{$theme->id}}" wire:model="selectedTheme" wire:change="updateFilteredOptions">
                <label>{{$theme->name}}</label>
                <br>
            @endforeach
        </div>
        @if(!empty($selectedTheme) && count($selectedTheme) > 0 && count($filteredGp)>0)
                <br>
                <div>
                    <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Types de paramètres suivis</h2>
                    @foreach ($filteredGp as $groupe)
                        <input type="checkbox" id="{{$groupe}}" name="selectedGp" value="{{$groupe}}" wire:model="selectedGp" wire:change="updateFilteredOptions">
                        <label>{{$groupe}}</label>
                        <br>
                    @endforeach
                </div>
            @endif
            @if(!empty($filteredParametres) && count($filteredParametres) > 0)
                <br>
                    <div>
                        <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Paramètres suivis</h2>
                        @foreach ($filteredParametres as $parametre)
                            <input type="checkbox" id="{{$parametre->id}}" name="selectedParametre" value="{{$parametre->id}}" wire:model="selectedParametre" wire:change="updateFilteredOptions">
                            <label>{{$parametre->name}}</label>
                            <br>
                        @endforeach
                    </div>
            @endif
            @if(!empty($selectedTheme) && count($selectedTheme) > 0 && count($filteredGpM)>0)
                <br>
                <div>
                    <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Types des matrices suivies</h2>
                    @foreach ($matrices->groupBy('groupe') as $groupe => $matricesGrouped)
                        <input type="checkbox" id="{{$groupe}}" name="selectedGp" value="{{$groupe}}" wire:model="selectedGpM" wire:change="updateFilteredOptions">
                        <label>{{$groupe}}</label>
                        <br>
                    @endforeach
                </div>
            @endif
            @if(!empty($filteredMatrices) && count($filteredMatrices) > 0)
                <br>
                <div>
                    <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Matrices suivies</h2>
                    @foreach ($filteredMatrices as $matrice)
                        <input type="checkbox" id="{{$matrice->id}}" name="selectedMatrice" value="{{$matrice->id}}" wire:model="selectedMatrice" wire:change="updateFilteredOptions">
                        <label>{{$matrice->name}}</label>
                        <br>
                    @endforeach
                </div>
            @endif
            <br>
            <div>
                <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Sources</h2>
                @foreach ($sources as $source)
                    <input type="checkbox" id="{{$source->id}}" name="selectedSource" value="{{$source->id}}" wire:model="selectedSource" wire:change="updateFilteredOptions">
                    <label>{{$source->name}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Dates</h2>       
            <br>
            @vite('resources/js/filters.js')
            <div class="range_container">
                <div class="sliders_control">
                    <input id="fromSlider" type="range" wire:model="selectedStartyear" wire:change="updateFilteredOptions" min="1960" max="2024"/>
                    <input id="toSlider" type="range" wire:model="selectedStopyear" wire:change="updateFilteredOptions"  min="1960" max="2024"/>
                </div>
                <div class="form_control">
                    <div class="form_control_container">
                        <input class="form_control_container__time__input" wire:model="selectedStartyear" wire:change="updateFilteredOptions" type="number" id="fromInput" min="1960" max="2024"/>
                    </div>
                    <div class="form_control_container">
                        <input class="form_control_container__time__input" wire:model="selectedStopyear" wire:change="updateFilteredOptions" type="number" id="toInput" min="0" max="2024"/>
                    </div>
                </div>
            </div>

            <br>
            <div>
                <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Fréquence des relevés</h2>
                <input type="checkbox" id="optionPonctuelle" name="selectedFrequence" value="ponctuelle" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                <label for="optionPonctuelle">Ponctuelle</label>
                <br>
                
                <input type="checkbox" id="optionQuotidienne" name="selectedFrequence" value="quotidienne" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                <label for="optionQuotidienne">Quotidienne</label>
                <br>
                
                <input type="checkbox" id="optionMensuelle" name="selectedFrequence" value="mensuelle" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                <label for="optionMensuelle">Mensuelle</label>
                <br>
                <input type="checkbox" id="optionPluriannuelle" name="selectedFrequence" value="pluriannuelle" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                <label for="optionPluriannuelle">Pluriannuelle</label>
                <br>
                <input type="checkbox" id="optionAnnuelle" name="selectedFrequence" value="annuelle" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                <label for="optionAnnuelle">Annuelle</label>
            </div>
            <br>
            <div>
                <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Zones suivies</h2>
                @foreach ($zones as $zone)
                    <input type="checkbox" id="{{$zone->id}}" name="selectedZone" value="{{$zone->id}}" wire:model="selectedZone" wire:change="updateFilteredOptions">
                    <label>{{$zone->name}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <div>
                <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Types de données produites</h2>
                @foreach ($types as $type)
                    <input type="checkbox" id="{{$type->id}}" name="selectedType" value="{{$type->id}}" wire:model="selectedType" wire:change="updateFilteredOptions">
                    <label>{{$type->name}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <div>
                <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Etude réglementaire</h2>
                <input type="checkbox" id="optionOui" name="selectedReglementaire" value="true" wire:model="selectedReglementaire" wire:change="updateFilteredOptions">
                <label for="optionOui">Oui</label>
                
                <input type="checkbox" id="optionNon" name="selectedReglementaire" value="false" wire:model="selectedReglementaire" wire:change="updateFilteredOptions">
                <label for="optionNon">Non</label>
            </div>
        </div>
    </div>
    <div class=" w-4/5">
        @if(!empty($etudes)&& count($etudes) > 0)
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 auto-rows-min">
                @foreach ($etudes as $etude)
                    <li class="col-span-1 divide-y divide-gray-200 rounded-none bg-blue2 bg-opacity-5 shadow-md hover:bg-white h-80">
                        <a href="{{route('catalogue.find', ['slug'=>$etude->slug, 'etude'=>$etude->id])}}" class="block h-full w-full" title="{{$etude->title}}">
                        <div class="flex w-full items-center justify-between space-x-6 p-6">
                            <div class="flex-1">
                                <div class='flex-1'>
                                    <h3 class="text-2xl font-bold text-blue1 my-1 line-clamp-1">{{$etude->title}}</h3>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-blue2 line-clamp-2">{{$etude->longtitle}}</p>
                                </div>
                                <div class="flex flex-wrap items-center">
                                    @foreach($etude->parametres->groupBy('groupe') as $groupe => $parametres)
                                        <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue1 px-1.5 py-0.5 text-sm font-medium text-white my-1 mr-3">{{$groupe}}</span>
                                    @endforeach
                                    @foreach($etude->matrices->groupBy('groupe') as $groupe => $matrices)
                                        <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue2 px-1.5 py-0.5 text-sm font-medium text-white my-1 mr-3">{{$groupe}}</span>
                                    @endforeach
                                </div>
                                <hr class="border-blue2 border-2 border-opacity-50 rounded my-2">
                            
                                <p class="mt-1 truncate text-base text-gray-500">@foreach($etude->sources as $source){{$source->name}}@if(!$loop->last), &nbsp @endif @endforeach </p>
                                <p class="mt-1 truncate text-base text-gray-500">
                                    {{$etude->startyear}} - 
                                    @if($etude->active)
                                        en cours
                                        @else {{$etude->stopyear}}
                                    @endif
                                </p>
                            </div>
                        </div>            
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
        <p class="justify-center text-2xl text-gray-400">Aucune étude ne correspond aux filtres selectionnés.
        @endif
        <div>
            <br>
            {{ $etudes->links() }}
        </div>
    </div>
    
</div>