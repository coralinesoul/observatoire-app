@extends('base')
@section('title', 'user_tab')
@section('content')
<div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-white border-b">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">ID</th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Nom</th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Date de création</th>
                            <th class="text-right">
                              <button class="hover:shadow-md rounded-md bg-blue1 hover:bg-blue2 text-white py-2 px-4 text-base font-semibold">Ajouter une nouvelle étude +</button>
                          </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($etudes as $etude)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} border-b">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $etude->id }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $etude->title }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $etude->created_at->format('d/m/Y') }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
                                    <button class="hover:shadow-md rounded-md bg-blue2 hover:bg-blue1 text-white py-2 px-4 text-base font-semibold">Modifier</button>
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
