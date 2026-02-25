// script.js - xpsystems Template Logic

(function() {
    'use strict';

    // ── Theme Management ───────────────────────────────
    const THEME_KEY = 'xps-theme';
    
    const getSystemTheme = () => window.matchMedia("(prefers-color-scheme: light)").matches ? 'light' : 'dark';
    
    const applyTheme = (mode) => {
        const resolved = mode === 'system' ? getSystemTheme() : mode;
        document.documentElement.setAttribute('data-theme', resolved);
        document.querySelectorAll('.theme-btn').forEach(btn => btn.classList.toggle('active', btn.dataset.theme === mode));
    };

    // Init Theme
    let currentTheme = localStorage.getItem(THEME_KEY) || 'system';
    applyTheme(currentTheme);

    // Listen for OS changes
    window.matchMedia("(prefers-color-scheme: light)").addEventListener('change', () => {
        if (currentTheme === 'system') applyTheme('system');
    });

    // Button Listeners
    document.querySelectorAll('.theme-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            currentTheme = btn.dataset.theme;
            localStorage.setItem(THEME_KEY, currentTheme);
            document.documentElement.classList.add('is-switching-theme');
            applyTheme(currentTheme);
            setTimeout(() => document.documentElement.classList.remove('is-switching-theme'), 350);
        });
    });

    // ── Reveal Animation ───────────────────────────────
    const reveals = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        
        reveals.forEach(el => observer.observe(el));
    } else {
        reveals.forEach(el => el.classList.add('visible'));
    }

    // ── Mobile Navigation ──────────────────────────────
    const hamburger = document.querySelector('.nav-hamburger');
    const navLinks = document.querySelector('.nav-links');
    const overlay = document.querySelector('.nav-overlay');

    if (hamburger && navLinks) {
        const toggleNav = () => {
            hamburger.classList.toggle('open');
            navLinks.classList.toggle('open');
            if(overlay) overlay.classList.toggle('active');
        };

        hamburger.addEventListener('click', toggleNav);
        if (overlay) overlay.addEventListener('click', toggleNav);
    }

})();