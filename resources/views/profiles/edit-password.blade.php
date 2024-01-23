<x-app-layout>
    <x-navbar />
    <hr>
    <x-status />

    <div class="h-auto w-11/12 mx-auto bg-white border rounded-sm mt-12">
        <div class="flex h-full bg-white">
            <div class="hidden lg:flex flex-col w-64 bg-white text-black border">
                <x-sidebar />
            </div>
            <div class="flex-1 mx-auto mt-6">
                <form action="{{ route('profiles.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="font-bold text-lg ml-48 mt-3" for="Old Password">Current Password</label>
                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                        <input class="w-full border border-black px-4 py-2 rounded-lg outline-none" type="password"
                            name="current_password" id="current_password"
                            placeholder="Current Password{{ $user->password_changed_at ? ' (Last updated ' . $user->password_changed_at . ')' : '' }}">
                        @if ($errors->has('current_password'))
                        <span class="text-red-600 text-sm" role="alert">
                            <strong>{{ $errors->first('current_password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label class="font-bold text-lg ml-48 mt-3" for="New Password">New Password</label>
                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                        <input class="w-full border border-black px-4 py-2 rounded-lg outline-none" type="password"
                            name="password" id="password" placeholder="New Password">
                        @if ($errors->has('password'))
                        <span class="text-red-600 text-sm" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label class="font-bold text-lg ml-48 mt-3" for="Confirm Password">Confirm Password</label>
                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                        <input class="w-full border border-black px-4 py-2 rounded-lg outline-none" type="password"
                            name="confirm_password" id="confirm_password" placeholder="Confirm New Password">
                        @if ($errors->has('confirm_password'))
                        <span class="text-red-600 text-sm" role="alert">
                            <strong>{{ $errors->first('confirm_password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="w-8/12 mx-auto h-auto px-4 py-3 bg-white rounded-xl">
                        <button type="submit" id="change-password" onclick="event.preventDefault();"
                            class="bg-blue-500 rounded-lg px-2 py-2 text-white font-semibold text-sm">Change
                            Password</button>
                    </div>

                    <div id="mainModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog"
                        aria-modal="true">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
                            
                        </div>

                        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                            <div
                                class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
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
                                            <h3 class="text-base font-semibold leading-6 text-gray-900"
                                                id="modal-title">
                                                Change Password</h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">You'll be logged out of all sessions
                                                    except
                                                    this one to protect your account if anyone is trying to gain access.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">

                                        <button type="button" onclick="this.form.submit();"
                                            class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">Change
                                            Password
                                        </button>
                                        <button type="button" id="cancel"
                                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const changePassword = document.getElementById('change-password');
        const cancel = document.getElementById('cancel');
        const mainModal = document.getElementById('mainModal');

        changePassword.addEventListener('click', function () {
            mainModal.classList.remove('hidden');
        });

        cancel.addEventListener('click', function () {
            mainModal.classList.add('hidden');
        });
    </script>
</x-app-layout>