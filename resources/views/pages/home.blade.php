@extends('layouts.app')

@section('title', 'Shabd • Discover')
@section('meta_description', 'Explore the latest stories, poems, and thoughts from the Shabd community. Discover new voices and shared wisdom on our minimalist platform.')
@section('meta_keywords', 'discover, stories, blog feed, write, Shabd, Saral Singh, community writing')

@push('styles')
<style>
/* Page Header styles */
.page-header {
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-line);
}

.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--ink-primary);
    line-height: 1;
}

.search-wrapper {
    position: relative;
    max-width: 300px;
    width: 100%;
}

@media (max-width: 600px) {
    .page-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
    .search-wrapper { max-width: 100%; }
}
</style>
@endpush

@section('content')
<main class="feed-container">
    <header class="page-header">
        <h1 class="page-title">Discover</h1>
        
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input" 
                   placeholder="Search stories or @authors..." onkeyup="handleSearchInput()">
        </div>
    </header>

    <div id="body">
    </div>

<div id="noUserFound" style="display: none; text-align: center; padding: 3rem; color: var(--ink-secondary);">
    <h4>No author found with that pen name.</h4>
</div>
<div id="noResults" style="display: none; text-align: center; padding: 3rem; color: var(--ink-secondary);">
    <h4>No stories match your search.</h4>
</div>

@include('components.toast')
@include('partials.auth-token')
</main>
@endsection

@push('scripts')
<script>
    // --- Feed Logic ---
    const url = "{{ config('app.url') }}";
    let latestPostId = 0;
    let allPosts = [];
    let currentPage = 1;
    let lastPage = 1;
    let isLoading = false;
    let debounceTimer;

    // --- Render fresh posts (used for first load & search) ---
    function renderPosts(posts) {
        const container = document.getElementById('body');
        container.innerHTML = '';
        appendPosts(posts);
    }

    // --- Append posts (used for infinite scroll) ---
    function appendPosts(posts) {
        const container = document.getElementById('body');

        posts.forEach(post => {
            const shortDesc = (post.description || '').substring(0, 120) + '...';
            const postDate = new Date(post.created_at).toLocaleDateString('en-US', {
                year: 'numeric', month: 'short', day: 'numeric'
            });

            let imageUrl = (post.picture && post.picture.trim() !== "" && post.picture !== "null")
                ? `/storage/${post.picture}`
                : `/images/post-placeholder.jpg`;

            container.innerHTML += `
            <article class="article-card" onclick="window.location.href='/post/${post.id}'">
                <div class="article-image-wrapper">
                    <img src="${imageUrl}" alt="${post.title}" class="article-image">
                </div>
                <div class="article-content">
                    <div>
                        <div class="article-meta">
                            <span>@${post.user.username}</span> | <span>${postDate}</span>
                        </div>
                        <h3 class="article-title">${post.title}</h3>
                        <p class="article-excerpt">${shortDesc}</p>
                    </div>
                    <div class="article-footer">
                        <span style="font-weight:600; color:var(--ink-primary)">${post.user.name}</span>
                        <div class="stats-group">
                            <span><i class="fas fa-heart" style="color:#e11d48"></i> ${post.likes}</span>
                        </div>
                    </div>
                </div>
            </article>`;
        });
    }

    // --- Fetch first page ---
    function fetchInitialPosts() {
        currentPage = 1;

        fetch(`${url}/api/public/posts?page=1`)
            .then(res => res.json())
            .then(data => {
                const paginator = data.data;
                lastPage = paginator.last_page;
                allPosts = paginator.data;

                if (allPosts.length) {
                    latestPostId = allPosts[0].id;
                }

                renderPosts(allPosts);
            });
    }

    // --- Load next page on scroll ---
    function loadNextPage() {
        if (isLoading) return;
        if (currentPage >= lastPage) return;

        isLoading = true;
        currentPage++;

        fetch(`${url}/api/public/posts?page=${currentPage}`)
            .then(res => res.json())
            .then(data => {
                const posts = data.data.data;
                appendPosts(posts);
                isLoading = false;
            });
    }

    // --- Infinite Scroll Trigger (App Shell compatible) ---
    const scroller = document.querySelector('.scrollable-content') || window;
    scroller.addEventListener('scroll', () => {
        const scrollTop = scroller.scrollTop !== undefined ? scroller.scrollTop : window.scrollY;
        const clientHeight = scroller.clientHeight !== undefined ? scroller.clientHeight : window.innerHeight;
        const scrollHeight = scroller.scrollHeight !== undefined ? scroller.scrollHeight : document.body.offsetHeight;
        
        if (clientHeight + scrollTop >= scrollHeight - 200) {
            loadNextPage();
        }
    });

    // --- Check for new posts (polling) ---
    function checkForNewPost() {
        fetch(`${url}/api/public/posts/latest-id`)
            .then(res => res.json())
            .then(data => {
                if (data.latest_id > latestPostId) {
                    latestPostId = data.latest_id;
                    fetchInitialPosts();
                }
            });
    }

    // --- Search ---
    function handleSearchInput() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const query = document.getElementById('searchInput').value.toLowerCase().trim();
            const filtered = allPosts.filter(post =>
                post.title.toLowerCase().includes(query) ||
                post.user.name.toLowerCase().includes(query)
            );
            renderPosts(filtered);
        }, 300);
    }

    // --- Init ---
    fetchInitialPosts();
    setInterval(checkForNewPost, 60000);
</script>
@endpush