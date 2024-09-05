<form action="" method="post" enctype="multipart/form-data">
    @csrf
    @php
        $sourcesIds = $etude->sources()->pluck("id");
        $zonesIds = $etude->zones()->pluck("id");
        $typesIds = $etude->types()->pluck("id");
    @endphp
    <div gap-4 mt-4>
    <div class="grid grid-cols-1 md:grid-cols-3">
        <div class="md:col-span-2 flex flex-col mr-6">
            <label class="m-1 block text-base font-medium text-blue1" for="title">Titre court de l'étude</label>
            <input class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" type="text" class="form-control" name="title" value="{{old('title', $etude->title)}}">
                @error('title')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            <label class="m-1 block text-base font-medium text-blue1" for="longtitle">Titre long de l'étude</label>
            <input class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" type="text" class="form-control" name="longtitle" value="{{old('longtitle', $etude->longtitle)}}">
                @error('longtitle')
                    <div class="text-danger">{{$message}}</div>
                @enderror
             <label class="m-1 block text-base font-medium text-blue1" for="Resume">Desciption de l'étude</label>
             <textarea type="text" class="w-full flex-grow rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" name="resume">{{old('resume', $etude->resume)}}</textarea>
                @error('resume')
                    <div class="text-danger">{{$message}}</div>
                @enderror
        </div>
        <div class="relative md:col-span-1 flex justify-end">
            <img id="imagePreview" class="rounded-lg w-full h-full object-contain" 
                 src="{{ isset($etude->image) && $etude->image ? asset('storage/' . $etude->image) : asset('storage/catalogue/default.png') }}" 
                 alt="Image de l'étude">
            
            <input type="file" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer z-10" id="image" name="image" onchange="previewSelectedImage(event)">
            <label for="image" class="absolute bottom-4 left-4 hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold">
                Choisir un fichier
            </label>
        </div>
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
   <br>

   <div>
   
    @livewire('form-filter',[
        'etude' => $etude,
        'themes' => $themes,
        'parametres' => $parametres,
        'matrices' => $matrices])
    
    
    
    </div>
   <div class="form-group">
    <label for="source">Structure(s) productrice(s)</label>
        <select class="form-control" id="source" name="sources[]" multiple>
            @foreach($sources as $source)
                <option value="{{$source->id}}" 
                    @if(in_array($source->id, old('sources', $sourcesIds->toArray()))) selected @endif>
                    {{$source->name}}
                </option>
            @endforeach
        </select>
        @error('sources')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="zone">Zone(s) géographique(s)</label>
            <select class="form-control" id="zone" name="zones[]" multiple>
                @foreach($zones as $zone)
                    <option value="{{$zone->id}}" 
                        @if(in_array($zone->id, old('zones', $zonesIds->toArray()))) selected @endif>
                        {{$zone->name}}
                    </option>
                @endforeach
            </select>
            @error('zones')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
    <div class="form-group">
        <label for="active">L'étude est t'elle toujours active ?</label>
            <input type="radio" name="active" value="1" id="oui" @checked(old('active', $etude->active) == 1)></input>
            <label for="oui">oui</label>
            <input type="radio" name="active" value="0" id="non" @checked(old('active', $etude->active) == 0)></input>
            <label for="non">non</label>
            @error('active')
                <div class="text-danger">{{$message}}</div>
            @enderror
    </div>
    <div class="form-group">
        <label for="startyear">Année de début</label>
            <input type="number" class="form-control" name="startyear" value="{{ old('startyear', $etude->startyear) }}"></input>
            @error('startyear')
                <div class="text-danger">{{$message}}</div>
            @enderror
    </div>
    <div class="form-group">
        <label for="stopyear">Année de fin</label>
            <input type="number" class="form-control" name="stopyear" value="{{ old('stopyear', $etude->stopyear) }}"></input>
            @error('stopyear')
                <div class="text-danger">{{$message}}</div>
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
                <div class="text-danger">{{$message}}</div>
            @enderror
    </div>
    <div class="form-group">
        <label for="reglementaire">L'étude est t'elle réglementaire ?</label>
            <input type="radio" name="reglementaire" value="1" id="oui" @checked(old('reglementaire', $etude->reglementaire) == 1)></input>
            <label for="oui">oui</label>
            <input type="radio" name="reglementaire" value="0" id="non" @checked(old('reglementaire', $etude->reglementaire) == 0)></input>
            <label for="non">non</label>
            @error('reglementaire')
                <div class="text-danger">{{$message}}</div>
            @enderror
    </div>
    <div class="form-group">
        <label for="type">Type des ressources associées</label>
            <select class="form-control" id="type" name="types[]" multiple>
                @foreach($types as $type)
                    <option value="{{$type->id}}" 
                        @if(in_array($type->id, old('types', $typesIds->toArray()))) selected @endif>
                        {{$type->name}}
                    </option>
                @endforeach
            </select>
            @error('types')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>

        <div id="contacts">
            @if(old('contacts') || isset($contacts) && $contacts->count() > 0)
                @php
                    $oldContacts = old('contacts', $contacts ?? []);
                @endphp
                @foreach($oldContacts as $index => $contact)
                    <div class="contact">
                        <input type="text" name="contacts[{{ $index }}][nom]" placeholder="Nom" value="{{ old('contacts.' . $index . '.nom', $contact['nom'] ?? '') }}" required>
                        <input type="text" name="contacts[{{ $index }}][prenom]" placeholder="Prénom" value="{{ old('contacts.' . $index . '.prenom', $contact['prenom'] ?? '') }}" required>
                        <input type="email" name="contacts[{{ $index }}][mail]" placeholder="Email" value="{{ old('contacts.' . $index . '.mail', $contact['mail'] ?? '') }}" required>
                        <label>Diffusion Mail:</label>
                        <input type="radio" name="contacts[{{ $index }}][diffusion_mail]" value="1" {{ old('contacts.' . $index . '.diffusion_mail', $contact['diffusion_mail'] ?? '') == 1 ? 'checked' : '' }} required> Oui
                        <input type="radio" name="contacts[{{ $index }}][diffusion_mail]" value="0" {{ old('contacts.' . $index . '.diffusion_mail', $contact['diffusion_mail'] ?? '') == 0 ? 'checked' : '' }} required> Non
                    </div>
                    @error('contacts.' . $index . '.nom')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @error('contacts.' . $index . '.prenom')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @error('contacts.' . $index . '.mail')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @error('contacts.' . $index . '.diffusion_mail')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                @endforeach
            @else
                <div class="contact">
                    <input type="text" name="contacts[0][nom]" placeholder="Nom" required>
                    <input type="text" name="contacts[0][prenom]" placeholder="Prénom" required>
                    <input type="email" name="contacts[0][mail]" placeholder="Email" required>
                    <label>Diffusion Mail:</label>
                    <input type="radio" name="contacts[0][diffusion_mail]" value="1" required> Oui
                    <input type="radio" name="contacts[0][diffusion_mail]" value="0" required> Non
                </div>
                @error('contacts.0.nom')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @error('contacts.0.prenom')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @error('contacts.0.mail')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @error('contacts.0.diffusion_mail')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            @endif
        </div>
        <button type="button" onclick="addContact()">Ajouter un contact</button>

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
        @endif
    </div>
    <button type="button" id="add-link">Ajouter un lien</button>

    <hr>
    <button class="btn btn-primary">Enregistrer</button>
</div>
<div>
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

    let contactIndex = {{ isset($contacts) ? $contacts->count() : (old('contacts') ? count(old('contacts')) : 1) }};
    function addContact() {
        const contactsDiv = document.getElementById('contacts');
        const newContact = document.createElement('div');
        newContact.className = 'contact';
        newContact.innerHTML = `
            <input type="text" name="contacts[${contactIndex}][nom]" placeholder="Nom" required>
            <input type="text" name="contacts[${contactIndex}][prenom]" placeholder="Prénom" required>
            <input type="email" name="contacts[${contactIndex}][mail]" placeholder="Email" required>
            <label>Diffusion Mail:</label>
            <input type="radio" name="contacts[${contactIndex}][diffusion_mail]" value="1" required> Oui
            <input type="radio" name="contacts[${contactIndex}][diffusion_mail]" value="0" required> Non
        `;
        contactsDiv.appendChild(newContact);
        contactIndex++;
    }

    function previewSelectedImage(event) {
        const reader = new FileReader();
        const imagePreview = document.getElementById('imagePreview');

        reader.onload = function() {
            if (reader.readyState === 2) {
                imagePreview.src = reader.result;
            }
        }

        reader.readAsDataURL(event.target.files[0]);
    }
    </script>