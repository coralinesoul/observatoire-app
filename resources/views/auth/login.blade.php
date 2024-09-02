@extends("base")

@section("content")
    <div class="flex justify-center h-dvh p-10">
        <form class="w-1/2 flex flex-col items-center" action="{{ route('auth.login') }}" method="post">
            @csrf
            <div class="w-full">
                <label class="mb-3 block text-base font-medium text-blue1" for="email">Email</label>
                <input type="text" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <br>
            <div class="w-full">
                <label class="mb-3 block text-base font-medium text-blue1" for="password">Mot de passe</label>
                <input type="password" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" id="password" name="password">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <br>
            <button class="mt-4 hover:shadow-md rounded-md bg-blue2 py-3 px-8 text-center text-base font-semibold text-white outline-none">Se connecter</button>
        </form>
    </div>
@endsection
