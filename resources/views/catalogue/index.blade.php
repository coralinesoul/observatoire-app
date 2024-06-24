<script src="{{ mix('resources/js/filters.js') }}"></script>

@extends('base')
@section('title', 'Recherche avancée')
@section('content')

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
    <div class="form-group">
        <label for="theme">Theme</label>
        <select name="theme[]" id="theme" class="form-control" multiple>
            @foreach($allThemes as $theme)
                <option value="{{ $theme->id }}" {{ in_array($theme->id, request()->get('theme', [])) ? 'selected' : '' }}>
                    {{ $theme->name }}
                </option>
            @endforeach
        </select>
    </div>
        <div class="form-group">
        <label for="groupeParametre">Groupe de paramètres</label>
        <select name="groupeParametre[]" id="groupeParametre" class="form-control" multiple>
            @foreach($groupesUniques as $groupe)
                <option value="{{ $groupe->groupe }}" {{ in_array($groupe->groupe, (array) request()->get('groupeParametre', [])) ? 'selected' : '' }}>
                    {{ $groupe->groupe }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="parametre">Paramètre</label>
        <select name="parametre[]" id="parametre" class="form-control" multiple>
            @foreach($allParametres as $parametre)
                <option value="{{ $parametre->id }}" {{ in_array($parametre->id, request()->get('parametre', [])) ? 'selected' : '' }}>
                    {{ $parametre->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="groupeMatrice">Groupe de matrices</label>
        <select name="groupeMatrice[]" id="groupeMatrice" class="form-control" multiple>
            @foreach($groupesMatrices as $groupeM)
                <option value="{{ $groupeM->groupe }}" {{ in_array($groupeM->groupe, (array) request()->get('groupeMatrice', [])) ? 'selected' : '' }}>
                    {{ $groupeM->groupe }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="matrice">Matrice</label>
        <select name="matrice[]" id="matrice" class="form-control" multiple>
            @foreach($allMatrices as $matrice)
                <option value="{{ $matrice->id }}" {{ in_array($matrice->id, request()->get('matrice', [])) ? 'selected' : '' }}>
                    {{ $matrice->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="zone">Zone</label>
        <select name="zone[]" id="zone" class="form-control" multiple>
            @foreach($allZones as $zone)
                <option value="{{ $zone->id }}" {{ in_array($zone->id, request()->get('zone', [])) ? 'selected' : '' }}>
                    {{ $zone->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="year-range">Plage d'années</label>
        <div class="range_container">
            <div class="sliders_control">
                <input id="fromSlider" type="range" name="min_year" value="{{ request()->get('min_year', 1900) }}" min="1900" max="2024"/>
                <input id="toSlider" type="range" name="max_year" value="{{ request()->get('max_year', 2024) }}" min="1900" max="2024"/>
            </div>
            <div class="form_control">
                <div class="form_control_container">
                    <div class="form_control_container__time">Min</div>
                    <input class="form_control_container__time__input" type="number" id="fromInput" value="{{ request()->get('min_year', 1900) }}" min="1900" max="2024"/>
                </div>
                <div class="form_control_container">
                    <div class="form_control_container__time">Max</div>
                    <input class="form_control_container__time__input" type="number" id="toInput" value="{{ request()->get('max_year', 2024) }}" min="1900" max="2024"/>
                </div>

            </div>
        </div>
    </div>
  
    <button type="submit" class="btn btn-primary">Filtrer</button>
</form>

<hr>

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
</etude>
@endforeach
{{$etudes->links()}}
@endsection

