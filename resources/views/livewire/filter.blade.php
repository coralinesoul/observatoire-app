<div>
    <div>
        <div>Valeur :
            @if(!empty($selectedOption))
                <ul>
                    @foreach($selectedOption as $option)
                        <li>{{ $option }}</li>
                    @endforeach
                </ul>
            @else
                Aucune sélection
            @endif
        </div>
        <div>
            <input type="checkbox" id="optionOui" name="selectedOption" value="13" wire:model="selectedOption" wire:change="getselect">
            <label for="optionOui">LCE</label>
            
            <input type="checkbox" id="optionNon" name="selectedOption" value="14" wire:model="selectedOption" wire:change="getselect">
            <label for="optionNon">IECP</label>

        </div>
    </div>
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
