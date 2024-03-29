<div class="bg-gray-200">
    <div class="navbar nav bg-white w-full rounded-sm items-center p-2">
        <header>
            <nav class="flex justify-between items-center w-full">
                <div>
                    <a href="{{ route('home') }}">
                        <x-binsta-logo />
                    </a>
                </div>

                <div class="flex items-center md:hidden">
                    <button id="mobileMenuButton" class="text-gray-600 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <div id="mobileMenu" class="hidden md:flex items-center mx-auto">
                    <form action="{{ route('profiles.search') }}" method="GET">
                        <div class="relative">
                            <i
                                class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="query" id="searchQuery" placeholder="Search"
                                class="bg-gray-200 border rounded-xl pl-10 pr-4 py-2 outline-none">
                        </div>
                    </form>

                    <div id="searchResults" @if (auth()->check())
                        @php
                        $user = auth()->user();
                        @endphp
                        class="absolute top-16 bg-white border rounded-xl w-80 mx-auto py-2 px-4 z-50 flex-col hidden">
                        @endif
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="ml-4 md:ml-0">
                        <a href="{{ route('home') }}" class="fas fa-home" style="color: #000000;"></a>
                    </div>

                    <div class="ml-4">
                        <a href="{{ route('posts.create') }}" class="fas fa-plus"></a>
                    </div>

                    <div class="ml-4 relative">
                        @if (auth()->check())
                        @php
                        $user = auth()->user();
                        @endphp
                        <img id="profileDropdownToggle" class="h-8 w-8 rounded-full"
                            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default.jpg') }}"
                            alt="Binsta logo">
                        @endif

                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 bg-white border rounded-md shadow-md">
                            <ul class="py-2">
                                <li>
                                    <a href="{{ route('profiles.edit') }}"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
                                </li>
                                <li>
                                    <a href="{{ route('users.logout') }}"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
    </div>
</div>

<script>
    const searchQuery = document.getElementById('searchQuery');
    const searchResults = document.getElementById('searchResults');

    searchQuery.addEventListener('input', function() {
        const query = this.value;

        if (query.trim() === '') {
            searchResults.classList.add('hidden');
            return;
        }

        const url = `/profiles/search?query=${query}`;
        fetch(url)
            .then(response => response.text())
            .then(data => {
                const users = JSON.parse(data);

                if (users.length > 0) {
                    searchResults.classList.remove('hidden');
                    searchResults.innerHTML = '';

                    users.forEach(user => {
                        const userElement = document.createElement('div');
                        userElement.classList.add('flex', 'items-center', 'border-b', 'border-gray-200', 'py-2');
                        userElement.innerHTML = `
                            <a href="/profile/${user.username}" class="flex">
                                <div>
                                    <img class="h-12 w-12 rounded-full ml-2" src="${user.avatar ? `/storage/${user.avatar}` : '/default.jpg'}" alt="Profile Picture">
                                </div>
                                <div class="px-4">
                                    <div class="font-semibold text-gray-800 hover:bg-gray-200">
                                        ${user.username}
                                    </div>
                                    <div class="text-gray-500 text-sm text-gray-800 hover:bg-gray-200">
                                        ${user.name ? user.name : ''}
                                    </div>
                                </div>
                            </a>
                        `;
                        searchResults.appendChild(userElement);
                    });
                } else {
                    searchResults.classList.add('hidden');
                }
            });
    });

    if (searchQuery.value.length > 0) {
        const searchResults = document.getElementById('searchResults');
        searchResults.classList.remove('hidden');
    }

    const profileDropdownToggle = document.getElementById('profileDropdownToggle');
    const profileDropdown = document.getElementById('profileDropdown');

    profileDropdownToggle.addEventListener('click', function() {
        profileDropdown.classList.toggle('hidden');
    });

    window.addEventListener('click', function(event) {
        if (!event.target.matches('#profileDropdownToggle')) {
            if (!profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        }
    });
</script>