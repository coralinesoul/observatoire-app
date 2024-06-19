<div>
    <label for="source">Source :</label>
    <select wire:model="selectedSource" id="source">
        <option value="">Choisir une source...</option>
        @foreach($sources as $source)
            <option value="{{ $source->id }}">{{ $source->name }}</option>
        @endforeach
    </select>

    <label for="zone">Zone :</label>
    <select id="zone">
        <option value="">Choisir une zone...</option>
        @foreach($zones as $zone)
            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
        @endforeach
    </select>
</div>