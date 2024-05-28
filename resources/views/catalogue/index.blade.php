@extends('base')
@section ('title','Recherche avancée')
@section ('content')

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