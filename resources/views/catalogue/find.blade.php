@extends('base')
@section ('title',$etude->title)
@section ('content')
    

    <etude>
        <h1>{{$etude->title}}</h1>
        <h2> {{$etude->longtitle}} </h2>
        <p> {{$etude->resume}} </p>
    </etude>   

@endsection