<x-app-layout>
    <x-navbar />
    <x-status />
    <div class="bg-gray-100 h-auto w-8/12 mx-auto py-2 px-2 rounded-md mt-6">
        <div class="flex mt-6 ml-24">
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default.jpg') }}" alt="avatar"
                class="w-48 h-48 rounded-full">
            <div class="ml-12">
                <div class="flex items-center">
                    <h1 class="font-semibold text-lg">{{ $user->username }}</h1>
                    <div class="ml-6">
                        @if (auth()->user() && auth()->user()->id == $user->id)
                        <button class="rounded-lg bg-blue-500 text-sm text-white font-semibold px-2 py-1.5">
                            <a href="{{ route('profiles.edit') }}">Edit profile</a>
                        </button>
                        @endif
                    </div>
                </div>
                <p class="mt-2">{{ $user->posts->count() }} posts</p>
                <p class="mt-2">{{ $user->name }}</p>
                <p class="mt-2 text-gray-300">{{ $user->gender }}</p>
                <p class="mt-2">{{ $user->bio }}</p>
            </div>
        </div>
        <div class="mt-6 grid grid-cols-3 gap-4">
            @foreach ($user->posts as $post)
                <a href="{{ route('posts.show', $post->id) }}">
                    <div class="h-36 overflow-hidden flex flex-col justify-between">
                        <pre class="hide-scrollbar"><code class="language-{{ $post->programming_language }}">{{ $post->code }}</code></pre>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>