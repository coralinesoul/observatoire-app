@extends('base')
@section ('title',"L'observatoire")
@section ('content')

    <div class=" p-10 sm:px-8 md:px-20 lg:px-30">
        <div class="basis-2/3">
            <a class="text-3xl font-bold tracking-wide text-blue2 mt-1 mb-8" href="https://www.institut-ecocitoyen.fr/">L'institut écocitoyen</a>
            <br><br>
            <p class="font-serif">
                Créé en 2010, l’Institut Écocitoyen est un centre de recherche scientifique sur l’<span class="font-bold text-blue1">effet des pollutions sur l’environnement et la santé humaine</span>. Grâce à un partenariat historique avec les organismes universitaires de la région (LCE, MIO, CEREGE, IMBE...), l’Institut crée une interface entre <span class="font-bold text-blue1">enjeux territoriaux et travaux de recherche</span>. Son expérience sur l’ensemble des domaines environnementaux et sanitaires autour du golfe de Fos et sa localisation à Fos-sur-Mer lui confère une place centrale dans le dispositif de cet Observatoire.
                <br>
                Il anime et organise le <span class="font-bold text-blue1">Comité de Pilotage de l’Observatoire</span>, réalise la maîtrise d’oeuvre d’études spécifiques au golfe de Fos et assure la <span class="font-bold text-blue1">centralisation des connaissances</span> sur les milieux marins et littoraux et la <span class="font-bold text-blue1">bancarisation</span> des données correspondantes. 
                <br>
                Les moyens matériels de l’Institut comprennent notamment deux sondes multi-paramètres (type CTD), un courantomètre ADCP, une bouteille Niskin de prélèvement d’eau, une benne à sédiments Van Veen, un filet à plancton, un filet manta pour les microplastiques, . Il dispose également d’un laboratoire de préparation d’échantillons et d’observation microscopique (loupe binoculaire et microscope optique) et de moyens de stockage et de conservation d’échantillons, qui pourront être <span class="font-bold text-blue1">mis à disposition en fonction des disponibilités, et des ressources</span>.
            </p>
        </div>
        <br>
        <div class="relative overflow-hidden">
            <div class="flex animate-slide gap-3">
                <!-- Images avec titres -->
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/CTD.jpg') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Sonde CTD</h3>
                </div>
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/filet_manta.jpg') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Filet Manta</h3>
                </div>
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/labo.JPG') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Laboratoire de l'institut</h3>
                </div>
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/plongee.JPG') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Matériel de plongée</h3>
                </div>
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/Niskin.jpg') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Bouteille de prélèvement d'eau</h3>
                </div>
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/sedimento.JPG') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Benne à sédiments</h3>
                </div>
                <!-- Duplication des images pour effet de boucle -->
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/CTD.jpg') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Sonde CTD</h3>
                </div>
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/filet_manta.jpg') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Filet Manta</h3>
                </div>
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/labo.JPG') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Laboratoire de l'institut</h3>
                </div>
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/plongee.JPG') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Matériel de plongée</h3>
                </div>
                <div class="relative flex-shrink-0 w-80" style="width: 20rem; height: 24rem;">
                    <img src="{{ asset('/Materiel/Niskin.jpg') }}" class="w-full h-4/5 rounded-lg object-cover" alt="Image">
                    <h3 class="text-center text-blue1 mt-2 font-bold">Bouteille de prélèvement d'eau</h3>
                </div>
            </div>
        </div>

    </div>
    <div class="flex flex-col md:flex-row pb-10 px-20">
        <div class="basis-2/3">
            <h1 class="text-3xl font-bold tracking-wide text-blue2 mt-1">Nous contacter</h1>
            <br>
            <p class="font-serif">
                Institut Ecocitoyen pour la Connaissance des Pollutions
            </br>
                Centre de Vie la Fossette - RD 268</br>
                13270 Fos-sur-Mer </br>
                France </br>
                Mails : contact@observatoire-golfe.fr </br>
                
                <br>
                Pour toutes demandes, veuillez vous adresser au standard au 04 90 55 49 94.
            </p>
        </div>
    </div>
    
</div>    
    <div class="px-28">
        <h1 class="text-3xl font-bold tracking-wide text-blue2 mt-1">Soutiens financiers</h1>
        <br>
        <br>
        <div class="flex items-center justify-between space-x-8 mt-4 lg:px-64 md:px-32">
            <a href="https://www.ampmetropole.fr" target="_blank">
                <img class="w-60 h-auto" src="{{ asset('/Logo_partenaires/AMP_metropole.png') }}" alt="AMP Métropole">
            </a>
            <a href="https://www.eaurmc.fr/" target="_blank">
                <img class="w-60 h-auto" src="{{ asset('/Logo_partenaires/Agence_eau.png') }}" alt="Agence de l'eau">
            </a>
            <a href="https://www.marseille-port.fr" target="_blank">
                <img class="w-60 h-auto" src="{{ asset('/Logo_partenaires/GPMM.png') }}" alt="GPMM">
            </a>
        </div>        
        <br>
    </div>
@endsection