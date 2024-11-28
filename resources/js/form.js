document.addEventListener('DOMContentLoaded', function() {
    function initializeAutocomplete(input) {
        const parentDiv = input.closest('.relative');  // Trouve le parent pour placer les suggestions
        let suggestionsDiv = parentDiv.querySelector('.suggestions');

        // Créer la div des suggestions seulement si elle n'existe pas déjà
        if (!suggestionsDiv) {
            suggestionsDiv = document.createElement('div');
            suggestionsDiv.classList.add('absolute', 'z-10', 'w-full', 'bg-white', 'border', 'border-gray-300', 'rounded-lg', 'shadow-lg', 'max-h-48', 'mt-1', 'overflow-y-auto');
            parentDiv.appendChild(suggestionsDiv);
        }

        input.addEventListener('input', function() {
            let query = this.value;

            if (query.length > 0) {
                fetch(`/api/sources?term=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionsDiv.innerHTML = '';  // Vider les suggestions précédentes

                        if (data.length > 0) {
                            data.forEach(source => {
                                let suggestion = document.createElement('div');
                                suggestion.innerText = source.name;
                                suggestion.classList.add('px-4', 'py-2', 'cursor-pointer', 'hover:bg-gray-200', 'border-b', 'border-gray-300');

                                suggestion.addEventListener('click', function() {
                                    input.value = source.name;
                                    suggestionsDiv.innerHTML = '';  // Vider les suggestions après sélection
                                });

                                suggestionsDiv.appendChild(suggestion);
                            });
                        } else {
                            suggestionsDiv.innerHTML = '';  // Si aucune suggestion, laisser l'utilisateur entrer manuellement
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des suggestions:', error);
                    });
            } else {
                suggestionsDiv.innerHTML = '';  // Si l'input est vide, vider les suggestions
            }
        });
    }

    // Initialisation pour les inputs de sources existants
    const sourceInputs = document.querySelectorAll('.source-input');
    sourceInputs.forEach(input => {
        const parentDiv = input.closest('.relative');
        if (parentDiv) {
            initializeAutocomplete(input);
        }
    });

    // Gérer l'ajout de nouvelles sources dynamiquement
    window.addSource = function() {
        const sourcesDiv = document.getElementById('sources');
        const newSource = document.createElement('div');
        newSource.classList.add('relative', 'flex', 'items-center', 'rounded-md', 'border', 'border-[#e0e0e0]', 'bg-white', 'py-3', 'px-6', 'mb-6', 'text-base', 'text-[#6B7280]', 'outline-none');
        newSource.innerHTML = `
            <div class="relative flex-grow">
                <input class="source-input w-full outline-none" type="text" name="sources[${sourceIndex}][name]" placeholder="Nom de la source" required>
                <div class="suggestions absolute z-10 w-full bg-white border border-gray-100 rounded-lg shadow-lg mt-1 max-h-48 overflow-y-auto"></div>
            </div>
            <button class="ml-2 border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeSource(this)">x</button>
        `;
        sourcesDiv.appendChild(newSource);
        sourceIndex++;

        // Initialiser l'autocomplétion pour le nouvel input
        const newInput = newSource.querySelector('.source-input');
        initializeAutocomplete(newInput);
    };

    // Fonction pour supprimer une source
    window.removeSource = function(button) {
        const parentDiv = button.closest('.flex');  // Trouver le parent flex pour supprimer l'input complet
        parentDiv.remove();  // Supprimer l'élément de la DOM
    };
});


document.getElementById('add-link').addEventListener('click', function() {
    var container = document.getElementById('liens-container');
    var index = container.querySelectorAll('.flex').length; // Compte le nombre actuel de lignes de lien
    
    var newLink = document.createElement('div');
    newLink.className = 'flex justify-between items-center mb-4 border bg-white rounded-md py-2 px-3';
    newLink.innerHTML = `
        <input type="text" class="w-1/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" name="link_name[]" placeholder="Nom du lien" required>
        <input type="url" class="w-4/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" name="link_url[]" placeholder="URL du lien" required>
        <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeLink(this)">x</button>
    `;
    container.appendChild(newLink);
});

// Fonction pour supprimer un lien
window.removeLink = function(element) {
    element.closest('.flex').remove();  
};

let contactIndex = 1;
let contactsToDelete = [];

window.addContact = function(element) {
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

window.removeContact = function(element, contactId) {
    if (contactId) {
        contactsToDelete.push(contactId);
        document.getElementById('contactsToDelete').value = contactsToDelete.join(',');
    }
    element.closest('.flex').remove();
}

let sourceIndex = 1;

window.addSource = function(element) {
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

window.removeSource = function(element) {
    const parentDiv = element.closest('.flex');
    parentDiv.remove();
}

window.removePdf = function(element, fichierId) {
    const pdfsToDelete = document.getElementById('pdfsToDelete').value;
    document.getElementById('pdfsToDelete').value = pdfsToDelete ? pdfsToDelete + ',' + fichierId : fichierId;
    element.closest('.flex').remove();
}

window.previewSelectedImage = function(event) {
    const reader = new FileReader();
    const imagePreview = document.getElementById('imagePreview');

    reader.onload = function() {
        if (reader.readyState === 2) {
            imagePreview.src = reader.result;
        }
    }

    reader.readAsDataURL(event.target.files[0]);
}

window.toggleStopYear = function() {
    const activeValue = document.querySelector('input[name="active"]:checked').value;
    const stopYearContainer = document.getElementById('stopyear-container');
    
    if (activeValue == '0') {
        stopYearContainer.style.display = 'block';
    } else {
        stopYearContainer.style.display = 'none';
    }
}

toggleStopYear();

window.onload = () => {
    const svg = document.querySelector('#svg-container svg'); // Le SVG
    const selectedZones = new Set(); // Set pour stocker les zones sélectionnées
    const zoneList = document.querySelector('#zone-list'); // Affichage des zones sélectionnées
    const hiddenInputs = document.querySelector('#hidden-inputs'); // Champs masqués
    const zoneNameHover = document.querySelector('#zone-name-hover');
    if (!svg) {
        console.error('SVG introuvable');
        return;
    }
        // Gérer les survols sur les zones
        svg.addEventListener('mouseover', (event) => {
            const zone = event.target.closest('g'); // Trouve le <g> parent si un élément est survolé
            if (!zone) return; // Ignore si on survole un autre élément non-zone
    
            const zoneName = zone.getAttribute('data-name'); // Récupère le nom de la zone à partir de data-name
    
            if (zoneName) {
                // Affiche le nom et positionne le span
                zoneNameHover.textContent = zoneName;
                const boundingBox = zone.getBoundingClientRect();
                zoneNameHover.style.left = `${boundingBox.left + boundingBox.width / 2}px`; // Position horizontale
                zoneNameHover.style.top = `${boundingBox.top - 25}px`; // Position verticale (au-dessus de la zone)
                zoneNameHover.classList.remove('hidden'); // Affiche le span
            }
        });
    
        svg.addEventListener('mouseout', (event) => {
            zoneNameHover.classList.add('hidden'); // Masque le nom lorsque la souris quitte la zone
        });
    // Zones déjà sélectionnées (passées par le backend via @json)
    const preSelectedZones = window.preSelectedZones || []; // Utilisation de la variable passée depuis Blade
    console.log('Pré-sélection des zones :', preSelectedZones); // Log initial des zones pré-sélectionnées
    // Ajouter les zones déjà sélectionnées au Set et aux inputs cachés
    preSelectedZones.forEach(zoneId => {
        selectedZones.add(String(zoneId));
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'zones[]'; // Assurez-vous que le nom correspond à ce que vous attendez en backend
        input.value = zoneId;
        hiddenInputs.appendChild(input);
        // Mettre à jour la couleur de la zone
        const zone = document.querySelector(`#zone${zoneId}`); // Ajout du préfixe 'zone' pour la validité du sélecteur
        if (zone) {
            zone.querySelectorAll('path').forEach(path => {
                path.setAttribute('fill', '#1d9fbf'); // Change la couleur de chaque élément path
            });            
        } else {
            console.warn(`Zone introuvable pour ID : #zone${zoneId}`);
        }
    });
    console.log('Zones sélectionnées après initialisation :', Array.from(selectedZones)); // Log après initialisation
    // Met à jour la liste affichée des zones sélectionnées
    const updateZoneList = () => {
        console.log('Mise à jour de la liste des zones. Zones actuelles :', Array.from(selectedZones));
        if (selectedZones.size > 0) {
            zoneList.textContent = Array.from(selectedZones)
                .map(zoneId => {
                    const zone = document.querySelector(`#zone${zoneId}`);
                    return zone ? zone.getAttribute('data-name') : `Zone inconnue (ID: ${zoneId})`;
                })
                .join(', ');
        } else {
            zoneList.textContent = 'Aucune';
        }
    };
    updateZoneList();
    // Gérer les clics sur les zones
    svg.addEventListener('click', (event) => {
        const zone = event.target.closest('g'); // Trouve le <g> parent si un élément est cliqué
        if (!zone) return; // Ignore si on clique hors des zones
        const zoneId = zone.getAttribute("id").replace('zone', ''); // Utilisation de l'ID réel de la zone sans préfixe
        if (selectedZones.has(zoneId)) {
            console.log(`Désélection de la zone : ${zoneId}`);
            selectedZones.delete(zoneId);
            document.querySelector(`input[value="${zoneId}"]`)?.remove(); // Supprime l'input masqué
            zone.querySelectorAll('path').forEach(path => {
                path.setAttribute('fill', '#185064'); // Réinitialise la couleur de chaque élément path
            });
        } else {
            console.log(`Sélection de la zone : ${zoneId}`);
            selectedZones.add(zoneId);
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'zones[]';
            input.value = zoneId;
            hiddenInputs.appendChild(input);
            zone.querySelector('path').setAttribute('fill', '#1d9fbf'); // Change la couleur
        }
        updateZoneList();
    });
};


