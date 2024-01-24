<x-app-layout>
    <x-status></x-status>
    <div class="text-center font-sans">
        <div class="inline-block border-2 border-slate-300 w-[51%] mt-12">
            <x-binsta-logo />
            <span class="font-semibold">Sign up to see code snippets from your friends!</span>
            <form method="POST" action="{{ route('users.register.post') }}">
                @csrf
                <div>
                    <input class="my-2 w-[70%] p-3 rounded-sm border-2 border-slate-300 bg-gray-50" type="text" name="username" id="username" placeholder="Username" value="{{ old('username') }}">
                </div>
                <div>
                    <input class="mb-2 w-[70%] p-3 rounded-sm border-2 border-slate-300 bg-gray-50" type="email" name="email" id="email" placeholder="Johndoe@example.com" value="{{ old('email') }}">
                </div>
                <div>
                    <input class="mb-2 w-[70%] p-3 rounded-sm border-2 border-slate-300 bg-gray-50" type="password" name="password" id="password" placeholder="Password">
                </div>
                <div>
                    <input class="mb-2 w-[70%] p-3 rounded-sm border-2 border-slate-300 bg-gray-50" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                </div>
                <button type="submit" class="bg-sky-400 w-[70%] p-3 mb-4 rounded-sm text-lg text-white font-semibold">Sign up</button>
                <br>
            </form>
        </div>
        <div class="inline-block border-2 border-slate-300 w-[51%] mt-4 h-full p-4">
            Already have an account? <a href="{{ route('users.login') }}" class="text-sky-400">Log in</a>
        </div>
    </div>
</x-app-layout>