<div class=" bg-blue3 -mx-8">
    <div x-data="{ currentSlide: @entangle('currentSlide'), interval: null }"
        x-init="interval = setInterval(() => { currentSlide = (currentSlide + 1) % {{ count($slideViews) }} }, 30000)"
        class="relative w-full h-screen md:h-[80vh] lg:h-[75vh]">

        <!-- Diapositive 1 -->
        <div x-show="currentSlide === 0"
            x-transition:enter="transition ease-out duration-500 transform translate-x-full"
            x-transition:enter-end="transform translate-x-0"
            x-transition:leave="transition ease-in duration-500 transform -translate-x-full"
            class="absolute top-0 left-0 w-full h-full flex items-center sm:px-2 md:px-18 lg:px-28">
            @include('livewire.carousel.slide1')
        </div>

        <!-- Diapositive 2 -->
        <div x-show="currentSlide === 1"
            x-transition:enter="transition ease-out duration-500 transform translate-x-full"
            x-transition:enter-end="transform translate-x-0"
            x-transition:leave="transition ease-in duration-500 transform -translate-x-full"
            class="absolute top-0 left-0 w-full h-full flex items-center sm:px-2 md:px-18 lg:px-28">
            @include('livewire.carousel.slide2')
        </div>

        <!-- Diapositive 3 -->
        <div x-show="currentSlide === 2"
            x-transition:enter="transition ease-out duration-500 transform translate-x-full"
            x-transition:enter-end="transform translate-x-0"
            x-transition:leave="transition ease-in duration-500 transform -translate-x-full"
            class="absolute top-0 left-0 w-full h-full flex items-center sm:px-2 md:px-18 lg:px-28">
            @include('livewire.carousel.slide3')
        </div>

        <!-- Indicateurs de navigation -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <template x-for="index in 3" :key="index">
                <span @click="currentSlide = index - 1"
                    :class="{'bg-blue1': currentSlide === index - 1, 'bg-gray-300': currentSlide !== index - 1}"
                    class="w-3 h-3 rounded-full cursor-pointer transition-colors duration-300">
                </span>
            </template>
        </div>
    </div>
</div>