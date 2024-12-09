@extends('base')
@section('title', 'Mes études')
@section('content')

<script>
    // Effacer les données stockées dans sessionStorage lors du chargement de la page
    window.onload = function() {
        sessionStorage.removeItem('selectedZones');
    };
</script>

<div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-white border-b">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-center">ID</th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-center">Nom</th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-center">Dernière modification</th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-center">Date de création</th>
                            <th class="text-right">
                                <a href="{{ route('catalogue.create') }}" class="hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold">Ajouter une nouvelle étude +</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($etudes as $etude)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} border-b">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center text-gray-900">{{ $etude->id }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-center hover:text-blue2">
                                    <a href="{{ route('catalogue.find', ['slug' => $etude->slug, 'etude' => $etude->id]) }}">{{ $etude->title }}</a>
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-center">{{ $etude->updated_at->format('d/m/Y') }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-center">{{ $etude->created_at->format('d/m/Y') }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('catalogue.edit', ['etude' => $etude->id]) }}" class="hover:shadow-md rounded-md bg-blue2 hover:bg-blue1 text-white py-2 px-4 text-base font-semibold">Modifier</a>
                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('catalogue.destroy', $etude->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-2 hover:shadow-md rounded-md bg-red-500 hover:bg-red-600 text-white py-2 px-4 text-base font-semibold" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette étude ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

