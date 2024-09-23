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

function removeLink(element) {
    element.closest('.flex').remove();
}

let contactIndex = 1;
let contactsToDelete = [];

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

function removeContact(element, contactId) {
    if (contactId) {
        contactsToDelete.push(contactId);
        document.getElementById('contactsToDelete').value = contactsToDelete.join(',');
    }
    element.closest('.flex').remove();
}

let sourceIndex = 1;

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

document.getElementById('add-pdf').addEventListener('click', function() {
    document.getElementById('pdf-upload').click();
});

document.getElementById('pdf-upload').addEventListener('change', function() {
    const container = document.getElementById('pdf-container');
    const files = this.files;

    for (let i = 0; i < files.length; i++) {
        const fileName = files[i].name;
        
        const newPdf = document.createElement('div');
        newPdf.className = 'flex justify-between items-center mb-4 border bg-white rounded-md py-2 px-3';
        newPdf.innerHTML = `
            <input type="text" class="w-4/6 bg-white rounded-md py-2 px-3 text-[#6B7280] outline-none" value="${fileName}" readonly>
            <button class="ml-auto border font-bold rounded-md border-red-500 text-red-500 hover:text-white hover:bg-red-500 px-2" type="button" onclick="removeNewPdf(this)">x</button>
        `;
        container.appendChild(newPdf);
    }
});

function removePdf(element, fichierId) {
    const pdfsToDelete = document.getElementById('pdfsToDelete').value;
    document.getElementById('pdfsToDelete').value = pdfsToDelete ? pdfsToDelete + ',' + fichierId : fichierId;
    element.closest('.flex').remove();
}

function removeNewPdf(element) {
    element.closest('.flex').remove();
}
