@extends('base')
@section ('title',"A propos")
@section ('content')
    <!-- component -->
    <h1 class="text-blue1 font-bold text-2xl mt-2">Les objectifs de l'observatoire</h1>
    <br>
    <div class="w-full h-[80vh]">
        <input
        class="hidden peer/slider1 checkbox"
        type="radio"
        name="slider"
        id="slider1"
        checked
        />
        <input
        class="hidden peer/slider2 checkbox"
        type="radio"
        name="slider"
        id="slider2"
        />
        <input
        class="hidden peer/slider3 checkbox"
        type="radio"
        name="slider"
        id="slider3"
        />

        <div
        class="relative w-[300vw] h-[100%] flex transition-all duration-500 ease-in-out peer-checked/slider1:-left-0 peer-checked/slider2:-left-[100vw] peer-checked/slider3:-left-[200vw]"
        >
        <div class="relative w-full h-full flex p-8">
            <h1 class="text-blue1 font-bold text-2xl mt-2">Faire l'inventaire des données</h1>


        </div>
        <div class="relative w-full h-full flex bg-amber-500"></div>
        <div class="relative w-full h-full flex bg-emerald-500"></div>
        </div>

        <div
        class="absolute w-full flex justify-center gap-2 bottom-12 peer-[&_label:nth-of-type(1)]/slider1:peer-checked/slider1:opacity-100 peer-[&_label:nth-of-type(1)]/slider1:peer-checked/slider1:w-10 peer-[&_label:nth-of-type(2)]/slider2:peer-checked/slider2:opacity-100 peer-[&_label:nth-of-type(2)]/slider2:peer-checked/slider2:w-10 peer-[&_label:nth-of-type(3)]/slider3:peer-checked/slider3:opacity-100 peer-[&_label:nth-of-type(3)]/slider3:peer-checked/slider3:w-10"
        >
        <label
            class="block w-5 h-5 bg-blue2 cursor-pointer opacity-50 z-10 transition-all duration-300 ease-in-out hover:scale-125 hover:opacity-100"
            for="slider1"
        >
        </label>
        <label
            class="block w-5 h-5 bg-blue2 cursor-pointer opacity-50 z-10 transition-all duration-300 ease-in-out hover:scale-125 hover:opacity-100"
            for="slider2"
        >
        </label>
        <label
            class="block w-5 h-5 bg-blue2 cursor-pointer opacity-50 z-10 transition-all duration-300 ease-in-out hover:scale-125 hover:opacity-100"
            for="slider3"
        >
        </label>
        </div>
    </div>
    <div>
        <h1 class="text-blue1 font-bold text-2xl mt-2">L'institut écocitoyen</h1>
    </div>
    <div>
        Les partenaires
    </div>
@endsection