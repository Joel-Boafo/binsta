<x-app-layout>
    <x-navbar />
    <x-status />
    <div class="bg-gray-100 w-full mt-6 px-2 py-2 flex mx-auto rounded-sm">
        <div class="w-1/2">
            <pre
                class="max-h-72 overflow-x-auto overflow-y-auto hide-scrollbar"><code class="language-{{ $post->programming_language }}">{{ $post->code }}</code></pre>
        </div>
        <div class="w-1/2 ml-4">
            <div class="flex items-center">
                <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : asset('default.jpg') }}"
                    alt="avatar" class="w-8 h-8 rounded-full">
                <h1 class="font-semibold text-lg ml-2">{{ $post->user->username }}</h1>
            </div>
            <hr class="my-2">
            <div class="flex items-center">
                <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : asset('default.jpg') }}"
                    alt="avatar" class="w-8 h-8 rounded-full">
                <p class="ml-2">{{ $post->caption }}</p>
            </div>
            <div class="my-2 overflow-x-auto overflow-y-auto overflow-hidden"
                style="max-height: 200px; scrollbar-width: none; -ms-overflow-style: none;">
                @foreach ($comments as $comment)
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center">
                        <a href="{{ route('profiles.show', $comment->user->username) }}">
                            <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : asset('default.jpg') }}"
                                alt="avatar" class="w-8 h-8 rounded-full">
                        </a>
                        <div class="ml-2">
                            <p class="font-semibold inline-block">{{ $comment->user->username }}&nbsp;</p>
                            <p class="inline-block">{{ $comment->comment }}</p>
                            <p class="text-xs text-gray-500">{{
                                \Carbon\Carbon::parse($comment->created_at)->diffForHumans(null, true, false, 1) }}</p>
                        </div>
                    </div>
                    @if (auth()->user()->id === $comment->user_id)
                    <form action="{{ route('posts.comment.delete', $comment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="h-6 w-6 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
                @endforeach
            </div>
            <hr class="my-2">
            <form action="{{ route('posts.like') }}" method="POST" class="flex items-center my-2">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <button><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg></button>
                <p class="font-semibold ml-2">{{ $post->likes->count() }} likes</p>
            </form>
            <p class="text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
            <hr class="my-2">
            <form action="{{ route('posts.comment') }}" method="POST" class="flex items-center">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input class="bg-gray-100 w-full h-full outline-none px-2" type="text" name="comment" id="comment"
                    placeholder="Post a comment...">
                <button id="postButton" type="submit" class="ml-2 text-blue-500 font-semibold" disabled>Post</button>
            </form>
        </div>
    </div>

    <script>
        const comment = document.getElementById('comment');
        const postButton = document.getElementById('postButton');

        comment.addEventListener('input', () => {
            if (comment.value.trim() === '') {
                postButton.disabled = true;
                postButton.style.color = '#B2D0E6';
            } else {
                postButton.disabled = false;
                postButton.style.color = '#0095F6';
            }   
        });


    </script>

    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .overflow-y-auto::-webkit-scrollbar {
            display: none;
        }
    </style>
</x-app-layout>