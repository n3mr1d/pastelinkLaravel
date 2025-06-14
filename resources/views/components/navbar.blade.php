<nav class="navbar" style="background-color:#131d25;">
    <div class="maindown d-flex mx-auto">
        <x-nav-link href="/index.php" :active="request()->is('/')"><i class="mx-2 fa-solid fa-home"></i>Home</x-nav-link>
        <x-nav-link href="/index.php/leaderboard" :active="request()->is('leaderboard')"><i class="mx-2 fa-solid fa-trophy"></i>Leaderboard</x-nav-link>
        
        @if(auth()->check())
            @if(auth()->user()->is_admin == false)
            <x-nav-link href="/index.php/dashboard" :active="request()->is('dashboard')"><i class="mx-2 fa-solid fa-gear"></i>Dashboard</x-nav-link>
                <x-nav-link href="/index.php/logout" :active="request()->is('logout')"><i class="mx-2 fa fa-sign-out" aria-hidden="true"></i> Logout</x-nav-link>
            @else
            <x-nav-link href="/index.php/admin" :active="request()->is('admin')"><i class="mx-2 fa-solid fa-gear"></i>Admin</x-nav-link>
                <x-nav-link href="/index.php/logout" :active="request()->is('logout')"><i class="mx-2 fa fa-sign-out" aria-hidden="true"></i> Logout</x-nav-link>
            @endif
        @else
            <x-nav-link href="/index.php/login" :active="request()->is('login')"><i class="mx-2 fa-solid fa-right-from-bracket"></i>Login</x-nav-link>
            <x-nav-link href="/index.php/register" :active="request()->is('register')"><i class="mx-2 fa-solid fa-user-plus"></i>Register</x-nav-link>
        @endif
    </div>
</nav>