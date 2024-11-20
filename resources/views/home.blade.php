@extends('base')
@section ('title',"L'observatoire")
@section ('content')

    <div class="flex flex-col lg:flex-row">
        <div class="basis-1/2 p-10 md:px-10 lg:px-20">
            <h1 class="text-3xl font-bold tracking-wide text-blue2 mt-1">Le golfe de Fos</h1>
            <br>
            <p class="font-serif">
                C’ est un territoire à haut potentiel <span class="font-bold text-blue1">économique, social et environnemental</span> caractérisé par la coexistence de trois types d'espaces très distincts.
            </p>
            <br>
            <div class="flex justify-between p-10">
                <div class="text-center">
                    <i class="fa-solid fa-city text-blue2 text-4xl md:text-6xl lg:text-7xl"></i>
                    <h2 class="text-blue1 font-bold text-md md:text-lg">Milieux urbains</h2>
                </div>
                <div class="text-center">
                    <i class="fa-solid fa-industry lg:fa-7x text-blue2 text-4xl md:text-6xl lg:text-7xl"></i>
                    <h2 class="text-blue1 font-bold text-md md:text-lg">Zones <br> industrialo-portuaires</h2>
                </div>
                <div class="text-center">
                    <i class="fa-solid fa-tree lg:fa-7x text-blue2 text-4xl md:text-6xl lg:text-7xl"></i>
                    <h2 class="text-blue1 font-bold text-md md:text-lg">Grands espaces <br> naturels classés</h2>
                </div>
            </div>
            <p class="font-serif">
                Dans cet environnement particulier, <span class="font-bold text-blue1">les rejets atmosphériques</span>, <span class="font-bold text-blue1">les sites et sols pollués</span> situés sur le littoral, <span class="font-bold text-blue1">les effluents marins</span> et <span class="font-bold text-blue1">l’utilisation de l’eau de mer dans le cadre de procédés industriels</span> peuvent, impacter les écosystèmes marins à court ou long-terme. 
                <br>
                Le développement économique du golfe, intégrant les grands projets sur le nautisme, les activités halieutiques, touristiques et industrialo-portuaires, répond à des enjeux forts, parfois paradoxaux, qui nécessitent de développer des instruments de gestion environnementale <span class="font-bold text-blue1">coordonnés et adaptés aux spécificités du milieu marin</span>, fondés sur la connaissance précise des paramètres d’équilibre écologique. 
                <br>
                Dans ce cadre, <span class="font-bold text-blue1">des mesures régulières</span> sont réalisées par plusieurs acteurs institutionnels, scientifiques, citoyens... Les résultats et l'interprétation des différents travaux ont permis d'acquérir des connaissances sur la présence, la réactivité et la toxicité de <span class="font-bold text-blue1">certains polluants</span> dans le golfe. 
                <br>
                Les conclusions montrent qu'une <span class="font-bold text-blue1">attention particulière</span> doit être portée aux principales familles de <span class="font-bold text-blue1">polluants "classiques"</span>, comme à celles des <span class="font-bold text-blue1">polluants "émergents"</span>. 
                <br>
                Pour organiser <span class="font-bold text-blue1">la collaboration</span> entre les différents acteurs et mieux répondre aux <span class="font-bold text-blue1">besoins de connaissance, de gestion et d'amélioration de l'état des milieux</span>, l'Observatoire du golfe de Fos a été mis en œuvre depuis 2022.
            </p>
        </div>
        <div class="basis-1/2 p-10">
            <img src="{{asset('Golfe.png') }}" class ="rounded-lg" alt="Image"></img>
        </div>
    </div>
    
    <livewire:carousel />
@endsection