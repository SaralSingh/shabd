@extends('layouts.app')

@section('title', 'Draft New Story — Shabd Studio')

@push('styles')
<style>
/* --- Editor Layout --- */
.editor-container {
    max-width: 800px;
    margin: 3rem auto;
    padding: 0 20px;
}

.editor-header {
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px dashed var(--border-line);
    padding-bottom: 1rem;
}

.editor-title {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--ink-primary);
}

.editor-card {
    background: var(--card-bg);
    border: 1px solid var(--border-line);
    border-radius: var(--radius-sharp);
    padding: 3rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.02);
}

/* Input Fields */
.form-group {
    position: relative;
    margin-bottom: 2.5rem;
}

.input-label {
    position: absolute;
    top: 10px;
    left: 0;
    font-size: 1rem;
    color: var(--ink-secondary);
    pointer-events: none;
    transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1);
}

.input-field {
    width: 100%;
    background: transparent;
    border: none;
    border-bottom: 1px solid var(--border-line);
    padding: 10px 0;
    font-size: 1.1rem;
    color: var(--ink-primary);
    transition: border-color 0.3s;
    border-radius: 0;
}

.input-field:focus {
    outline: none;
    border-bottom-color: var(--ink-primary);
}

.input-field:focus ~ .input-label,
.input-field:valid ~ .input-label {
    top: -15px;
    font-size: 0.75rem;
    color: var(--accent-color);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* File Upload */
.file-upload-wrapper {
    margin-bottom: 2.5rem;
    border: 1px dashed var(--border-line);
    padding: 2rem;
    text-align: center;
    border-radius: var(--radius-sharp);
    cursor: pointer;
    transition: all 0.2s;
    background: #fafafa;
}

.file-upload-wrapper:hover {
    border-color: var(--ink-secondary);
    background: #f0f0f0;
}

.file-input { display: none; }

.upload-placeholder { color: var(--ink-secondary); font-size: 0.9rem; }
.upload-placeholder i { display: block; font-size: 1.5rem; margin-bottom: 10px; color: var(--ink-primary); }

#preview-container {
    margin-top: 15px;
    display: none;
}
#preview-image {
    max-width: 100%;
    max-height: 300px;
    border-radius: var(--radius-sharp);
    display: block;
    margin: 0 auto;
}

/* Buttons */
.action-row {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 3rem;
}

.btn {
    padding: 12px 24px;
    border-radius: var(--radius-sharp);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.95rem;
}

.btn-cancel {
    background: transparent;
    border: 1px solid var(--border-line);
    color: var(--ink-secondary);
}
.btn-cancel:hover { border-color: var(--ink-secondary); color: var(--ink-primary); }

.btn-submit {
    background: var(--ink-primary);
    color: white;
    border: none;
}
.btn-submit:hover { background: var(--accent-color); }

.error-msg {
    color: #e11d48;
    font-size: 0.8rem;
    margin-top: 5px;
    display: block;
}

/* Responsive */
@media (max-width: 600px) {
    .editor-card { padding: 1.5rem; }
    .editor-title { font-size: 1.5rem; }
}
</style>
@endpush

@section('content')
<main class="editor-container">
    
    <header class="editor-header">
        <h1 class="editor-title">Draft New Story</h1>
    </header>

    <div class="editor-card">
        
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <input type="text" name="title" id="title" class="input-field" 
                       value="{{ old('title') }}" required>
                <label for="title" class="input-label">Headline</label>
                @error('title') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <textarea name="description" id="description" class="input-field" 
                          style="min-height: 250px; resize: vertical; line-height: 1.6;" 
                          required>{{ old('description') }}</textarea>
                <label for="description" class="input-label">Write your story here...</label>
                @error('description') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="file-upload-wrapper" onclick="document.getElementById('image').click()">
                <input type="file" name="image" id="image" class="file-input" accept="image/*" onchange="previewImage(event)">
                <div class="upload-placeholder">
                    <i class="far fa-image"></i>
                    <span>Click to add a cover image (Optional)</span>
                </div>
                <div id="preview-container">
                    <img id="preview-image" src="#" alt="Preview">
                </div>
            </div>
            @error('image') <span class="error-msg" style="text-align: center;">{{ $message }}</span> @enderror

            <div class="action-row">
                <button type="reset" class="btn btn-cancel" onclick="clearPreview()">Reset</button>
                <button type="submit" class="btn btn-submit">Publish Story</button>
            </div>

        </form>

    </div>

</main>
@endsection

@push('scripts')
<script>
    // Image Preview Logic
    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.getElementById('preview-image');
        const container = document.getElementById('preview-container');
        const placeholder = document.querySelector('.upload-placeholder');

        reader.onload = function() {
            preview.src = reader.result;
            container.style.display = 'block';
            placeholder.style.display = 'none';
        }

        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    function clearPreview() {
        document.getElementById('preview-container').style.display = 'none';
        document.querySelector('.upload-placeholder').style.display = 'block';
    }
</script>
@endpush