import Alpine from 'alpinejs';

// ── Nav scroll shadow
const nav = document.querySelector('.nav');
if (nav) {
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 50);
    }, {passive: true});
}

// ── Hamburger mobile nav
const hamburger = document.querySelector('.hamburger');
const mobileNav = document.querySelector('.mobile-nav');
const overlay   = document.querySelector('.mobile-overlay');
const mobileClose = document.querySelector('.mobile-close');

function openMobile() {
    hamburger?.classList.add('open');
    mobileNav?.classList.add('open');
    overlay?.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMobile() {
    hamburger?.classList.remove('open');
    mobileNav?.classList.remove('open');
    overlay?.classList.remove('open');
    document.body.style.overflow = '';
}
hamburger?.addEventListener('click', openMobile);
mobileClose?.addEventListener('click', closeMobile);
overlay?.addEventListener('click', closeMobile);

// ── Product tabs
const tabBtns = document.querySelectorAll('.tab-btn[data-tab]');
tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tab = btn.dataset.tab;
        tabBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tab);
        window.location.href = url.toString();
    });
});

// ── Wishlist toggle (localStorage)
const wishKey = 'ca_wishlist';
function getWish() {
    try { return JSON.parse(localStorage.getItem(wishKey) || '[]'); } catch { return []; }
}
function saveWish(arr) {
    localStorage.setItem(wishKey, JSON.stringify(arr));
}
document.querySelectorAll('.product-wish[data-id]').forEach(btn => {
    const id = String(btn.dataset.id);
    let list = getWish();
    if (list.includes(id)) btn.classList.add('active');
    btn.addEventListener('click', () => {
        let w = getWish();
        if (w.includes(id)) { w = w.filter(x => x !== id); btn.classList.remove('active'); }
        else { w.push(id); btn.classList.add('active'); }
        saveWish(w);
        updateWishBadge();
    });
});
function updateWishBadge() {
    const badge = document.querySelector('.nav-wish-btn .nav-badge');
    if (badge) badge.textContent = getWish().length || '';
}
updateWishBadge();

// ── Product gallery thumbnails
const mainImg = document.querySelector('.gallery-main-img');
document.querySelectorAll('.gallery-thumb').forEach(thumb => {
    thumb.addEventListener('click', () => {
        document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
        if (mainImg && thumb.dataset.src) {
            mainImg.src = thumb.dataset.src;
        }
    });
});

// ── Alert auto-dismiss
document.querySelectorAll('.alert').forEach(el => {
    setTimeout(() => el.style.opacity = '0', 4000);
    setTimeout(() => el.remove(), 4500);
});

window.Alpine = Alpine;
Alpine.start();
