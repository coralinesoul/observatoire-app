@extends('base')
@section ('title',"L'observatoire")
@section ('content')

    <div class=" p-10 sm:px-8 md:px-20 lg:px-30">
        <div class="basis-2/3">
            <a class="text-3xl font-bold tracking-wide text-blue2 mt-1 mb-8" href="https://www.institut-ecocitoyen.fr/">L'institut écocitoyen</a>
            <br><br>
            <p class="font-serif">
                Créé en 2010, l’Institut Écocitoyen est un centre de recherche scientifique sur l’environnement et sur l’effet des pollutions sur la santé humaine. Grâce à un partenariat historique avec les organismes universitaires en région (LCE, MIO, CEREGE, IMBE...), l’Institut Écocitoyen crée une interface entre enjeux territoriaux et travaux de recherche. Son expérience sur l’ensemble des domaines environnementaux et sanitaires autour du golfe de Fos et sa localisation à Fos-sur-Mer lui confère une place centrale dans le dispositif de l’observatoire.
Son rôle sera d’animer le comité de pilotage de l’observatoire. Il aura également pour mission d’assurer la centralisation des connaissances sur les milieux marins et littoraux et la bancarisation des données correspondantes. Afin de poursuivre et pérenniser le développement de la connaissance sur l’état de la masse d’eau du golfe de Fos, de ses littoraux et des lagunes côtières du périmètre, ainsi que pour maintenir des capacités d’intervention en situation accidentelle, l’observatoire devra assurer le maintien des moyens matériels et humains.
Ses moyens matériels comprennent : une sonde multiparamètres (type CTD), un courantomètre ADCP, une bouteille de prélèvement d’eau Niskin, une benne à sédiments Van Veen, un filet à plancton, un filet manta à microplastiques, un débitmètre à hélice (...). Il dispose en outre d’un laboratoire de préparation d’échantillons et d’observation microscopique (loupe binoculaire et microscope optique) et de moyens de stockage et de conservation d’échantillons, qui pourront être utilisés en fonction des disponibilités, des moyens humains et des financements d’études ou de suivis.
L’Institut Écocitoyen dispose également de moyens de plongée destinés au PMT (palme-masque-tuba) et d’un agent titulaire de l’aptitude à travailler en milieu hyperbare niveau B0. Les capacités de navigation sont assurés grâce aux réseaux locaux et citoyens, qui permettent à l’Institut Ecocitoyen de réagir très rapidement avec les moyens à la mer ou de plongée (avec ou sans bouteille) nécessaires.
            </p>
        </div>
        <br>
<div class="relative overflow-hidden">
    <div class="flex animate-slide" style="gap: 0;">
        <!-- Images -->
        <img src="{{asset('/Materiel/CTD.jpg')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <img src="{{asset('/Materiel/filet_manta.jpg')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <img src="{{asset('/Materiel/labo.JPG')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <img src="{{asset('/Materiel/plongee.JPG')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <img src="{{asset('/Materiel/Niskin.jpg')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <img src="{{asset('/Materiel/sedimento.JPG')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <!-- Duplication des images pour créer un effet de boucle -->
        <img src="{{asset('/Materiel/CTD.jpg')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <img src="{{asset('/Materiel/filet_manta.jpg')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <img src="{{asset('/Materiel/labo.JPG')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <img src="{{asset('/Materiel/plongee.JPG')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
        <img src="{{asset('/Materiel/Niskin.jpg')}}" class="rounded-lg w-80 h-80 mr-3" alt="Image">
    </div>
</div>

        
        
        
    </div>
    <div class="flex flex-col md:flex-row p-10 px-20">
        <div class="basis-2/3">
            <h1 class="text-3xl font-bold tracking-wide text-blue2 mt-1">Contact</h1>
            <br>
            <p class="font-serif">
                Institut Ecocitoyen pour la Connaissance des Pollutions
            </br>
                Centre de vie la Fossette RD 268 </br>
                13270 Fos-sur-Mer </br>
                France </br>
                Mail : contact@observatoire-golfe.fr ;  contact@institut-ecocitoyen.fr</br>
                
                <br>
                Pour toutes demande, veuillez vous adressez au standard au 04 90 55 49 94.
            </p>
        </div>
    </div>
    
</div>    
    <div class="px-28">
        <h1 class="text-3xl font-bold tracking-wide text-blue2 mt-1">Les partenaires</h1>
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