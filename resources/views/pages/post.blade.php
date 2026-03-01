@extends('layouts.app')

@section('title', $post->title . ' — Shabd')
@section('meta_description', Str::limit(strip_tags($post->description), 160))
@section('meta_keywords', implode(', ', array_merge(explode(' ', $post->title), ['Shabd', 'Saral Singh', 'writing', 'blog'])))

@push('styles')
<style>
/* --- Article Layout --- */
.article-container {
    max-width: 740px;
    margin: 4rem auto;
    padding: 0 20px;
}

.post-header { margin-bottom: 2.5rem; text-align: center; }

.post-title {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    line-height: 1.1;
    font-weight: 700;
    color: var(--ink-primary);
    margin-bottom: 1.5rem;
}

.author-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    font-size: 0.9rem;
    color: var(--ink-secondary);
}

.author-avatar {
    width: 48px; height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--paper-bg);
    box-shadow: 0 0 0 1px var(--border-line);
}

.author-text { text-align: left; line-height: 1.3; }
.author-name { font-weight: 700; color: var(--ink-primary); text-decoration: none; }
.post-date { font-size: 0.8rem; opacity: 0.8; }

/* Image */
.post-image-wrapper {
    margin: 2rem 0 3rem 0;
    border-radius: var(--radius-sharp);
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}
.post-image-wrapper img {
    width: 100%; height: auto; display: block;
}

/* Body Text */
.post-body {
    font-family: 'Playfair Display', serif; /* Serif for reading */
    font-size: 1.25rem;
    line-height: 1.8;
    color: rgba(0,0,0,0.85);
    margin-bottom: 4rem;
    white-space: pre-line;
}

/* Engagement Bar */
.engagement-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    padding: 1.5rem 0;
    border-top: 1px solid var(--border-line);
    border-bottom: 1px solid var(--border-line);
    margin-bottom: 4rem;
}

.reaction-btn {
    background: transparent;
    border: 1px solid var(--border-line);
    padding: 8px 16px;
    border-radius: 30px;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    color: var(--ink-secondary);
    transition: all 0.2s;
    display: flex; align-items: center; gap: 8px;
}

.reaction-btn:hover { border-color: var(--ink-primary); color: var(--ink-primary); }

.reaction-btn.active-like { background: var(--ink-primary); color: white; border-color: var(--ink-primary); }
.reaction-btn.active-dislike { background: #e11d48; color: white; border-color: #e11d48; }

/* Comments */
.comments-section h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
}

/* Comment Input */
.comment-input-area { margin-bottom: 3rem; }
.comment-input-wrapper { position: relative; }

textarea {
    width: 100%;
    padding: 1rem;
    border: 1px solid var(--border-line);
    background: var(--card-bg);
    border-radius: var(--radius-sharp);
    font-family: 'DM Sans', sans-serif;
    font-size: 1rem;
    resize: vertical;
    min-height: 100px;
}
textarea:focus { outline: none; border-color: var(--ink-primary); }

.action-btn {
    background: var(--ink-primary);
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 0.9rem;
    cursor: pointer;
    border-radius: var(--radius-sharp);
}
.action-btn.outline { background: transparent; color: var(--ink-secondary); }
.action-btn.outline:hover { color: var(--ink-primary); text-decoration: underline; }

/* Comment List styling (cleaner) */
.comment-card {
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--border-line);
}
.comment-card.reply {
    margin-left: 40px;
    padding-left: 20px;
    border-left: 2px solid var(--border-line);
    border-bottom: none;
}
.comment-header { display: flex; gap: 12px; margin-bottom: 8px; align-items: flex-start; }
.comment-author { font-weight: 700; font-size: 0.95rem; color: var(--ink-primary); }
.comment-date { font-size: 0.8rem; color: var(--ink-secondary); margin-left: auto; }
.comment-body { font-size: 1rem; color: var(--ink-primary); line-height: 1.5; margin-left: 48px; margin-bottom: 10px; }
.comment-actions { margin-left: 48px; font-size: 0.85rem; }
.comment-actions button { background: none; border: none; color: var(--ink-secondary); cursor: pointer; margin-right: 15px; font-weight: 500; }
.comment-actions button:hover { color: var(--accent-color); }

/* Responsive */
@media (max-width: 768px) {
    .post-title { font-size: 2rem; }
    .article-container { margin-top: 2rem; }
    .comment-card.reply { margin-left: 15px; }
}
</style>
@endpush

@section('content')
@php $auth = Auth::check(); @endphp

<article class="article-container">
    
    <header class="post-header">
        <h1 class="post-title">{{ $post->title }}</h1>
        
        <div class="author-meta">
            <a href="{{ route('user.page', ['id' => $post->user->id]) }}">
                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="Avatar" class="author-avatar">
            </a>
            <div class="author-text">
                <a href="{{ route('user.page', ['id' => $post->user->id]) }}" class="author-name">{{ $post->user->name }}</a>
                <div class="post-date">{{ $post->created_at->format('M j, Y') }} • <span>@</span>{{ $post->user->username }}</div>
            </div>
        </div>
    </header>

    @if ($post->picture)
    <figure class="post-image-wrapper">
        <img src="{{ asset('storage/' . $post->picture) }}" alt="Article Image">
    </figure>
    @endif

    <div class="post-body">
        {{ $post->description }}
    </div>

    <div class="engagement-bar">
        <button id="like-btn-{{ $post->id }}" class="reaction-btn" onclick="handleReact({{ $post->id }}, 1)">
            <i class="fas fa-thumbs-up"></i> <span id="likes-{{ $post->id }}">0</span>
        </button>
        <button id="dislike-btn-{{ $post->id }}" class="reaction-btn" onclick="handleReact({{ $post->id }}, 0)">
            <i class="fas fa-thumbs-down"></i> <span id="dislikes-{{ $post->id }}">0</span>
        </button>
        <button class="reaction-btn" onclick="sharePost('{{ url("/post/{$post->id}") }}')">
            <i class="fas fa-share"></i> Share
        </button>
    </div>

    <section class="comments-section" id="comment-section">
        <h3>Discussion (<span id="comment-count-{{ $post->id }}">0</span>)</h3>

        <div class="comment-input-area">
            @if ($auth)
                <div class="comment-input-wrapper">
                    <textarea id="commentInput" placeholder="Write a thoughtful comment..." maxlength="500"></textarea>
                    <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                        <span id="comment-char-count" style="font-size: 0.8rem; color: var(--ink-secondary);">0/500</span>
                        <div id="comment-input-buttons" style="display: none; gap: 10px;">
                            <button class="action-btn outline" onclick="cancelComment()">Cancel</button>
                            <button class="action-btn" onclick="handleCommentSubmit({{ $post->id }})">Publish</button>
                        </div>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 2rem; background: var(--card-bg); border: 1px solid var(--border-line); border-radius: 4px;">
                    <p style="margin-bottom: 1rem;">Join the conversation.</p>
                    <a href="{{ route('login.page') }}" class="action-btn" style="text-decoration: none;">Sign in to Comment</a>
                </div>
            @endif
        </div>

        <div id="loading-comments" style="text-align: center; display: none;">Loading...</div>
        <div id="comments-list-{{ $post->id }}"></div>
    </section>

</article>

@include('partials.auth-token')
@endsection

@push('scripts')
<script>
    const url = "{{ config('app.url') }}";
    const token = localStorage.getItem('token');
    const isLoggedIn = @json($auth);

    document.addEventListener('DOMContentLoaded', () => {
        const commentInput = document.getElementById('commentInput');
        const commentButtons = document.getElementById('comment-input-buttons');
        const charCount = document.getElementById('comment-char-count');

        if (commentInput) {
            commentInput.addEventListener('input', () => {
                const count = commentInput.value.length;
                charCount.textContent = `${count}/500`;
                commentButtons.style.display = count > 0 ? 'flex' : 'none';
            });
        }

        const postId = {{ $post->id }};
        isLoggedIn ? updateReactionCount(postId) : loadReactionCountsForVisitor(postId);
        fetchComments(postId);
    });

    function cancelComment() {
        const commentInput = document.getElementById('commentInput');
        commentInput.value = '';
        document.getElementById('comment-input-buttons').style.display = 'none';
    }

    function handleCommentSubmit(postId) {
        const input = document.getElementById('commentInput');
        const val = input.value.trim();
        if(!val) return alert("Comment cannot be empty");

        document.getElementById('loading-comments').style.display = 'block';
        
        fetch(`${url}/api/post/comment`, {
            method: 'POST',
            headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' },
            body: JSON.stringify({ post_id: postId, comment: val })
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('loading-comments').style.display = 'none';
            if(data.status) {
                cancelComment();
                fetchComments(postId);
            } else { alert("Error saving comment"); }
        })
        .catch(err => console.error(err));
    }

    function handleReact(postId, reaction) {
        if(!isLoggedIn) return alert("Please login to react");
        fetch(`${url}/api/posts/${postId}/react`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
            body: JSON.stringify({ reaction })
        }).then(res => res.json()).then(data => { if(data.status) updateReactionCount(postId); });
    }

    function updateReactionCount(postId) {
        fetch(`${url}/api/posts/${postId}/reactions`, { headers: { 'Authorization': `Bearer ${token}` } })
        .then(res => res.json())
        .then(data => {
            document.getElementById(`likes-${postId}`).innerText = data.likes;
            document.getElementById(`dislikes-${postId}`).innerText = data.dislikes;
            
            const likeBtn = document.getElementById(`like-btn-${postId}`);
            const dislikeBtn = document.getElementById(`dislike-btn-${postId}`);
            likeBtn.classList.remove('active-like');
            dislikeBtn.classList.remove('active-dislike');

            if(data.userReaction === 1) likeBtn.classList.add('active-like');
            if(data.userReaction === 0) dislikeBtn.classList.add('active-dislike');
        });
    }

    function loadReactionCountsForVisitor(postId) {
        fetch(`${url}/api/public/post/reaction/${postId}`)
        .then(res => res.json())
        .then(data => {
            if(data.status) {
                document.getElementById(`likes-${postId}`).innerText = data.likes;
                document.getElementById(`dislikes-${postId}`).innerText = data.dislikes;
            }
        });
    }

    function fetchComments(postId) {
        fetch(`${url}/api/public/post/${postId}/comments`)
        .then(res => res.json())
        .then(data => {
            const list = document.getElementById(`comments-list-${postId}`);
            const count = document.getElementById(`comment-count-${postId}`);
            
            if(data.status && Array.isArray(data.comments)) {
                count.innerText = data.comments.length;
                list.innerHTML = '';
                const tree = buildCommentTree(data.comments);
                renderComments(tree, list, postId);
            } else {
                list.innerHTML = '<div style="color:var(--ink-secondary)">No comments yet.</div>';
            }
        });
    }

    function buildCommentTree(comments) {
        const map = {}; const tree = [];
        comments.forEach(c => { c.replies = []; map[c.id] = c; });
        comments.forEach(c => {
            if(c.parent_id && map[c.parent_id]) {
                map[c.parent_id].replies.push(c);
            } else {
                tree.push(c);
            }
        });
        return tree;
    }

    function renderComments(comments, container, postId, level = 0) {
        comments.forEach(c => {
            const div = document.createElement('div');
            div.className = `comment-card ${level > 0 ? 'reply' : ''}`;
            
            // HTML Generation for Comment Item
            const avatarUrl = c.user?.avatar ? `/storage/${c.user.avatar}` : `https://ui-avatars.com/api/?name=${c.user?.name}&background=random`;
            const isAuthor = isLoggedIn && c.user?.id === {{ Auth::id() ?? 0 }};

            div.innerHTML = `
                <div class="comment-header">
                    <img src="${avatarUrl}" style="width:36px; height:36px; border-radius:50%; object-fit:cover;">
                    <div style="flex:1">
                         <div style="display:flex; justify-content:space-between;">
                            <span class="comment-author">${c.user?.username ?? 'Guest'}</span>
                            <span class="comment-date">${new Date(c.created_at).toLocaleDateString()}</span>
                        </div>
                    </div>
                </div>
                <div class="comment-body">${c.comment}</div>
                <div class="comment-actions">
                    <button onclick="toggleReplyForm(${c.id})">Reply</button>
                    ${isAuthor ? `<button onclick="deleteComment(${c.id}, ${postId})" style="color:#e11d48">Delete</button>` : ''}
                </div>

                <div id="reply-form-${c.id}" style="display:none; margin-top:15px; margin-left:20px;">
                    <textarea id="reply-input-${c.id}" rows="2" placeholder="Write a reply..."></textarea>
                    <div style="margin-top:5px; text-align:right;">
                         <button class="action-btn outline" onclick="toggleReplyForm(${c.id})">Cancel</button>
                         <button class="action-btn" onclick="submitReply(${c.id}, ${postId})">Reply</button>
                    </div>
                </div>

                <div id="replies-${c.id}"></div>
            `;
            
            container.appendChild(div);

            if(c.replies.length > 0) {
                const replyCont = document.getElementById(`replies-${c.id}`);
                renderComments(c.replies, replyCont, postId, level + 1);
            }
        });
    }

    function toggleReplyForm(id) {
        if(!isLoggedIn) return alert("Please login to reply.");
        const f = document.getElementById(`reply-form-${id}`);
        f.style.display = f.style.display === 'none' ? 'block' : 'none';
    }

    function submitReply(cId, pId) {
        const val = document.getElementById(`reply-input-${cId}`).value.trim();
        if(!val) return;
        
        fetch(`${url}/api/post/comment`, {
            method: 'POST',
            headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' },
            body: JSON.stringify({ post_id: pId, comment: val, parent_id: cId })
        }).then(res=>res.json()).then(d=>{
            if(d.status) fetchComments(pId);
        });
    }

    function deleteComment(cId, pId) {
        if(!confirm("Delete this comment?")) return;
        fetch(`${url}/api/post/comment/delete/${cId}`, {
            method: 'DELETE', headers: { 'Authorization': `Bearer ${token}` }
        }).then(res=>res.json()).then(d=>{
            if(d.status) fetchComments(pId);
        });
    }

    function sharePost(link) {
        if(navigator.share) navigator.share({ title: 'Read this on Shabd', url: link });
        else { prompt("Copy link:", link); }
    }

</script>
@endpush