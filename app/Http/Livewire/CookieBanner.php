<?php

// app/Http/Livewire/CookieBanner.php
namespace App\Http\Livewire;

use Livewire\Component;

class CookieBanner extends Component
{
    public $cookiesAccepted;

    public function mount()
    {
        $this->cookiesAccepted = session()->has('cookiesAccepted');
    }

    public function acceptCookies()
    {
        session()->put('cookiesAccepted', true);
        $this->cookiesAccepted = true;
    }

    public function render()
    {
        return view('livewire.cookie-banner');
    }
}
