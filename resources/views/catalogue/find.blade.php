
@extends('base')
@section('title', $etude->title)
@section('content')

<!-- Main grid container with two columns -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
    <!-- Left text block (2/3 of the width) -->
    <div class="md:col-span-2">
        <h1 class="text-blue1 font-bold text-2xl mt-2">{{$etude->title}}</h1>
        <h2 class="text-blue1 font-medium text-xl mt-2">{{$etude->longtitle}}</h2>
        <div class="w-1/6">
            <hr class="border-blue1 border-2 rounded my-2">
        </div>
        <p class="text-blue1 font-medium text-xl mt-2">
            @foreach($etude-> sources as $source)
                {{$source->name}}@if(!$loop->last), &nbsp @endif
            @endforeach
        </p>
        <br>
        @if($etude->parametres->isNotEmpty())
            <p class="text-base font-medium tracking-wide text-blue2 mt-1">
                Paramètres suivis : 
                @foreach($etude->parametres as $parametre)
                    <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue1 px-1.5 py-0.5 text-sm font-medium text-white my-1 ml-2">{{$parametre->name}}</span>
                @endforeach
            </p>
        @endif
        <br>
        @if($etude->matrices->isNotEmpty())
            <p class="text-base font-medium tracking-wide text-blue2 mt-1">
                Matrices suivis : 
                @foreach($etude->matrices as $matrice)
                    <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue2 px-1.5 py-0.5 text-sm font-medium text-white my-1 ml-2">{{$matrice->name}}</span>
                @endforeach
            </p>
        @endif

    </div>

    <div class="md:col-span-1 flex justify-end">
        <img src="{{ asset($etude->imageUrl()) }}" alt="Image" class="rounded-lg w-full md:w-auto md:max-w-[80%] max-h-96 object-contain">
    </div>
</div>

<div class="mt-4">
    <div class="max-w-full  bg-blue2 bg-opacity-5 shadow-md">
        <div class="p-4">
            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1" >Description :</h2>
            <p class="text-gray-900 mt-1 font-serif">
                {!! nl2br(e($etude->resume)) !!}
            </p>
        </div>    
    </div>
    <br>
    <div class="flex flex-wrap items-center mt-2 gap-x-6 gap-y-2"> <!-- gap-x-4 for spacing between items -->
        <div class="flex-grow flex items-center">
            <p class="text-base font-medium text-blue2 mr-2">Fréquence des relevés :</p>
            <p class="text-gray-900 font-serif">{{ $etude->frequence}}</p>
        </div>
        <div class="flex-grow flex items-center">
            <p class="text-base font-medium text-blue2 mr-2">Date :</p>
            <p class="text-gray-900 font-serif"> {{$etude->startyear}} - @if($etude->active)
                en cours
                @else {{$etude->stopyear}}
                @endif
            </p>
        </div>
        <div class="flex-grow flex items-center">
            <p class="text-base font-medium text-blue2 mr-2">Réglementaire :</p>
            <p class="text-gray-900 font-serif">
                @if($etude->reglementaire) oui
                @else non
                @endif
            </p>
        </div>
        <div class="flex-grow flex items-center">
            <p class="text-base font-medium text-blue2 mr-2">Types des connaissances produites :</p>
            @foreach($etude->types as $type)
            <p class="text-gray-900 font-serif"> {{ $type->name }}@if(!$loop->last), &nbsp @endif</p>
            @endforeach
        </div>
        <div class="flex-grow flex items-center">
            <p class="text-base font-medium text-blue2 mr-2">Zone géographique des relevés:</p>
            @foreach($etude->zones as $zone)
                <p class="text-gray-900 font-serif"> {{$zone->name}}@if(!$loop->last), &nbsp @endif</p>
            @endforeach
        </div>
</div>
    
    
    <br>
    <div class="max-w-full  bg-blue2 bg-opacity-5 shadow-md">
        <div class="p-4">
            
            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1"> Contact </h2>
            @foreach($etude->contacts as $contact)
                <p class="text-gray-900 mt-1 font-serif">{{$contact->nom}} {{$contact->prenom}} @if($contact->diffusion_mail) - {{$contact->mail}}
                    @else 
                    @endif</p>
            @endforeach
        </div>
    </div>
    <br>
    @if($etude->liens->isNotEmpty())
        <div class="max-w-full  bg-blue2 bg-opacity-5 shadow-md">
            <div class="p-4">
                <h2 class="text-base font-medium tracking-wide text-blue2 mt-1"> Lien(s) :</h2>
                    @foreach($etude->liens as $lien)
                            <h2 class="text-base font-serif tracking-wide text-blue1 mt-1"> {{ $lien->link_name }}</h2>
                            <a class="text-gray-900 font-serif mt-1 hover:text-blue1" href="{{ $lien->link_url }}">{{ $lien->link_url }}</a>
                        
                    @endforeach
            </div>
        </div>
        <br>
    @endif
    @if($etude->fichiers->isNotEmpty())
        <div class="max-w-full  bg-blue2 bg-opacity-5 shadow-md">
            <div class="p-4">
                <h2 class="text-base font-medium tracking-wide text-blue2 mt-1"> Fichier(s) :</h2>
                @foreach($etude->fichiers as $fichier)
                    <div class="mt-1">
                        <a class="text-gray-900 mt-1 font-serif hover:text-blue1" href="{{ asset('/storage/' . $fichier->chemin) }}">{{$fichier->nom}}</a>
                    </div>
                        @endforeach
            </div>
        </div>
    @endif
    <br>
</div>

@endsection

