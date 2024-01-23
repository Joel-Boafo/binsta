<nav class="flex-1">
    <a href="{{ route('profiles.edit') }}" class="{{ Route::currentRouteNamed('profiles.edit') ? 'font-bold' : '' }} block ml-6 mt-2 text-black text-lg">Edit Profile</a>
    <a href="{{ route('profiles.edit-password') }}" class="{{ Route::currentRouteNamed('profiles.edit-password') ? 'font-bold' : '' }} block ml-6 mt-2 text-black text-lg">Change Password</a>
</nav>