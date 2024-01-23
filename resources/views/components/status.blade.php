@if (session('status'))
<div id="alert" class="fixed top-0 right-0 m-4">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 rounded-md shadow-md">
        <div class="flex items-center">
            <div class="pr-2">
                <svg class="fill-current h-4 w-4 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold">{{ session()->get('status') }}</p>
            </div>
            <button id="closeBtn" class="ml-2 text-gray-600 hover:text-gray-800 focus:outline-none">
                <svg class="h-3 w-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                </svg>
            </button>
        </div>
    </div>
</div>
@endif

@if (session('error'))
<div id="alert" class="fixed top-0 right-0 m-4">
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 rounded-md shadow-md">
        <div class="flex items-center">
            <div class="pr-2">
                <svg class="fill-current h-4 w-4 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold">{{ session()->get('error') }}</p>
            </div>
            <button id="closeBtn" class="ml-2 text-gray-600 hover:text-gray-800 focus:outline-none">
                <svg class="h-3 w-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                </svg>
            </button>
        </div>
    </div>
</div>
@endif

@if ($errors->any())
<div id="alert" class="fixed top-0 right-0 m-4">
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 rounded-md shadow-md">
        <div class="flex items-center">
            <div class="pr-2">
                <svg class="fill-current h-4 w-4 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div>
                <ul class="text-sm font-bold">
                    @if ($errors->any())
                        <li>{{ $errors->first() }}</li>
                    @endif
                </ul>
            </div>
            <button id="closeBtn" class="ml-2 text-gray-600 hover:text-gray-800 focus:outline-none">
                <svg class="h-3 w-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                </svg>
            </button>
        </div>
    </div>
</div>
@endif

<script>
    setTimeout(function() {
        document.getElementById('alert').style.display = 'none';
    }, 3000);

    document.getElementById('closeBtn').addEventListener('click', function() {
        document.getElementById('alert').style.display = 'none';
    });
</script>
