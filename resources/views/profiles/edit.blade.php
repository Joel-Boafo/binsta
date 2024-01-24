<x-app-layout>
    <x-navbar></x-navbar>
    <hr>
    <x-status></x-status>
    <div class="h-full w-11/12 mx-auto bg-white border rounded-sm mt-12">
        <div class="flex h-full bg-white">
            <div class="hidden lg:flex flex-col w-64 bg-white text-black border">
                <x-sidebar />
            </div>
            <div class="flex-1 mx-auto mt-6">
                <h3 class="text-lg font-bold ml-44">Edit Profile</h3>
                <form action="{{ route('profiles.update-profile-picture') }}" method="POST"
                    enctype="multipart/form-data" id="form">
                    @csrf
                    <div class="w-8/12 mx-auto px-4 py-3 mt-6 bg-gray-100 rounded-xl flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="h-12 w-12 rounded-full"
                                src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default.jpg') }}"
                                alt="avatar">
                            <h3 class="font-bold text-sm ml-3">{{ $user->username }}</h3>
                        </div>
                        <label for="upload">
                            <span class="bg-blue-500 rounded-lg px-1.5 py-2 text-white font-semibold text-sm" aria-hidden="true">Change
                                Profile Picture</span>
                            <input type="file" name="avatar" id="upload" style="display:none">
                      </label>
                    </div>
                </form>

                <form class="mt-8" action="{{ route('profiles.lorenz')  }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label class="font-bold text-lg ml-48 mt-3" for="Name">Name</label>
                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                        <input class="w-full border border-black px-4 py-2 rounded-lg outline-none" type="text"
                            name="name" id="name" value="{{ $user->name }}">
                    </div>
                    <br>

                    <label class="font-bold text-lg ml-48 mt-3" for="Username">Username</label>
                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                        <input class="w-full border border-black px-4 py-2 rounded-lg outline-none" type="text"
                            name="username" id="username" value="{{ $user->username }}">
                    </div>
                    <br>

                    <label class="font-bold text-lg ml-48 mt-3" for="Bio">Bio</label>
                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                        <input class="w-full border border-black px-4 py-4 rounded-lg outline-none" type="text"
                            name="bio" id="bio" value="{{ $user->bio }}" max="150">
                    </div>
                    <br>

                    <label class="font-bold text-lg ml-48 mt-3" for="Email">Email</label>
                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                        <input class="w-full border border-black px-4 py-2 rounded-lg outline-none" type="email"
                            name="email" id="email" value="{{ $user->email }}">
                    </div>
                    <br>

                    <label class="font-bold text-lg ml-48 mt-3" for="gender">Gender</label>
                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl relative">
                        <div id="customDropdown" class="relative">
                            <div id="selectedOption"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight cursor-pointer">
                                @if ($user->gender)
                                {{ $user->gender }}
                                @else
                                Male
                                @endif
                            </div>
                            <div id="options" class="absolute hidden z-10 mt-2 bg-white border rounded-md shadow-lg">
                                <div class="py-2">
                                    <div onclick="selectOption('Female')"
                                        class="cursor-pointer px-4 py-2 hover:bg-gray-100">Female</div>
                                    <div onclick="selectOption('Male')"
                                        class="cursor-pointer px-4 py-2 hover:bg-gray-100">Male</div>
                                    <div onclick="selectOption('Prefer not to say')"
                                        class="cursor-pointer px-4 py-2 hover:bg-gray-100">Prefer not to say</div>
                                    <div onclick="selectOption('Custom')"
                                        class="cursor-pointer px-4 py-2 hover:bg-gray-100" id="genderValue">Custom<div
                                            id="customInput" class="mt-3 hidden">
                                            <label for="customGender"
                                                class="block text-sm font-medium text-gray-700">Custom
                                                Gender</label>
                                            <input type="text" id="customGender" name="customGender"
                                                class="mt-1 p-2 border rounded-md w-full outline-none"
                                                placeholder="Enter custom gender" id="customGenderValue">
                                            <input type="hidden" id="selectedGender" name="selectedGender">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                        <button type="submit"
                            class="bg-blue-500 rounded-lg px-1.5 py-2 text-white font-semibold text-sm">Save
                            Changes</button>
                    </div>
                </form>
                <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                    <button type="submit" id="deactivate-account"
                        class="bg-red-500 rounded-lg px-2 py-2 text-white font-semibold text-sm">Deactivate
                        account</button>
                </div>

                <div id="mainModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog"
                    aria-modal="true">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <div
                                class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                <div class="sm:flex sm:items-start">
                                    <div
                                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                            Deactivate account</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Are you sure you want to deactivate your
                                                account? All of your data will be permanently removed from our servers
                                                forever. This action cannot be undone.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <form action="{{ route('profiles.delete') }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Deactivate</button>
                                    </form>
                                    <button type="button" id="cancel"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const deactivateAccount = document.getElementById('deactivate-account');
        const cancel = document.getElementById('cancel');
        const mainModal = document.getElementById('mainModal');
    
        deactivateAccount.addEventListener('click', function () {
            mainModal.classList.remove('hidden');
        });
    
        cancel.addEventListener('click', function () {
            mainModal.classList.add('hidden');
        });

        document.getElementById("upload").onchange = function() {
            document.getElementById("form").submit();
        };
    
        function selectOption(gender) {
            document.getElementById('selectedOption').innerText = gender;
            document.getElementById('selectedGender').value = gender;
            if (gender === 'Custom') {
                document.getElementById('customInput').style.display = 'block';
            } else {
                document.getElementById('customInput').style.display = 'none';
            }
        }
    
        document.getElementById("customDropdown").addEventListener("click", function () {
            var options = document.getElementById("options");
            options.classList.toggle("hidden");
        });
    
    document.addEventListener("click", function (event) {
        var options = document.getElementById("options");
        if (!event.target.closest("#customDropdown") && !event.target.closest("#options") && !event.target.closest("#customInput")) {
            options.classList.add("hidden");
            }
        });
    
        const customGenderValue = document.getElementById('customGender');
        const genderValue = document.getElementById('selectedOption');
        const selectedGender = document.getElementById('selectedGender');

        customGenderValue.addEventListener('input', function () {
            genderValue.innerText = customGenderValue.value;
            selectedGender.value = customGenderValue.value;
        });
    </script>
</x-app-layout>