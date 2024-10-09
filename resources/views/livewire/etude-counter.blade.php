<div class="justify-center" x-data="{ count: 0 }" x-init="
    let target = {{ $studyCount }};
    let interval = setInterval(() => {
        if (count < target) {
            count++;
        } else {
            clearInterval(interval);
        }
    }, 50);">
    
    <!-- Affichage du compteur -->
    <div class="flex text-9xl font-bold font-mono text-blue1">
        <span x-text="count"></span> 
    </div>
    <div class="flex text-xl text-blue1 font-bold">études référencées</div>
</div>
