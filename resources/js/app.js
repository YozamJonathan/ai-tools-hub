import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();



window.toggleSaveTool = function(btn, toolId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch(`/favorites/toggle/${toolId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.error) {
            // Not logged in or limit reached
            window.location.href = '/login';
            return;
        }
        // Toggle heart icon
        btn.textContent = data.saved ? '♥' : '♡';
        btn.classList.toggle('saved', data.saved);

        // Show feedback
        const msg = data.saved ? 'Saved to favorites ♥' : 'Removed from favorites';
        showQuickToast(msg);
    });
};

function showQuickToast(message) {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position:fixed;bottom:24px;right:24px;z-index:9999;
        background:var(--surface);border:1px solid var(--border2);
        border-left:3px solid var(--accent);border-radius:12px;
        padding:12px 16px;font-size:14px;font-weight:500;
        box-shadow:0 8px 32px #00000060;
        animation:slideInRight 0.3s ease;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);
}
