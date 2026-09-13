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
    hamburger?.setAttribute('aria-expanded', 'true');
    mobileNav?.classList.add('open');
    overlay?.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMobile() {
    hamburger?.classList.remove('open');
    hamburger?.setAttribute('aria-expanded', 'false');
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
function wishIds() {
    return getWish().map(x => String(typeof x === 'object' ? x.id : x));
}
document.querySelectorAll('.product-wish[data-id]').forEach(btn => {
    const id = String(btn.dataset.id);
    if (wishIds().includes(id)) btn.classList.add('active');
    btn.addEventListener('click', () => {
        let w = getWish();
        const ids = w.map(x => String(typeof x === 'object' ? x.id : x));
        if (ids.includes(id)) {
            w = w.filter(x => String(typeof x === 'object' ? x.id : x) !== id);
            btn.classList.remove('active');
        } else {
            w.push({
                id,
                name:     btn.dataset.name     || '',
                slug:     btn.dataset.slug     || '',
                image:    btn.dataset.image    || '',
                category: btn.dataset.category || '',
            });
            btn.classList.add('active');
        }
        saveWish(w);
        updateWishBadge();
    });
});
function updateWishBadge() {
    const count = getWish().length;
    document.querySelectorAll('.nav-wish-badge').forEach(b => {
        b.textContent = count || '';
        b.style.display = count ? 'flex' : 'none';
    });
}
updateWishBadge();

// Gallery thumbnails handled inline in products/show.blade.php

// ── Alert auto-dismiss
document.querySelectorAll('.alert').forEach(el => {
    setTimeout(() => el.style.opacity = '0', 4000);
    setTimeout(() => el.remove(), 4500);
});

// ── Scroll reveal
if (document.documentElement.classList.contains('js-reveal') && 'IntersectionObserver' in window) {
    const revealGroups = [
        '.section-head',
        '.product-card',
        '.cat-card',
        '.blog-card',
        '.testimonial-card',
        '.wyc-card',
        '.process-step',
        '.trust-cert',
    ];
    revealGroups.forEach(selector => {
        const els = document.querySelectorAll(selector);
        els.forEach((el, i) => {
            el.classList.add('reveal');
            el.style.setProperty('--reveal-delay', Math.min(i % 4, 3) * 0.08 + 's');
        });
    });

    const revealObserver = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
}

