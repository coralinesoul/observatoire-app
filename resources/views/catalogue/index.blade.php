@extends('base')
@section('title', 'Catalogue de données - Observatoire du Golfe de Fos')
@section('meta_description', "L'Observatoire du Golfe de Fos propose 
un catalogue d'études sur le milieu marin. Il centralise les données et informations sur la biodiversité,
les contaminations, l'hydrologie et les suivis d'accidents notamment industriels.")
@section('content')
    <div class="flex">
        <livewire:filter/>
    </div>
@endsection