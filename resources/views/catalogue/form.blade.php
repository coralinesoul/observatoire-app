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
                    <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
                @enderror
            <label class="m-1 block text-base font-medium text-blue1" for="longtitle">Titre long de l'étude</label>
            <input class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" type="text" class="form-control" name="longtitle" value="{{old('longtitle', $etude->longtitle)}}">
                @error('longtitle')
                    <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
                @enderror
             <label class="m-1 block text-base font-medium text-blue1" for="Resume">Desciption de l'étude</label>
             <textarea type="text" class="w-full flex-grow rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" name="resume">{{old('resume', $etude->resume)}}</textarea>
                @error('resume')
                    <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
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
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
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
    <br>
    <div class="grid grid-cols-1 lg:grid-cols-4 md:space-x-6">
        <div class="rounded-none bg-blue2 bg-opacity-5 shadow-md p-6 " >
            <div id="sources">
                <label class="m-1 block text-base font-medium text-blue1 pb-4">Structure(s) productrice(s)</label>
                @if(old('sources') || isset($etude) && $etude->sources()->count() > 0)
                    @php
                        $oldSources = old('sources', $etude->sources()->pluck('name', 'id')->toArray());
                    @endphp
        @foreach($oldSources as $id => $sourceName)
        <div class="flex items-center rounded-md border border-[#e0e0e0] bg-white py-3 px-6 mb-6 text-base text-[#6B7280] outline-none">
            <input class="flex-grow min-w-1 outline-none" type="text" name="sources[{{ $id }}][name]" placeholder="Nom de la source" 
                value="{{ is_array($sourceName) ? $sourceName['name'] : $sourceName }}" required>
            
            @if($loop->index > 0)
                <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeSource(this)">x</button>
            @endif
        </div>

        @error('sources.' . $id . '.name')
            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
        @enderror
        @endforeach

               
                @else
                    <div class="flex items-center rounded-md border border-[#e0e0e0] bg-white py-3 px-6 mb-6 text-base text-[#6B7280] outline-none">
                        <input class="flex-grow min-w-1" type="text" name="sources[0][name]" placeholder="Nom de la source" required>
                    </div>
                    
                    @error('sources.0.name')
                        <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                    @enderror
                @endif
            </div>
            <button type="button" class="hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold" onclick="addSource()">Ajouter une autre source +</button>
        </div>
        <div class="rounded-none bg-blue2 bg-opacity-5 shadow-md p-6 col-span-3">
            <label class="block text-base font-medium text-blue1 pb-4">Contact(s)</label>
            <div id="contacts">
                <div class="flex justify-between text-blue1 mb-2">
                    <span class="w-1/5">Nom</span>
                    <span class="w-1/5">Prénom</span>
                    <span class="w-2/5">Email</span>
                    <span class="w-1/5 text-center">Diffusion Mail</span>
                </div>
            
                @if(old('contacts') || isset($contacts) && $contacts->count() > 0)
                    @php
                        $oldContacts = old('contacts', $contacts ?? []);
                    @endphp
                    @foreach($oldContacts as $index => $contact)
                        <div class="flex items-center mb-4 border bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none">
                            <input class="w-1/5 py-2 px-3 mr-2 outline-none" type="text" name="contacts[{{ $index }}][nom]" placeholder="Nom" value="{{ old('contacts.' . $index . '.nom', $contact['nom'] ?? '') }}" required>
                            <input class="w-1/5 py-2 px-3 mr-2 outline-none" type="text" name="contacts[{{ $index }}][prenom]" placeholder="Prénom" value="{{ old('contacts.' . $index . '.prenom', $contact['prenom'] ?? '') }}" required>
                            <input class="w-2/5 py-2 px-3 mr-2 outline-none" type="email" name="contacts[{{ $index }}][mail]" placeholder="Email" value="{{ old('contacts.' . $index . '.mail', $contact['mail'] ?? '') }}" required>
                            <div class="w-1/5 flex justify-center items-center">
                                <label class="mr-2">Oui</label>
                                <input type="radio" name="contacts[{{ $index }}][diffusion_mail]" value="1" {{ old('contacts.' . $index . '.diffusion_mail', $contact['diffusion_mail'] ?? '') == 1 ? 'checked' : '' }} required>
                                <label class="mx-2">Non</label>
                                <input type="radio" name="contacts[{{ $index }}][diffusion_mail]" value="0" {{ old('contacts.' . $index . '.diffusion_mail', $contact['diffusion_mail'] ?? '') == 0 ? 'checked' : '' }} required>
                            </div>
                            
                            @if($loop->index > 0)
                                <button class="ml-2 border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeContact(this)">x</button>
                            @endif
                        </div>
            
                        @error('contacts.' . $index . '.nom')
                            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                        @enderror
                        @error('contacts.' . $index . '.prenom')
                            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                        @enderror
                        @error('contacts.' . $index . '.mail')
                            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                        @enderror
                        @error('contacts.' . $index . '.diffusion_mail')
                            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                        @enderror
                    @endforeach
                @else
                    <div class="flex items-center mb-4 border bg-white rounded-md py-2 px-3">
                        <input class="w-1/5 py-2 px-3 mr-2" type="text" name="contacts[0][nom]" placeholder="Nom" required>
                        <input class="w-1/5 py-2 px-3 mr-2" type="text" name="contacts[0][prenom]" placeholder="Prénom" required>
                        <input class="w-2/5 py-2 px-3 mr-2" type="email" name="contacts[0][mail]" placeholder="Email" required>
                        <div class="w-1/5 flex justify-center items-center">
                            <label class="mr-2">Oui</label>
                            <input type="radio" name="contacts[0][diffusion_mail]" value="1" required>
                            <label class="mx-2">Non</label>
                            <input type="radio" name="contacts[0][diffusion_mail]" value="0" required>
                        </div>
                    </div>
            
                    @error('contacts.0.nom')
                        <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                    @enderror
                    @error('contacts.0.prenom')
                        <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                    @enderror
                    @error('contacts.0.mail')
                        <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                    @enderror
                    @error('contacts.0.diffusion_mail')
                        <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                    @enderror
                @endif
            </div>
            <button type="button" class="hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold" onclick="addContact()">Ajouter un contact +</button>
        </div>
        
        <!-- Champ caché pour enregistrer les contacts à supprimer -->
        <input type="hidden" id="contactsToDelete" name="contactsToDelete" value="">
    </div>        

    <div class="mt-4">
        <label class="m-1 block text-base font-medium text-blue1" for="zone">Zone(s) géographique(s)</label>
        @foreach($zones as $zone)
            <div class="flex items-center">
                <input type="checkbox" id="zone_{{ $zone->id }}" name="zones[]" value="{{ $zone->id }}"
                    @if(in_array($zone->id, old('zones', $zonesIds->toArray()))) checked @endif>
                <label for="zone_{{ $zone->id }}" class="ml-2 text-sm text-gray-700">{{ $zone->name }}</label>
            </div>
        @endforeach
        @error('zones')
            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
        @enderror
    </div>    
    <br>
    <div class="grid grid-cols-1 lg:grid-cols-3 justify-center">
        <div class="item-center">
            <label class="m-1 block text-base font-medium text-blue1" for="active">L'étude est t'elle toujours active ?</label>
            <input type="radio" name="active" value="1" id="oui" @checked(old('active', $etude->active) == 1) onchange="toggleStopYear()">
            <label for="oui">oui</label>
            <input type="radio" name="active" value="0" id="non" @checked(old('active', $etude->active) == 0) onchange="toggleStopYear()">
            <label for="non">non</label>
            @error('active')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
        </div>
    
        <div class="item-center">
            <label class="block text-base font-medium text-blue1" for="startyear">Année de début</label>
            <input class="flex items-center rounded-md border border-[#e0e0e0] bg-white py-3 px-6 mb-6 text-base text-[#6B7280] outline-none" 
                   type="number" name="startyear" value="{{ old('startyear', $etude->startyear) }}">
            @error('startyear')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
        </div>
    
        <div class="item-center" id="stopyear-container" style="display: none;">
            <label class="block text-base font-medium text-blue1" for="stopyear">Année de fin</label>
            <input class="flex items-center rounded-md border border-[#e0e0e0] bg-white py-3 px-6 mb-6 text-base text-[#6B7280] outline-none" 
                   type="number" name="stopyear" value="{{ old('stopyear', $etude->stopyear) }}">
            @error('stopyear')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
        </div>
    </div>
    <div class="mt-4">
        <label class="text-base font-medium text-blue1" for="frequence">Fréquence des relevés : </label>
            <select class="rounded-md border border-[#e0e0e0] bg-white p-1 text-base text-[#6B7280]" name="frequence" value="{{ old('frequence', $etude->frequence) }}">
                <option value="ponctuelle">ponctuelle</option>
                <option value="quotidienne">quotidienne</option>
                <option value="mensuelle">mensuelle</option>
                <option value="plurianuelle">plurianuelle</option>
                <option value="anuelle">anuelle</option>
            </select>
            @error('stopyear')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
    </div>
    <div class="mt-4">
        <label class="text-base font-medium text-blue1" for="reglementaire">L'étude est t'elle réglementaire ?</label>
            <input type="radio" name="reglementaire" value="1" id="oui" @checked(old('reglementaire', $etude->reglementaire) == 0)></input>
            <label for="oui">oui</label>
            <input type="radio" name="reglementaire" value="0" id="non" @checked(old('reglementaire', $etude->reglementaire) == 1)></input>
            <label for="non">non</label>
            @error('reglementaire')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
    </div>
    <div class="mt-4">
        <label class="text-base font-medium text-blue1" for="type">Type(s) des ressources produites</label>
        @foreach($types as $type)
            <div class="flex items-center">
                <input type="checkbox" id="zone_{{ $zone->id }}" name="types[]" value="{{ $type->id }}"
                    @if(in_array($type->id, old('types', $typesIds->toArray()))) checked @endif>
                <label for="zone_{{ $zone->id }}" class="ml-2 text-sm text-gray-700">{{ $type->name }}</label>
            </div>
        @endforeach
            @error('types')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
        </div>
    <div class="rounded-none bg-blue2 bg-opacity-5 shadow-md p-6 mt-4">
            <div id="liens-container">
                @if(isset($liens) && $liens->count() > 0)
                    <label class="m-1 block text-base font-medium text-blue1 pb-4" for="link_name">Lien(s)</label>
                    @foreach($liens as $index => $lien)
                        <div class="flex justify-between items-center mb-4 border bg-white rounded-md py-2 px-3">
                            <input type="text" class="w-1/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" id="link_name" name="link_name[]" value="{{ old('link_name.' . $index, $lien->link_name) }}">
                            @error('link_name.' . $index)
                                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                            @enderror
                            <input class="w-4/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" type="url" id="link_url" name="link_url[]" value="{{ old('link_url.' . $index, $lien->link_url) }}">
                            @error('link_url.' . $index)
                                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                            @enderror
                            <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeLink(this)">x</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <button class="hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold" type="button" id="add-link">Ajouter un lien +</button>
        </div>
    <br>
    <button class="w-full hover:shadow-md rounded-md bg-blue2 hover:bg-blue1 text-white py-3 px-5 text-base  font-semibold mb-10" >Enregistrer</button>
</div>
<div>
</form>

<script>
    document.getElementById('add-link').addEventListener('click', function() {
    var container = document.getElementById('liens-container');
    var index = container.querySelectorAll('.flex').length; // Compte le nombre actuel de lignes de lien
    
    // Création du nouvel élément pour un lien (nom et URL)
    var newLink = document.createElement('div');
    newLink.className = 'flex justify-between items-center mb-4 border bg-white rounded-md py-2 px-3';
    newLink.innerHTML = `
        <input type="text" class="w-1/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" name="link_name[]" placeholder="Nom du lien" required>
        <input type="url" class="w-4/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" name="link_url[]" placeholder="URL du lien" required>
        <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeLink(this)">x</button>
    `;
    
    // Ajoute la nouvelle ligne de lien dans le conteneur
    container.appendChild(newLink);
});

function removeLink(element) {
    // Supprime l'élément parent du bouton "x"
    element.closest('.flex').remove();
    
    // Re-numérotation des liens après suppression
    var links = document.querySelectorAll('#liens-container .flex');
    links.forEach(function(link, index) {
        link.querySelector('span').textContent = index + 1;
    });
}

let contactIndex = {{ isset($contacts) ? $contacts->count() : (old('contacts') ? count(old('contacts')) : 1) }};
let contactsToDelete = [];

// Fonction pour ajouter un contact
function addContact() {
    const contactsDiv = document.getElementById('contacts');
    const newContact = document.createElement('div');
    newContact.className = 'contact flex items-center mb-4 border bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none';
    newContact.innerHTML = `
        <input class="w-1/5 py-2 px-3 mr-2 outline-none" type="text" name="contacts[${contactIndex}][nom]" placeholder="Nom" required>
        <input class="w-1/5 py-2 px-3 mr-2 outline-none" type="text" name="contacts[${contactIndex}][prenom]" placeholder="Prénom" required>
        <input class="w-2/5 py-2 px-3 mr-2 outline-none" type="email" name="contacts[${contactIndex}][mail]" placeholder="Email" required>
        <div class="w-1/5 flex justify-center items-center">
            <label class="mr-2">Oui</label>
            <input type="radio" name="contacts[${contactIndex}][diffusion_mail]" value="1" required>
            <label class="mx-2">Non</label>
            <input type="radio" name="contacts[${contactIndex}][diffusion_mail]" value="0" required>
        </div>
        <button class="ml-2 border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeContact(this, null)">x</button>
    `;
    contactsDiv.appendChild(newContact);
    contactIndex++;
}

// Fonction pour supprimer un contact
function removeContact(element, contactId) {
    if (contactId) {
        contactsToDelete.push(contactId);
        document.getElementById('contactsToDelete').value = contactsToDelete.join(',');
    }
    element.closest('.flex').remove();
}


let sourceIndex = {{ isset($etude) ? $etude->sources->count() : (old('sources') ? count(old('sources')) : 1) }};

// Ajoute une nouvelle source
function addSource() {
    const sourcesDiv = document.getElementById('sources');
    const newSource = `
        <div class="flex items-center rounded-md border border-[#e0e0e0] bg-white py-3 px-6 mb-6 text-base text-[#6B7280] outline-none">
            <input class="flex-grow min-w-0 outline-none" type="text" name="sources[${sourceIndex}][name]" placeholder="Nom de la source" required>
            <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeSource(this)">x</button>
        </div>
    `;
    sourcesDiv.insertAdjacentHTML('beforeend', newSource);
    sourceIndex++;
}

// Supprime une source existante ou nouvelle
function removeSource(element) {
    const parentDiv = element.closest('.flex');
    parentDiv.remove();
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
    function toggleStopYear() {
        const activeValue = document.querySelector('input[name="active"]:checked').value;
        const stopYearContainer = document.getElementById('stopyear-container');
        
        if (activeValue == '0') {
            stopYearContainer.style.display = 'block';
        } else {
            stopYearContainer.style.display = 'none';
        }
    }

    toggleStopYear();
    </script>