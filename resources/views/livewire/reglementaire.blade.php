<div>
    <div>
        <div> Valeur : {{$selectedOption}}</div>
        <div>
            <input type="radio" id="optionOui" name="selectedOption" value="true" wire:model="selectedOption" wire:change="getselect">
            <label for="optionOui">Oui</label>
            
            <input type="radio" id="optionNon" name="selectedOption" value="false" wire:model="selectedOption" wire:change="getselect">
            <label for="optionNon">Non</label>
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
