<div class="bg-gray-200">
    <div class="navbar nav bg-white w-full rounded-sm items-center p-1">
        <header>
            <nav class="flex justify-between items-center w-full">
                <div>
                    <img id="logo" class="h-12 md:h-20" src="{{ asset('Logo-Instagram.png') }}" alt="Binsta logo">
                </div>

                <div class="flex items-center md:hidden">
                    <!-- Hamburger Icon for Mobile -->
                    <button id="mobileMenuButton" class="text-gray-600 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <div id="mobileMenu" class="hidden md:flex items-center mx-auto">
                    <!-- Search Bar with Magnifying Glass Icon -->
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
                    <!-- Home Icon -->
                    <div class="ml-4 md:ml-0">
                        <a href="{{ route('home') }}" class="fas fa-home" style="color: #000000;"></a>
                    </div>

                    <!-- Plus Sign -->
                    <div class="ml-4">
                        <a href="{{ route('posts.create') }}" class="fas fa-plus"></a>
                    </div>

                    <!-- Profile Picture Dropdown -->
                    <!-- Profile Picture Dropdown -->
                    <div class="ml-4 relative">
                        @if (auth()->check())
                        @php
                        $user = auth()->user();
                        @endphp
                        <img id="profileDropdownToggle" class="h-8 w-8 rounded-full"
                            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default.jpg') }}"
                            alt="Binsta logo">
                        @endif


                        <!-- Dropdown Content -->
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 bg-white border rounded-md shadow-md">
                            <ul class="py-2">
                                <li><a href="{{ route('profiles.edit') }}"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a></li>
                                <li><a href="{{ route('users.logout') }}"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
    </div>
</div>

<style>
    /* make the logo bigger on hover */
    .transform.scale-105 {
        transform: scale(1.05);
    }
</style>

<script>
    // search bar
const searchQuery = document.getElementById('searchQuery');
const searchResults = document.getElementById('searchResults');

// make request each time when new input
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
                    // parent div
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
                                    ${user.name}
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

    const logo = document.getElementById('logo');
    // make the logo bigger on hover
    logo.addEventListener('mouseover', function() {
        this.classList.add('transform', 'scale-105');
    });

    logo.addEventListener('mouseout', function() {
        this.classList.remove('transform', 'scale-105');
    });

    // Profile Picture Dropdown
    const profileDropdownToggle = document.getElementById('profileDropdownToggle');
    const profileDropdown = document.getElementById('profileDropdown');

    profileDropdownToggle.addEventListener('click', function() {
        profileDropdown.classList.toggle('hidden');
    });

    // Close the dropdown when clicking outside of it
    window.addEventListener('click', function(event) {
        if (!event.target.matches('#profileDropdownToggle')) {
            if (!event.target.matches('#profileDropdown')) {
                profileDropdown.classList.add('hidden');
            }
        }
    });
</script>