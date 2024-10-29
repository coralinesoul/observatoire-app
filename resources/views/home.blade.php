@extends('base')
@section ('title',"L'observatoire")
@section ('content')

    <div class="flex flex-col lg:flex-row">
        <div class="basis-1/2 p-10 md:px-10 lg:px-20">
            <h1 class="text-3xl font-bold tracking-wide text-blue2 mt-1">Le golfe de Fos</h1>
            <br>
            <p class="font-serif">
                Le golfe de Fos est un territoire à haut potentiel économique, social et environnemental carractérisé par la coexistence de trois types d'espace très distincts.
            </p>
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
    
    <livewire:carousel />
@endsection