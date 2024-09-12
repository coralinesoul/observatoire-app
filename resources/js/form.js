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
