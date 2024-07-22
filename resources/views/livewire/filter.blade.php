<div>
    <div>
        <div>Valeur :
            
            @if(!empty($selectedSource) || !empty($selectedTheme)|| !empty($selectedParametre)|| !empty($selectedMatrice)|| !empty($selectedZone)|| !empty($selectedType)|| !empty($selectedReglementaire))
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
                        @if($reglementaire == 'true')
                        <li>Réglementaire</li>
                    @else
                        <li>Non réglementaire</li>
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
    </div>
    <br>
    <div>
        @foreach ($parametres as $parametre)
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
    <br>
    <div>
        @foreach ($etudes as $etude)
            <h2>{{$etude->title}}</h2>
            @foreach($etude->themes as $theme)
                <span>{{$theme->name}}</span>
            @endforeach 
            <hr>
            @foreach($etude->sources as $source)
                <span>{{$source->name}}</span>
            @endforeach
            <hr>
            <p><a href="{{route('catalogue.find', ['slug'=>$etude->slug, 'etude'=>$etude->id])}}" class="btn btn-primary">Lire la suite</a></p>
        @endforeach
    </div>
</div>
