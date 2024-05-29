<form action="" method="post">
    @csrf
   
    <div class="form-group">
        <label for="title">Titre court de l'étude</label>
        <input type="text" class="form-control" name="title" value="{{old('title', $etude->title)}}">
       @error('title')
           {{$message}}
       @enderror
   </div>

   <div class="form-group">
    <label for="longtitle">Titre long de l'étude</label>
    <input type="text" class="form-control" name="longtitle" value="{{old('longtitle', $etude->longtitle)}}">
   @error('longtitle')
       {{$message}}
   @enderror
</div>

@php
    $themesIds = $etude->themes()->pluck("id");
@endphp
   <div class="form-group">
    <label for="theme">Thème(s)</label>
        <select class="form-control" id="theme" name="themes[]" multiple>
            @foreach($themes as $theme)
                <option @selected($themesIds->contains($theme->id)) value="{{$theme->id}}">{{$theme->name}}</option>
            @endforeach
        </select>
        @error('themes')
            {{$message}}
        @enderror
    </div>

@php
    $sourcesIds = $etude->sources()->pluck("id");
@endphp
   <div class="form-group">
    <label for="source">Structure(s) productrice(s)</label>
        <select class="form-control" id="source" name="sources[]" multiple>
            @foreach($sources as $source)
                <option @selected($sourcesIds->contains($source->id)) value="{{$source->id}}">{{$source->name}}</option>
            @endforeach
        </select>
        @error('sources')
            {{$message}}
        @enderror
    </div>


   <div class="form-group">
    <label for="resume">Description de l'étude</label>
        <textarea type="text" class="form-control" name="resume">{{old('resume', $etude->resume)}}</textarea>
        @error('resume')
            {{$message}}
        @enderror
    </div>
    <div class="form-group">
        <label for="active">L'étude est t'elle toujours active ?</label>
            <input type="radio" name="active" value="1" id="oui" @checked(old('active', $etude->active) == 1)></input>
            <label for="oui">oui</label>
            <input type="radio" name="active" value="0" id="non" @checked(old('active', $etude->active) == 0)></input>
            <label for="non">non</label>
            @error('active')
                {{$message}}
            @enderror
    </div>
    <div class="form-group">
        <label for="startyear">Année de début</label>
            <input type="number" class="form-control" name="startyear" value="{{ old('startyear', $etude->startyear) }}"></input>
            @error('startyear')
                {{$message}}
            @enderror
    </div>
    <div class="form-group">
        <label for="stopyear">Année de fin</label>
            <input type="number" class="form-control" name="stopyear" value="{{ old('stopyear', $etude->stopyear) }}"></input>
            @error('stopyear')
                {{$message}}
            @enderror
    </div>
    <div class="form-group">
        <label for="frequence">Fréquence des relevés</label>
            <select class="form-control" name="frequence" value="{{ old('frequence', $etude->frequence) }}">
                <option value="ponctuelle">ponctuelle</option>
                <option value="quotidienne">quotidienne</option>
                <option value="mensuelle">mensuelle</option>
                <option value="plurianuelle">plurianuelle</option>
                <option value="anuelle">anuelle</option>
            </select>
            @error('stopyear')
                {{$message}}
            @enderror
    </div>
    <div class="form-group">
        <label for="reglementaire">L'étude est t'elle réglementaire ?</label>
            <input type="radio" name="reglementaire" value="1" id="oui" @checked(old('reglementaire', $etude->reglementaire) == 1)></input>
            <label for="oui">oui</label>
            <input type="radio" name="reglementaire" value="0" id="non" @checked(old('reglementaire', $etude->reglementaire) == 0)></input>
            <label for="non">non</label>
            @error('reglementaire')
                {{$message}}
            @enderror
    </div>
    <div id="liens-container">
        @if(isset($liens) && $liens->count() > 0)
            @foreach($liens as $index => $lien)
                <div class="form-group">
                    <label for="link_name">Nom du lien n°{{ $index + 1 }}</label>
                    <input type="text" class="form-control" id="link_name" name="link_name[]" value="{{ old('link_name.' . $index, $lien->link_name) }}">
                    @error('link_name.' . $index)
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="link_url">URL du lien n°{{ $index + 1 }}</label>
                    <input type="url" class="form-control" id="link_url" name="link_url[]" value="{{ old('link_url.' . $index, $lien->link_url) }}">
                    @error('link_url.' . $index)
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
        @else
            <div class="form-group">
                <label for="link_name">Nom du lien n°1</label>
                <input type="text" class="form-control" id="link_name" name="link_name[]" value="">
                @error('link_name.0')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="link_url">URL du lien n°1</label>
                <input type="url" class="form-control" id="link_url" name="link_url[]" value="">
                @error('link_url.0')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        @endif
    </div>
    <button type="button" id="add-link">Ajouter un lien</button>

    <hr>
    <button class="btn btn-primary">Enregistrer</button>
</form>

<script>
    document.getElementById('add-link').addEventListener('click', function() {
        var container = document.getElementById('liens-container');
        var index = container.children.length / 2;
    
        var linkNameDiv = document.createElement('div');
        linkNameDiv.className = 'form-group';
        linkNameDiv.innerHTML = `
            <label for="link_name">Nom du lien n°${index + 1}</label>
            <input type="text" class="form-control" id="link_name" name="link_name[]" value="">
        `;
    
        var linkUrlDiv = document.createElement('div');
        linkUrlDiv.className = 'form-group';
        linkUrlDiv.innerHTML = `
            <label for="link_url">URL du lien n°${index + 1}</label>
            <input type="url" class="form-control" id="link_url" name="link_url[]" value="">
        `;
    
        container.appendChild(linkNameDiv);
        container.appendChild(linkUrlDiv);
    });
    </script>