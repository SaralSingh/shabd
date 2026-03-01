<aside class="sidebar" id="sidebar">
    <button onclick="toggleSidebar()" style="background:none; border:none; align-self:flex-end; font-size:1.2rem; cursor:pointer; color:var(--ink-secondary);">&times;</button>
    <div style="font-family:'Playfair Display'; font-weight:700; font-size:1.5rem; margin-bottom:1rem; color:var(--ink-primary);">Shabd.</div>
    
    <a href="{{ route('home.page') }}" class="{{ request()->is('posts') || request()->is('/') ? 'active-link' : '' }}">
        <i class="fas fa-home"></i> Discover
    </a>
    
    <a href="{{ route('notifications.page') }}" class="{{ request()->is('user/account/notifications') ? 'active-link' : '' }}">
        <i class="fas fa-bell"></i> Notifications 
        @if(Auth::user()->unreadNotifications->count() > 0) 
            <span class="nav-badge" style="margin-left:auto;">{{ Auth::user()->unreadNotifications->count() }}</span> 
        @endif
    </a>
    
    <a href="{{ route('post.add.page') }}" class="{{ request()->is('user/account/create/post') ? 'active-link' : '' }}">
        <i class="fas fa-plus-circle"></i> Create Post
    </a>
    <a href="{{ route('dashboard.page') }}" class="{{ request()->is('user/account/posts') ? 'active-link' : '' }}">
        <i class="fas fa-file-alt"></i> My Posts
    </a>
    <a href="{{ route('profile.page') }}" class="{{ request()->is('user/account/profile') ? 'active-link' : '' }}">
        <i class="fas fa-user"></i> Profile
    </a>
    
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:var(--accent-color);">
        <i class="fas fa-sign-out-alt"></i> Sign Out
    </a>
</aside>
