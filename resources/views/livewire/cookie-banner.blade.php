<!-- resources/views/livewire/cookie-banner.blade.php -->
<div>
    @if (!$cookiesAccepted)
        <div class="fixed bottom-0 left-0 right-0 bg-blue1 text-white p-4 z-50">
            <div class="container mx-auto flex justify-between items-center">
                <p class="text-sm">
                    Nous utilisons des cookies pour améliorer votre expérience sur notre site. En continuant à naviguer sur ce site, vous acceptez notre utilisation des cookies.
                </p>
                <button wire:click="acceptCookies" class="bg-blue2 hover:bg-opacity-50 text-white font-bold py-2 px-4 rounded">
                    Accepter les cookies
                </button>
            </div>
        </div>
    @endif
</div>
