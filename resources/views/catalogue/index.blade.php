@extends('base')
@section ('title','Recherche avancée')
@section ('content')

<!-- Formulaire de filtrage -->
<form method="GET" action="{{ route('catalogue.index') }}">
    <div class="form-group">
        <label for="source">Source</label>
        <select name="source[]" id="source" class="form-control" multiple>
            @foreach($allSources as $source)
                <option value="{{ $source->id }}" {{ in_array($source->id, request()->get('source', [])) ? 'selected' : '' }}>
                    {{ $source->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Filtrer</button>
</form>

<hr>

    @foreach ($etudes as $etude)
    <etude>
        <h2>{{$etude->title}}</h2>

        @foreach($etude->themes as $theme)
            <span>{{$theme->name}}</span>
        @endforeach 
    
        <hr>
        @foreach($etude->sources as $source)
                <span>{{$source->name}}</span>
            @endforeach
        <hr>
        <p> <a href="{{route('catalogue.find', ['slug'=>$etude->slug, 'etude'=>$etude->id])}}" class="btn btn-primary"> Lire la suite</a>
    </etude>   
    
    @endforeach()
    {{$etudes->links()}}
@endsection