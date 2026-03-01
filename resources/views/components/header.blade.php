<nav class="navbar">
    <div class="nav-left">
        @auth
            <button class="menu-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        @endauth
        <a href="{{ route('main.page') }}" class="logo">Shabd.</a>
    </div>

    @yield('header_extra')

    <div class="nav-actions">
        <a href="{{ route('home.page') }}" class="{{ request()->is('posts') || request()->is('/') ? 'active-link' : '' }}">Discover</a>

        @auth
            <a href="{{ route('notifications.page') }}" class="{{ request()->is('user/account/notifications') ? 'active-link' : '' }}" style="display:inline-flex; align-items:center;">
                Notifications
                @if (Auth::user()->unreadNotifications->count() > 0)
                    <span class="nav-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                @endif
            </a>

            <a href="{{ route('post.add.page') }}" class="{{ request()->is('user/account/create/post') ? 'active-link' : '' }}">Write</a>
            <a href="{{ route('dashboard.page') }}" class="{{ request()->is('user/account/posts') ? 'active-link' : '' }}">My Posts</a>
            
            <a href="{{ route('profile.page') }}" style="font-weight:700;" class="{{ request()->is('user/account/profile') ? 'active-link' : '' }}">{{ Auth::user()->username }}</a>
            
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:var(--accent-color);">Sign Out</a>
        @else
            <a href="{{ route('login.page') }}">Sign In</a>
            <a href="{{ route('register.page') }}" style="font-weight:700;">Join</a>
        @endauth
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">@csrf</form>
