<?php

namespace App\Livewire;

use Livewire\Component;

class Carousel extends Component
{
    public $currentSlide = 0;
    public $slideViews = [
        'livewire.carousel.slide1',
        'livewire.carousel.slide2',
        'livewire.carousel.slide3',
    ];

    public function render()
    {
        return view('livewire.carousel');
    }
}
