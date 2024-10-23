@extends('base')
@section ('title',"L'observatoire")
@section ('content')

    <div class="flex flex-col md:flex-row">
        <div class="basis-1/2 p-10 px-20">
            <h1 class="text-3xl font-bold tracking-wide text-blue2 mt-1">Le golfe de Fos</h1>
            <br>
            <p class="font-serif">
                Le golfe de Fos est un territoire à haut potentiel économique, social et environnemental carractérisé par la coexistence de trois types d'espace très distincts.
            </p>
            <div class="flex justify-between p-10">
                <div class="text-center">
                    <i class="fa-solid fa-city fa-7x text-blue2"></i>
                    <h2 class="text-blue1 font-bold text-lg">Milieux urbains</h2>
                </div>
                <div class="text-center">
                    <i class="fa-solid fa-industry fa-7x text-blue2"></i>
                    <h2 class="text-blue1 font-bold text-lg">Zones <br> industrialo-portuaires</h2>
                </div>
                <div class="text-center">
                    <i class="fa-solid fa-tree fa-7x text-blue2"></i>
                    <h2 class="text-blue1 font-bold text-lg">Grands espaces <br> naturels classés</h2>
                </div>
            </div>
            <p class="font-serif">
                Dans cet environnement particulier, les rejets atmosphériques, les sites et sols pollués situés sur le littoral, 
                les effluents marins et l’utilisation de l’eau de mer dans le cadre de procédés industriels peuvent, sur un long terme, 
                impacter la vie et les équilibres marins.
                Le développement économique du golfe, intégrant les grands projets sur le nautisme, les activités halieutiques, touristiques 
                et industrialo-portuaires, répond à des enjeux forts, parfois paradoxaux, qui nécessitent de développer des instruments 
                de gestion environnementale coordonnés et adaptés aux spécificités du milieu marin, fondés sur la connaissance précise 
                des paramètres d’équilibre écologique.
                Dans ce cadre, des mesures régulières sont réalisées par plusieurs acteurs institutionnels, scientifiques, citoyens... 
                <br> Les résultats et l'interprétation des différents travaux ont permis d'acquérir des connaissances sur la présence, 
                la réactivité et la toxicité de certains polluants dans le golfe. Les conclusions montrent qu'une attention particulière 
                doit être portée aux principales familles de polluants "classiques", comme "émergeants". Pour organiser la collaboration 
                entre les différents acteurs et mieux répondre aux besoins de connaissance, de gestion et d'amélioration de l'état des milieux, l'observatoire du Golfe de Fos a été construit depuis 2022.
            </p>

        </div>
        <div class="basis-1/2 p-10">
            <img src="{{asset('Golfe.png') }}" class ="rounded-lg" alt="Image"></img>
        </div>
    </div>

    <div class="relative w-full h-[80vh] bg-white">
        <input class="hidden peer/slider1 checkbox" type="radio" name="slider" id="slider1" checked/>
        <input class="hidden peer/slider2 checkbox" type="radio" name="slider" id="slider2"/>
        <input class="hidden peer/slider3 checkbox" type="radio" name="slider" id="slider3"/>

        <div class="relative w-[300vw] h-[100%] -ml-8 flex transition-all duration-500 ease-in-out peer-checked/slider1:-left-0 peer-checked/slider2:-left-[100vw] peer-checked/slider3:-left-[200vw]">
            <div class="relative w-full h-full flex bg-blue2 bg-opacity-10">
                <div class="px-28">
                    <h1 class="text-3xl font-bold tracking-wide text-blue1 mt-8">Centraliser les données</h1>
                    <br>
                    <livewire:etude-counter />
                    <p class="font-serif">
                        L'observatoire du golfe de Fos a pour objectif de regrouper les connaissances déjà existantes. C'est dans cette perceptive que le catalogue a été crée. Il s'agit d'un outil permettant à tout le monde de consulter les études identifiées sur le golfe de Fos. Il s'appuie sur une base de données qui permet de caractériser les mesures effectuées et ainsi de filtrer sa recherche selon des besoins spécifiques. Afin de permettre un inventaire le plus complet possible et intégrant la grande diversité des connaissances et de leur producteur, chaque étude est référencée dans une page permettant d’accéder aux données produites, aux rapports ou articles disponibles ou à des informations de contacts en fonction de ce qui est décidé par le producteur. 
                        Cette inventaire est dynamique, les différents acteurs et actrices du golfe de Fos peuvent avoir un compte et ainsi intégrer leurs informations. 
                    </p>
                </div>
            </div>
            
            <div class="relative w-full h-full flex bg-blue2 bg-opacity-10">
                <div class="px-28">
                    <h1 class="text-3xl font-bold tracking-wide text-blue1 mt-8">Produire de la connaissance</h1>
                    <div class="flex flex-wrap mt-8">
                        <div class="basis-1/2">
                            <img src="{{ asset('salinité.webp') }}" class="rounded-lg w-3/4 h-auto mx-auto" alt="Image">
                        </div>
                        <div class="basis-1/2 p-16 flex items-center">
                            <p class="font-serif">
                                Actuellement, plusieurs relevés sont réalisés par l’Institut écocitoyen pour la connaissance des pollutions de Fos-sur-Mer dans le cadre de l’observatoire. Ces études répondent à des besoins pour poursuivre et pérenniser le développement de connaissance de l’état de la masse d’eaux côtière du golfe de Fos, de la bande littorale et des lagunes côtières du périmètre défini (acquisition de données environnementales adaptées aux spécificités et aux attentes du territoire, prévention des impacts, suivi des pressions, protection et réhabilitation des milieux). Le maintien de moyens d’intervention est également prévu dans le cadre de l’observatoire en cas de situation accidentelle. 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            
        
            <div class="relative w-full h-full flex bg-blue2 bg-opacity-10">
                <div class="px-28">
                    <br>
                    <h1 class="text-3xl font-bold tracking-wide text-blue1 mt-8">Mettre en lien, informer, partager</h1>
                    <p class="font-serif">
                        L’observatoire a pour objectif d’impliquer un large panel d’acteurs et d’actrices locaux réunis dans un comité de pilotage permettant ainsi d’animer la réflexion sur les objectifs à fixer et sur les moyens mis en œuvre pour les atteindre. Ainsi, l’observatoire peut appuyer des demandes de financements d’études et/ou de suivi.                     </p>
                </div>
            </div>
        </div>

        <div
        class="absolute w-full flex justify-center gap-2 bottom-12 peer-[&_label:nth-of-type(1)]/slider1:peer-checked/slider1:opacity-100 peer-[&_label:nth-of-type(1)]/slider1:peer-checked/slider1:w-10 peer-[&_label:nth-of-type(2)]/slider2:peer-checked/slider2:opacity-100 peer-[&_label:nth-of-type(2)]/slider2:peer-checked/slider2:w-10 peer-[&_label:nth-of-type(3)]/slider3:peer-checked/slider3:opacity-100 peer-[&_label:nth-of-type(3)]/slider3:peer-checked/slider3:w-10"
        >
        <label
            class="block w-5 h-5 bg-blue1 cursor-pointer opacity-50 z-10 transition-all duration-300 ease-in-out hover:scale-125 hover:opacity-100"
            for="slider1"
        >
        </label>
        <label
            class="block w-5 h-5 bg-blue1 cursor-pointer opacity-50 z-10 transition-all duration-300 ease-in-out hover:scale-125 hover:opacity-100"
            for="slider2"
        >
        </label>
        <label
            class="block w-5 h-5 bg-blue1 cursor-pointer opacity-50 z-10 transition-all duration-300 ease-in-out hover:scale-125 hover:opacity-100"
            for="slider3"
        >
        </label>

        </div>
    </div>
    <div class="flex flex-col md:flex-row p-10 px-20">
        <div class="basis-2/3">
            <h1 class="text-3xl font-bold tracking-wide text-blue2 mt-1">L'institut écocitoyen</h1>
            <br>
            <p class="font-serif">
                Créé en 2010, l’Institut Écocitoyen est un centre de recherche scientifique sur l’environnement et sur l’effet des pollutions sur la santé humaine. Grâce à un partenariat historique avec les organismes universitaires en région (LCE, MIO, CEREGE, IMBE...), l’Institut Écocitoyen crée une interface entre enjeux territoriaux et travaux de recherche. Son expérience sur l’ensemble des domaines environnementaux et sanitaires autour du golfe de Fos et sa localisation à Fos-sur-Mer lui confère une place centrale dans le dispositif de l’observatoire.
Son rôle sera d’animer le comité de pilotage de l’observatoire. Il aura également pour mission d’assurer la centralisation des connaissances sur les milieux marins et littoraux et la bancarisation des données correspondantes. Afin de poursuivre et pérenniser le développement de la connaissance sur l’état de la masse d’eau du golfe de Fos, de ses littoraux et des lagunes côtières du périmètre, ainsi que pour maintenir des capacités d’intervention en situation accidentelle, l’observatoire devra assurer le maintien des moyens matériels et humains.
Ses moyens matériels comprennent : une sonde multiparamètres (type CTD), un courantomètre ADCP, une bouteille de prélèvement d’eau Niskin, une benne à sédiments Van Veen, un filet à plancton, un filet manta à microplastiques, un débitmètre à hélice (...). Il dispose en outre d’un laboratoire de préparation d’échantillons et d’observation microscopique (loupe binoculaire et microscope optique) et de moyens de stockage et de conservation d’échantillons, qui pourront être utilisés en fonction des disponibilités, des moyens humains et des financements d’études ou de suivis.
L’Institut Écocitoyen dispose également de moyens de plongée destinés au PMT (palme-masque-tuba) et d’un agent titulaire de l’aptitude à travailler en milieu hyperbare niveau B0. Les capacités de navigation sont assurés grâce aux réseaux locaux et citoyens, qui permettent à l’Institut Ecocitoyen de réagir très rapidement avec les moyens à la mer ou de plongée (avec ou sans bouteille) nécessaires.
            </p>
        </div>
        <div class="basis-1/3 flex justify-center items-start p-10">
            <img src="{{asset('test.jpg')}}" class="rounded-lg w-64 h-auto" alt="Image">
        </div>
    </div>
    
</div>    
    <div class="px-28">
        <h1 class="text-3xl font-bold tracking-wide text-blue2 mt-1">Les partenaires</h1>
        LOGO
    </div>
@endsection