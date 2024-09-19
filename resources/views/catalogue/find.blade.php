
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
        @foreach($etude-> sources as $source)
            <h2 class="text-blue1 font-medium text-xl mt-2">{{$source->name}}</h2>
        @endforeach
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
        <img class="rounded-lg w-full md:w-auto md:max-w-[80%] max-h-96 object-contain" src="{{ $etude->imageUrl() }}" alt="Image">
    </div>
</div>

<div class="mt-4">
    <div class="max-w-full  bg-blue2 bg-opacity-5 shadow-md">
        <div class="p-4">
            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1" >Description :</h2>
            <p class="text-gray-900 mt-1">
                {{$etude->resume}}
            </p>
        </div>    
    </div>
    <br>
    <div class="flex flex-wrap items-center mt-2 md:space-x-20 space-y-2 md:space-y-0">
        <div class="flex items-center space-x-2 w-full md:w-auto"> <!-- Flex container for inline text -->
            <p class="text-base font-medium text-blue2">Fréquence des relevés :</p>
            <p class="text-gray-900">{{$etude->frequence}}</p>
        </div>
        <div class="flex items-center space-x-2 w-full md:w-auto"> <!-- Flex container for inline text -->
            <p class="text-base font-medium text-blue2">Date :</p>
            <p class="text-gray-900">{{$etude->startyear}} - @if($etude->active)
                en cours
                @else {{$etude->stopyear}}
                @endif
            </p>
        </div>
        <div class="flex items-center space-x-2 w-full md:w-auto"> <!-- Flex container for inline text -->
            <p class="text-base font-medium text-blue2">Réglementaire :</p>
            <p class="text-gray-900">
                @if($etude->reglementaire) oui
                @else non
                @endif
            </p>
        </div>
    </div>
    
</div>
    
    <br>
    

    @foreach($etude->liens as $lien)
        <div class="max-w-full  bg-blue2 bg-opacity-5 shadow-md">
            <div class="p-4">
                
                <h2 class="text-base font-medium tracking-wide text-blue2 mt-1"> Lien n°{{ $lien->position }} : {{ $lien->link_name }}</h2>
                <a class="text-gray-900 mt-1 hover:text-blue1" href="{{ $lien->link_url }}">{{ $lien->link_url }}</a>
            </div>
        </div>
        <br>
    @endforeach
    <div class="max-w-full  bg-blue2 bg-opacity-5 shadow-md mt-4">
        <div class="p-4">
            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Fichiers PDF</h2>
            @if($etude->fichiers->isNotEmpty())
                <ul class="list-disc list-inside">
                    @foreach($etude->fichiers as $fichier)
                        <li>
                            <a href="{{ asset('storage/' . $fichier->chemin) }}" target="_blank" class="text-blue1 underline">
                                {{ $fichier->nom }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    
    
    <div class="max-w-full  bg-blue2 bg-opacity-5 shadow-md">
        <div class="p-4">
            
            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1"> Contact </h2>
            @foreach($etude->contacts as $contact)
                <p class="text-gray-900 mt-1">{{$contact->nom}} {{$contact->prenom}} @if($contact->diffusion_mail) - {{$contact->mail}}
                    @else 
                    @endif</p>
            @endforeach
        </div>
    </div>
</div>

@endsection

