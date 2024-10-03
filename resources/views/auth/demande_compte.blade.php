@extends("base")

@section("content")

    <div class="rounded-none bg-blue2 bg-opacity-5 shadow-md p-6">
        <p class="text-blue1">Avoir un compte sur ce site permet de répertorier sa propre étude mais le catalogue est mis en ligne intégralement sans authentification. Il est donc inutile de demander un compte si vous n'avez pas l'intention de completer le catalogue avec les connaissances que vous avez produites. Merci d'avance pour votre collaboration, vous pouvez utiliser le formulaire de contact pour plus d'information.</p> 
    </div>

    <div class="flex justify-center h-dvh p-10">
        <form class="w-1/2 flex flex-col items-center" action="{{ route('auth.demande.submit') }}" method="post">
            @csrf
            <h2 class="text-xl tracking-wide text-blue2 font-bold mt-1"> Formulaire de demande de compte :</h1>
            <div class="w-full">
                <label class="my-3 block text-base font-medium text-blue1" for="name">Nom</label>
                <input type="text" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" name="name" value="{{ old('name') }}">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label class="my-3 block text-base font-medium text-blue1" for="email">Email</label>
                <input type="text" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" name="email" value="{{ old('email') }}">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full">
                <label class="my-3 block text-base font-medium text-blue1" for="password">Mot de passe</label>
                <input type="password" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" name="password">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <br>
            <div class="w-full">
                <label class="mb-3 block text-base font-medium text-blue1" for="structure">Structure</label>
                <input type="text" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" name="structure" value="{{ old('structure') }}">
            </div>
            <br>

            <div class="w-full">
                <label class="mb-3 block text-base font-medium text-blue1" for="resume">Pourquoi souhaitez-vous créer un compte et pouvez-vous brièvement décrire le contenu de vos études ?</label>
                <textarea rows="5" class="w-full h-48 flex-grow rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base text-[#6B7280] outline-none focus:border-blue1 focus:shadow-md" name="resume">{{ old('resume') }}</textarea>
            </div>
            

            <br>
            <button class="mt-4 hover:shadow-md rounded-md bg-blue2 py-3 px-8 text-center text-base font-semibold text-white outline-none">Transmettre ma demande</button>
        </form>
    </div>
@endsection

