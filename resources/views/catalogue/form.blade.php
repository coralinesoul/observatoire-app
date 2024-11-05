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
            <p class="text-sm text-right tex-blue1"><span class="text-red-600">*</span> champs obligatoires</p>
            <label class="m-1 block text-base font-medium text-blue1" for="title">Titre court de l'étude<span class="text-red-600">*</span></label>
            <input class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" type="text" class="form-control" name="title" value="{{old('title', $etude->title)}}">
                @error('title')
                    <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
                @enderror
            <label class="m-1 block text-base font-medium text-blue1" for="longtitle">Titre long de l'étude</label>
            <input class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" type="text" class="form-control" name="longtitle" value="{{old('longtitle', $etude->longtitle)}}">
                @error('longtitle')
                    <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
                @enderror
             <label class="m-1 block text-base font-medium text-blue1" for="Resume">Desciption de l'étude<span class="text-red-600">*</span></label>
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
                Choisir une image
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
        @error('themes')
            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
        @enderror
    </div>
    <br>

    <div class="grid grid-cols-1 lg:grid-cols-4 lg:space-y-0 lg:space-x-6 md:space-y-6">
        <div class="rounded-none bg-blue2 bg-opacity-5 shadow-md p-6">
            <div id="sources">
                <label class="m-1 block text-base font-medium text-blue1 pb-4">Structure productrice<span class="text-red-600">*</span></label>
                @if(old('sources') || isset($etude) && $etude->sources()->count() > 0)
                    @php
                        $oldSources = old('sources', $etude->sources()->pluck('name', 'id')->toArray());
                    @endphp
                    @foreach($oldSources as $id => $sourceName)
                        <div class="relative flex items-center rounded-md border border-[#e0e0e0] bg-white py-3 px-6 mb-6 text-base text-[#6B7280] outline-none">
                            <div class="relative flex-grow">
                                <input class="source-input w-full outline-none" type="text" name="sources[{{ $id }}][name]" placeholder="Nom de la source" value="{{ is_array($sourceName) ? $sourceName['name'] : $sourceName }}" required>
                                <div class="suggestions relative w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-48 overflow-y-auto"></div>
                            </div>
                            @if($loop->index > 0)
                                <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeSource(this)">x</button>
                            @endif
                        </div>
                        @error('sources.' . $id . '.name')
                            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                        @enderror
                    @endforeach
                @else
                    <div class="relative flex-grow mb-6">
                        <div class="relative flex-grow rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base text-[#6B7280] outline-none">
                            <input class="source-input w-full outline-none" type="text" name="sources[0][name]" placeholder="Nom de la source" required>
                            <div class="suggestions relative w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-48 overflow-y-auto"></div>
                        </div>
                    </div>
                    @error('sources.0.name')
                        <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                    @enderror
                @endif
            </div>
            <button type="button" class="hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold" onclick="addSource()">Ajouter une autre source +</button>
        </div>
        

        <div class="rounded-none bg-blue2 bg-opacity-5 shadow-md p-6 col-span-3">
            <label class="block text-base font-medium text-blue1 pb-4">Contact<span class="text-red-600">*</span></label>
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
        <label class="m-1 block text-base font-medium text-blue1" for="zone">Zones géographiques<span class="text-red-600">*</span></label>
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
            <label class="m-1 block text-base font-medium text-blue1" for="active">L'étude est t'elle toujours active ?<span class="text-red-600">*</span></label>
            <input type="radio" name="active" value="1" id="oui" @checked(old('active', $etude->active) == 1) onchange="toggleStopYear()">
            <label for="oui">oui</label>
            <input type="radio" name="active" value="0" id="non" @checked(old('active', $etude->active) == 0) onchange="toggleStopYear()">
            <label for="non">non</label>
            @error('active')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
        </div>
    
        <div class="place-items-center">
            <label class="block text-base font-medium text-blue1" for="startyear">Année de début<span class="text-red-600">*</span></label>
            <input class="flex rounded-md border border-[#e0e0e0] min-w-32 bg-white py-3 px-6 mb-6 text-base outline-gray-500 text-[#6B7280]" 
                   type="number" name="startyear" value="{{ old('startyear', $etude->startyear) }}">
            @error('startyear')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
        </div>
    
        <div class="place-items-center" id="stopyear-container" style="display: none;">
            <label class="block text-base font-medium text-blue1" for="stopyear">Année de fin</label>
            <input class="flex items-center rounded-md border min-w-32 border-[#e0e0e0] bg-white py-3 px-6 mb-6 text-base outline-gray-500 text-[#6B7280]" 
                   type="number" name="stopyear" value="{{ old('stopyear', $etude->stopyear) }}">
            @error('stopyear')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
        </div>
    </div>
    <div class="mt-4">
        <label class="text-base font-medium text-blue1" for="frequence">Fréquence des relevés<span class="text-red-600">*</span> </label>
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
        <label class="text-base font-medium text-blue1" for="reglementaire">L'étude est t'elle réglementaire ?<span class="text-red-600">*</span></label>
            <input type="radio" name="reglementaire" value="1" id="oui" @checked(old('reglementaire', $etude->reglementaire) == 0)></input>
            <label for="oui">oui</label>
            <input type="radio" name="reglementaire" value="0" id="non" @checked(old('reglementaire', $etude->reglementaire) == 1)></input>
            <label for="non">non</label>
            @error('reglementaire')
                <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{$message}}</div>
            @enderror
    </div>
    <div class="mt-4">
        <label class="text-base font-medium text-blue1" for="type">Types des ressources produites<span class="text-red-600">*</span></label>
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
            <label class="m-1 block text-base font-medium text-blue1 pb-4" for="link_name">Lien</label>
        
            @php
                $oldLinks = old('link_name', []); // Récupère les anciens noms des liens soumis
                $oldUrls = old('link_url', []); // Récupère les anciennes URLs soumises
            @endphp
        
            {{-- Si des liens ont été soumis et échoués, les afficher avec old() --}}
            @if(count($oldLinks) > 0)
                @foreach($oldLinks as $index => $linkName)
                    <div class="flex justify-between items-center mb-4 border bg-white rounded-md py-2 px-3">
                        <input type="text" class="w-1/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" name="link_name[{{ $index }}]" value="{{ $linkName }}" placeholder="Nom du lien" required>
                        @error('link_name.' . $index)
                            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                        @enderror
                        <input class="w-4/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" type="url" name="link_url[{{ $index }}]" value="{{ old('link_url.' . $index) }}" placeholder="URL du lien" required>
                        @error('link_url.' . $index)
                            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                        @enderror
                        <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeLink(this)">x</button>
                    </div>
                @endforeach
            {{-- Si aucune ancienne valeur, afficher les liens existants de la base de données --}}
            @elseif(isset($liens) && $liens->count() > 0)
                @foreach($liens as $index => $lien)
                    <div class="flex justify-between items-center mb-4 border bg-white rounded-md py-2 px-3">
                        <input type="text" class="w-1/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" name="link_name[{{ $index }}]" value="{{ $lien->link_name }}" placeholder="Nom du lien" required>
                        @error('link_name.' . $index)
                            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                        @enderror
                        <input class="w-4/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" type="url" name="link_url[{{ $index }}]" value="{{ $lien->link_url }}" placeholder="URL du lien" required>
                        @error('link_url.' . $index)
                            <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
                        @enderror
                        <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeLink(this)">x</button>
                    </div>
                @endforeach
            @endif
        </div>
        
        {{-- Bouton pour ajouter un nouveau lien --}}
        <button class="hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold" type="button" id="add-link">Ajouter un lien +</button>
    </div>        
    <br>
    <div class="rounded-none bg-blue2 bg-opacity-5 shadow-md p-6 mt-4">
        <label class="block text-base font-medium text-blue1 pb-4">Fichier PDF</label>

        <div id="pdf-container">
            @if(isset($etude) && $etude->fichiers->count() > 0)
                @foreach($etude->fichiers as $index => $fichier)
                    <div class="flex justify-between items-center mb-4 border bg-white rounded-md py-2 px-3">
                        <input type="text" class="w-4/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" value="{{ $fichier->nom }}" readonly>
                        <a href="{{ asset('/storage/' . $fichier->chemin) }}" target="_blank" class="text-blue2 hover:text-blue1">Voir</a>
                        <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removePdf(this, {{ $fichier->id }})">x</button>
                    </div>
                @endforeach
            @endif
        </div>
        <livewire:file-add />
    </div>
    @error('fichiers.*')
        <div class="rounded-md my-1 text-red-700 bg-red-100 border border-red-300 p-2">{{ $message }}</div>
    @enderror
    <input type="file" name="fichiers[]" id="pdf-upload" class="hidden" multiple>
    <input type="hidden" name="pdfsToDelete" id="pdfsToDelete" value="">
    <br>
    <button class="w-full hover:shadow-md rounded-md bg-blue2 hover:bg-blue1 text-white py-3 px-5 text-base  font-semibold mb-10" >Enregistrer</button>
</div>
    @vite(['resources/css/app.css', 'resources/js/form.js'])
</form>