@extends('base')
@section ('title',$etude->title)
@section ('content')
    

    <etude>
        <h1>{{$etude->title}}</h1>
        <h2> {{$etude->longtitle}} </h2>
        <p> {{$etude->resume}} </p>

        @foreach($etude->liens as $lien)
            <div>
                <strong>{{ $lien->position }}. {{ $lien->link_name }}:</strong>
                <a href="{{ $lien->link_url }}">{{ $lien->link_url }}</a>
            </div>
        @endforeach
    </etude>   

@endsection