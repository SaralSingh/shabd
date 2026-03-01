// --- Sidebar Logic ---
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
    if (overlay) {
        overlay.classList.toggle('show');
    }
}

// --- Sticky Nav Shadow Logic ---
window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (navbar && window.scrollY > 10) {
        navbar.style.boxShadow = "0 4px 20px rgba(0,0,0,0.03)";
    } else if (navbar) {
        navbar.style.boxShadow = "none";
    }
});

// Hide simple custom-toast after 3s
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const t = document.getElementById('flash-toast');
        if(t) t.style.display = 'none';
    }, 3000);
});

// Toast for new posts
function showToast(title, author, postId) {
    const toast = document.getElementById('newPostToast');
    const toastContent = document.getElementById('toastContent');
    if(toast && toastContent){
        toastContent.innerHTML =
            `New: <strong>${title}</strong><br><small>by ${author}</small>`;
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';

        toastContent.onclick = function () {
            window.location.href = `/post/${postId}`;
        };

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';
        }, 5000);
    }
}
