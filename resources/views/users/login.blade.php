<x-app-layout>
    <x-status></x-status>
    <div class="text-center font-sans">
        <div class="inline-block border-2 border-slate-300 w-[51%] mt-12">
            <x-binsta-logo />
            <form method="POST" action="{{ route('users.login.post') }}">
                @csrf
                <div>
                    <input class="my-2 w-[70%] p-3 rounded-sm border-2 border-slate-300 bg-gray-50" type="text"
                        name="username" id="username" placeholder="Username">
                </div>
                <div>
                    <input class="mb-2 w-[70%] p-3 rounded-sm border-2 border-slate-300 bg-gray-50" type="password"
                        name="password" id="password" placeholder="Password">
                </div>
                <button type="submit"
                    class="bg-sky-400 w-[70%] p-3 mb-4 rounded-sm text-lg text-white font-semibold">Log in</button>
            </form>
        </div>
        <div class="inline-block border-2 border-slate-300 w-[51%] mt-4 h-full p-4">
            Don't have an account yet? <a href="{{ route('users.register') }}" class="text-sky-400">Register</a>
        </div>
    </div>
</x-app-layout>