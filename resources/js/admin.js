// ── Alert auto-dismiss
document.querySelectorAll('.a-alert').forEach(el => {
    setTimeout(() => { el.style.transition = 'opacity .5s'; el.style.opacity = '0'; }, 4000);
    setTimeout(() => el.remove(), 4600);
});

// ── Image preview on file input
document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
    const previewId = input.dataset.preview;
    const preview = document.getElementById(previewId);
    if (!preview) return;
    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(file);
    });
});

// ── Confirm delete
document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', e => {
        if (!confirm(el.dataset.confirm || 'Are you sure?')) e.preventDefault();
    });
});

// ── Sidebar active link
const current = window.location.pathname;
document.querySelectorAll('.sidebar-link').forEach(link => {
    if (link.getAttribute('href') && current.startsWith(link.getAttribute('href').split('?')[0])) {
        link.classList.add('active');
    }
});

// ── Toggle password visibility (login form)
document.querySelectorAll('[data-toggle-pass]').forEach(btn => {
    const target = document.querySelector(btn.dataset.togglePass);
    if (!target) return;
    btn.addEventListener('click', () => {
        target.type = target.type === 'password' ? 'text' : 'password';
    });
});
