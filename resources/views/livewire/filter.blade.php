<div class="flex">
    <div class=" w-1/4">
        <div>Valeur :
            @if(!empty($selectedSource) || !empty($selectedTheme) || !empty($selectedParametre) || !empty($selectedMatrice) || !empty($selectedZone) || !empty($selectedType) || !empty($selectedReglementaire))
                <ul>
                    @foreach($selectedSource as $sourceId)
                        <li>{{ \App\Models\Source::find($sourceId)->name }}</li>
                    @endforeach
                    @foreach($selectedTheme as $themeId)
                        <li>{{ \App\Models\Theme::find($themeId)->name }}</li>
                    @endforeach
                    @foreach($selectedParametre as $parametreId)
                        <li>{{ \App\Models\Parametre::find($parametreId)->name }}</li>
                    @endforeach
                    @foreach($selectedMatrice as $matriceId)
                        <li>{{ \App\Models\Matrice::find($matriceId)->name }}</li>
                    @endforeach
                    @foreach($selectedZone as $zoneId)
                        <li>{{ \App\Models\Zone::find($zoneId)->name }}</li>
                    @endforeach
                    @foreach($selectedType as $typeId)
                        <li>{{ \App\Models\Type::find($typeId)->name }}</li>
                    @endforeach
                    @foreach($selectedReglementaire as $reglementaire)
                        <li>
                            @if($reglementaire == 'true')
                                Réglementaire
                            @else
                                Non réglementaire
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                Aucune sélection
            @endif
        </div>
        <br>
        <div>
            <div>
                @foreach ($sources as $source)
                    <input type="checkbox" id="{{$source->id}}" name="selectedSource" value="{{$source->id}}" wire:model="selectedSource" wire:change="getselect">
                    <label>{{$source->name}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <div>
                @foreach ($themes as $theme)
                    <input type="checkbox" id="{{$theme->id}}" name="selectedTheme" value="{{$theme->id}}" wire:model="selectedTheme" wire:change="getselect">
                    <label>{{$theme->name}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <div>
                @foreach ($parametres->groupBy('groupe') as $groupe => $parametresGrouped)
                    <input type="checkbox" id="{{$groupe}}" name="selectedGp" value="{{$groupe}}" wire:model="selectedGp" wire:change="updateFilteredParametres">
                    <label>{{$groupe}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <div>
                @foreach ($filteredParametres as $parametre)
                    <input type="checkbox" id="{{$parametre->id}}" name="selectedParametre" value="{{$parametre->id}}" wire:model="selectedParametre" wire:change="getselect">
                    <label>{{$parametre->name}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <div>
                @foreach ($matrices as $matrice)
                    <input type="checkbox" id="{{$matrice->id}}" name="selectedMatrice" value="{{$matrice->id}}" wire:model="selectedMatrice" wire:change="getselect">
                    <label>{{$matrice->name}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <div>
                @foreach ($zones as $zone)
                    <input type="checkbox" id="{{$zone->id}}" name="selectedZone" value="{{$zone->id}}" wire:model="selectedZone" wire:change="getselect">
                    <label>{{$zone->name}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <div class="range_container">
                <div class="sliders_control">
                    <input id="fromSlider" type="range" wire:model="selectedStartyear" wire:change="getselect" name="min_year" min="1960" max="2024" oninput="updateFromInput(this.value)"/>
                    <input id="toSlider" type="range" wire:model="selectedStopyear" wire:change="getselect" name="max_year" min="1960" max="2024" oninput="updateToInput(this.value)"/>
                </div>
                <div class="form_control">
                    <div class="form_control_container">
                        <div class="form_control_container__time">Min</div>
                        <input class="form_control_container__time__input" type="number" wire:model="selectedStartyear" wire:change="getselect" id="fromInput" min="1960" max="2024" onchange="updateFromSlider(this.value)"/>
                    </div>
                    <div class="form_control_container">
                        <div class="form_control_container__time">Max</div>
                        <input class="form_control_container__time__input" type="number" wire:model="selectedStopyear" wire:change="getselect" id="toInput" min="1960" max="2024" onchange="updateToSlider(this.value)"/>
                    </div>
                </div>
            </div>
            <br>
            <div>
                <input type="checkbox" id="optionPonctuelle" name="selectedFrequence" value="ponctuelle" wire:model="selectedFrequence" wire:change="getselect">
                <label for="optionPonctuelle">Ponctuelle</label>
                <br>
                
                <input type="checkbox" id="optionQuotidienne" name="selectedFrequence" value="quotidienne" wire:model="selectedFrequence" wire:change="getselect">
                <label for="optionQuotidienne">Quotidienne</label>
                <br>
                
                <input type="checkbox" id="optionMensuelle" name="selectedFrequence" value="mensuelle" wire:model="selectedFrequence" wire:change="getselect">
                <label for="optionMensuelle">Mensuelle</label>
                <br>
                <input type="checkbox" id="optionPluriannuelle" name="selectedFrequence" value="pluriannuelle" wire:model="selectedFrequence" wire:change="getselect">
                <label for="optionPluriannuelle">Pluriannuelle</label>
                <br>
                <input type="checkbox" id="optionAnnuelle" name="selectedFrequence" value="annuelle" wire:model="selectedFrequence" wire:change="getselect">
                <label for="optionAnnuelle">Annuelle</label>
            </div>
            <br>
            <div>
                @foreach ($types as $type)
                    <input type="checkbox" id="{{$type->id}}" name="selectedType" value="{{$type->id}}" wire:model="selectedType" wire:change="getselect">
                    <label>{{$type->name}}</label>
                    <br>
                @endforeach
            </div>
            <br>
            <div>
                <input type="checkbox" id="optionOui" name="selectedReglementaire" value="true" wire:model="selectedReglementaire" wire:change="getselect">
                <label for="optionOui">Oui</label>
                
                <input type="checkbox" id="optionNon" name="selectedReglementaire" value="false" wire:model="selectedReglementaire" wire:change="getselect">
                <label for="optionNon">Non</label>
            </div>
        </div>
    </div>
    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($etudes as $etude)
            <li class="col-span-1 divide-y divide-gray-200 rounded-none bg-blue2 bg-opacity-5 shadow-md hover:bg-white h-80">
                <a href="{{route('catalogue.find', ['slug'=>$etude->slug, 'etude'=>$etude->id])}}" class="block h-full w-full">
                <div class="flex w-full items-center justify-between space-x-6 p-6">
                    <div class="flex-1 truncate">
                      <div class="flex items-center space-x-3">
                        <h3 class="truncate text-2xl font-bold text-blue1 my-1">{{$etude->title}}</h3>
                    </div>
                      <div class="flex flex-wrap items-center">
                        @foreach($etude->parametres->groupBy('groupe') as $groupe => $parametres)
                            <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue1 px-1.5 py-0.5 text-sm font-medium text-white my-1 mr-3">{{$groupe}}</span>
                        @endforeach
                        @foreach($etude->matrices as $matrice)
                            <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue2 px-1.5 py-0.5 text-sm font-medium text-white my-1 mr-3">{{$matrice->groupe}}</span>
                        @endforeach
                      </div>
                      <hr class="border-blue2 border-2 border-opacity-50 rounded my-2">
                      
                        <p class="mt-1 truncate text-base text-gray-500">@foreach($etude->sources as $source){{$source->name}}, @endforeach </p>
                        <p class="mt-1 truncate text-base text-gray-500">
                            {{$etude->startyear}} - 
                            @if($etude->active)
                                {{$etude->stopyear}}
                                @else en cours
                            @endif
                        </p>
                    </div>
                  </div>            
                </a>
            </li>
        @endforeach
    </div>
    
</div>
<script src="{{ mix('resources/js/filters.js') }}"></script>