<x-app-layout>
    <div class="bg-gray-200 h-full min-h-screen">
        <x-navbar />
        <x-status />

        @foreach ($posts as $post)
        <div class="w-full mx-auto h-auto bg-gray-100 mt-6 rounded-md px-2.5 py-3 sm:w-8/12">
            <div class="ml-6 px-2 py-2 flex">
                <a href="{{ route('profiles.show', $post->user->username) }}" class="flex">
                    <img id="profileDropdownToggle" class="h-8 w-8 rounded-full"
                        src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : asset('default.jpg') }}"
                        alt="Binsta logo">
                    <h3 class="ml-4 mt-1 font-semibold">{{ $post->user->username }}</h3>
                </a>
                <p class="ml-1 mt-1 text-gray-500"> • {{ strtoupper($post->created_at->diffForHumans()) }}</p>

                @if(auth()->user() && auth()->user()->id == $post->user_id)
                <div class="flex ml-auto space-x-2">
                    <form method="POST" action="{{ route('posts.edit') }}">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6">
                                <path
                                    d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                            </svg>
                        </button>
                    </form>

                    <form class="" action="{{ route('posts.delete', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button class=""><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg></button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Display the code with Prism.js highlighting -->
            <pre
                class="max-h-48 overflow-x-auto overflow-y-auto hide-scrollbar"><code class="language-{{ $post->programming_language }}">{{ $post->code }}</code></pre>

            <div class="flex justify-between">
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <div class="flex">
                        <input type="hidden" name="post_id" id="" value="{{ $post->id }}">
                        <button id="likeButton" class="outline-none"><svg id="likeSVG"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 ml-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg></button>
                        <p class="font-semibold ml-3">{{ $post->likes->count() }} {{ $post->likes->count() == 1 ? 'like'
                            : 'likes' }}</p>
                    </div>
                </form>
            </div>

            <div class="flex ml-4 mb-1">
                <p class="font-semibold">{{ $post->user->username }}&nbsp;</p>
                <p> {{ $post->caption }}</p>
            </div>

            <div>
                <button class="outline-none text-blue-500 ml-4 font-semibold"><a
                        href="{{ route('posts.show', $post->id) }}">View all {{ $post->comments->count() }}
                        comments</a></button>
            </div>

            @if($post->comments->count() > 0)
            <div class="flex flex-col ml-4 mt-2 overflow-x-auto overflow-y-auto overflow-hidden"
                style="max-height: 200px; scrollbar-width: none; -ms-overflow-style: none;">
                @foreach ($post->comments as $comment)
                <div class="flex">
                    <p class="font-semibold">{{ $comment->user->username }}&nbsp;</p>
                    <p>{{ $comment->comment }}</p>
                </div>
                @endforeach
            </div>
            @endif

            <hr class="mt-2">

            <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="flex mt-3">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input class="bg-gray-100 w-full h-full outline-none px-2" type="text" name="comment" id="comment"
                    placeholder="Post a comment...">
                <button type="submit" class="ml-auto text-blue-500 font-semibold">Post</button>
            </form>

            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', (event) => {
                            document.getElementById('likeButton').addEventListener('click', () => {
                                    document.getElementById('likeSVG').setAttribute('stroke', 'red');
                            });
                        });
                // Use Prism.js to highlight the code
                    Prism.highlightAll();

            </script>
            @endpush
        </div>
        @endforeach
    </div>

    <style>
        .overflow-y-auto::-webkit-scrollbar {
            display: none;
        }
    </style>
</x-app-layout>