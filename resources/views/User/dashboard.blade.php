@extends('layouts.app')

@section('title', 'My Archive — Shabd')

@push('styles')
<style>
/* --- Dashboard Layout --- */
.dashboard-container {
    max-width: 900px;
    margin: 3rem auto;
    padding: 0 20px;
    min-height: 60vh;
}

.dashboard-header {
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-line);
}

.dashboard-title {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--ink-primary);
    line-height: 1;
}

/* Search Bar overrides */
.search-wrapper {
    position: relative;
    max-width: 300px;
    width: 100%;
}

/* Post List */
.post-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.post-card {
    background: var(--card-bg);
    border: 1px solid var(--border-line);
    border-radius: var(--radius-sharp);
    padding: 1.5rem;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}

.post-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    border-color: var(--ink-primary);
}

.post-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
}

.post-title-link {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--ink-primary);
    text-decoration: none;
    line-height: 1.2;
}
.post-title-link:hover { text-decoration: underline; }

.post-date {
    font-size: 0.8rem;
    color: var(--ink-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.post-excerpt {
    font-size: 0.95rem;
    color: var(--ink-secondary);
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.post-footer {
    border-top: 1px dashed var(--border-line);
    padding-top: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stats-group {
    display: flex;
    gap: 15px;
    font-size: 0.85rem;
    color: var(--ink-secondary);
}
.stats-group i { margin-right: 5px; opacity: 0.7; }

.action-group {
    display: flex;
    gap: 10px;
}

.btn-icon {
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-view { color: var(--ink-primary); background: rgba(0,0,0,0.05); }
.btn-view:hover { background: rgba(0,0,0,0.1); }

.btn-edit { color: #059669; background: rgba(16, 185, 129, 0.1); }
.btn-edit:hover { background: rgba(16, 185, 129, 0.2); }

.btn-delete { color: #e11d48; background: rgba(225, 29, 72, 0.1); border: none; cursor: pointer; }
.btn-delete:hover { background: rgba(225, 29, 72, 0.2); }

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--ink-secondary);
}
.empty-state img { width: 100px; opacity: 0.5; margin-bottom: 1rem; filter: grayscale(1); }

@media (max-width: 600px) {
    .dashboard-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
    .search-wrapper { max-width: 100%; }
    .post-footer { flex-direction: column; align-items: flex-start; gap: 1rem; }
    .action-group { width: 100%; justify-content: flex-end; }
}
</style>
@endpush

@section('content')
<main class="dashboard-container">
    
    <header class="dashboard-header">
        <h1 class="dashboard-title">My Archive</h1>
        
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input" 
                   placeholder="Filter by title..." onkeyup="filterPosts()">
        </div>
    </header>

    <div id="postContainer" class="post-list">
        @foreach ($posts as $post)
            <article class="post-card" data-title="{{ strtolower($post->title) }}">
                
                <div class="post-header">
                    <a href="{{ route('post.page', ['id' => $post->id]) }}" class="post-title-link">
                        {{ $post->title }}
                    </a>
                    <span class="post-date">{{ $post->created_at->format('M j') }}</span>
                </div>

                <p class="post-excerpt">
                    {{ Str::limit($post->description, 140, '...') }}
                </p>

                <div class="post-footer">
                    <div class="stats-group">
                        <span title="Likes"><i class="fas fa-thumbs-up"></i> {{ $post->likes }}</span>
                        <span title="Comments"><i class="far fa-comment"></i> {{ $post->comments }}</span>
                    </div>

                    <div class="action-group">
                        <a href="{{ route('user.post.view', $post->id) }}" class="btn-icon btn-view">View</a>
                        <a href="{{ route('post.edit.page', $post->id) }}" class="btn-icon btn-edit">Edit</a>
                        
                        <form action="{{ route('post.delete', $post->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this story? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-delete">Delete</button>
                        </form>
                    </div>
                </div>

            </article>
        @endforeach
    </div>

    <div id="notFound" class="empty-state" style="display: none;">
        <i class="fas fa-search" style="font-size: 2rem; opacity: 0.3; margin-bottom: 1rem;"></i>
        <p>No stories found matching your search.</p>
    </div>

</main>
@endsection

@push('scripts')
<script>
    // Filter Logic
    function filterPosts() {
        const input = document.getElementById('searchInput').value.trim().toLowerCase();
        const posts = document.querySelectorAll('.post-card');
        let found = false;

        posts.forEach(post => {
            const title = post.dataset.title;
            if (title.includes(input)) {
                post.style.display = "block";
                found = true;
            } else {
                post.style.display = "none";
            }
        });

        const emptyState = document.getElementById('notFound');
        if (!found && input !== '') {
            emptyState.style.display = 'block';
        } else {
            emptyState.style.display = 'none';
        }
    }
</script>
@endpush