@extends('base')

@section('content')
<div class="flex justify-center h-dvh p-10">
    <form class="w-1/2 flex flex-col items-center" action="{{ route('password.update') }}" method="POST">
        @csrf
        <h2 class="text-blue1 font-bold text-2xl mt-2">Réinitialiser le mot de passe</h2>
        <br>
        <input type="hidden" name="token" value="{{ $token }}">
        
        <div class="w-full">
            <label for="email" class="mb-3 block text-base font-medium text-blue1"">Adresse e-mail</label>
            <input type="email" name="email" id="email"  class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <br>
        <div class="w-full">
            <label for="password" class="mb-3 block text-base font-medium text-blue1">Nouveau mot de passe</label>
            <input type="password" name="password" id="password"  class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" required>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <br>
        <div class="w-full">
            <label for="password_confirmation" class="mb-3 block text-base font-medium text-blue1">Confirmer le nouveau mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation"  class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" required>
        </div>
        <br>
        <button type="submit" class="mt-4 hover:shadow-md rounded-md bg-blue2 py-3 px-8 text-center text-base font-semibold text-white outline-none">Réinitialiser le mot de passe</button>
    </form>
</div>
@endsection
