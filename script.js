// script.js - xpsystems opensource.xpsystems.eu
// All GitHub data is fetched through api.php (server-side proxy with token).

(function () {
    'use strict';

    // ── Theme Management ───────────────────────────────
    const THEME_KEY = 'xps-theme';
    const getSystemTheme = () =>
        window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
    const applyTheme = (mode) => {
        const resolved = mode === 'system' ? getSystemTheme() : mode;
        document.documentElement.setAttribute('data-theme', resolved);
        document.querySelectorAll('.theme-btn').forEach(btn =>
            btn.classList.toggle('active', btn.dataset.theme === mode)
        );
    };
    let currentTheme = localStorage.getItem(THEME_KEY) || 'system';
    applyTheme(currentTheme);
    window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', () => {
        if (currentTheme === 'system') applyTheme('system');
    });
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
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(el => observer.observe(el));
    } else {
        reveals.forEach(el => el.classList.add('visible'));
    }

    // ── Mobile Navigation ──────────────────────────────
    const hamburger = document.querySelector('.nav-hamburger');
    const navLinks  = document.querySelector('.nav-links');
    const overlay   = document.querySelector('.nav-overlay');
    if (hamburger && navLinks) {
        const toggleNav = () => {
            hamburger.classList.toggle('open');
            navLinks.classList.toggle('open');
            if (overlay) overlay.classList.toggle('active');
        };
        hamburger.addEventListener('click', toggleNav);
        if (overlay) overlay.addEventListener('click', toggleNav);
    }

    // ── API Helper ─────────────────────────────────────
    // All calls go through api.php — the GitHub token stays on the server.
    async function api(action, params = {}) {
        const qs = new URLSearchParams({ action, ...params }).toString();
        const res = await fetch(`api.php?${qs}`);
        if (!res.ok) throw new Error(`API error ${res.status}`);
        const data = await res.json();
        if (data && data.error) throw new Error(data.error);
        return data;
    }

    // ── Language Color Map ─────────────────────────────
    const LANG_COLORS = {
        JavaScript:'#f1e05a', TypeScript:'#3178c6', Python:'#3572A5',
        PHP:'#4F5D95', CSS:'#563d7c', HTML:'#e34c26', Shell:'#89e051',
        Go:'#00ADD8', Rust:'#dea584', Dockerfile:'#384d54', Vue:'#41b883',
        Svelte:'#ff3e00', Ruby:'#701516', C:'#555555', 'C++':'#f34b7d',
        Java:'#b07219', Kotlin:'#A97BFF', Swift:'#F05138', Nix:'#7e7eff',
    };
    function langDot(lang) {
        const color = LANG_COLORS[lang] || '#8b8b8b';
        return `<span class="lang-dot" style="background:${color}"></span>`;
    }

    // ── Relative Time ──────────────────────────────────
    function relTime(iso) {
        const diff = (Date.now() - new Date(iso)) / 1000;
        if (diff < 60)           return 'just now';
        if (diff < 3600)         return `${Math.floor(diff/60)}m ago`;
        if (diff < 86400)        return `${Math.floor(diff/3600)}h ago`;
        if (diff < 86400*30)     return `${Math.floor(diff/86400)}d ago`;
        if (diff < 86400*365)    return `${Math.floor(diff/2592000)}mo ago`;
        return `${Math.floor(diff/31536000)}y ago`;
    }

    // ── Animate Counter ────────────────────────────────
    function animateCount(el, target) {
        if (!el || isNaN(target)) return;
        const duration = 800;
        const start = performance.now();
        const step = (now) => {
            const p = Math.min((now - start) / duration, 1);
            const ease = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(ease * target);
            if (p < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // ── Repo Table State ──────────────────────────────
    let allRepos  = [];
    let sortCol   = 'updated';
    let sortDir   = 'desc';
    let filterSrc = 'all';
    let searchQ   = '';

    function getFilteredRepos() {
        return allRepos
            .filter(r => filterSrc === 'all' || r._source === filterSrc)
            .filter(r => {
                if (!searchQ) return true;
                const q = searchQ.toLowerCase();
                return r.name.toLowerCase().includes(q) ||
                    (r.description||'').toLowerCase().includes(q) ||
                    (r.language||'').toLowerCase().includes(q);
            })
            .sort((a, b) => {
                let av, bv;
                if (sortCol === 'name')    { av = a.name;              bv = b.name; }
                if (sortCol === 'stars')   { av = a.stargazers_count;  bv = b.stargazers_count; }
                if (sortCol === 'forks')   { av = a.forks_count;       bv = b.forks_count; }
                if (sortCol === 'updated') { av = a.pushed_at;         bv = b.pushed_at; }
                if (sortDir === 'asc')  return av > bv ?  1 : -1;
                if (sortDir === 'desc') return av < bv ?  1 : -1;
                return 0;
            });
    }

    function renderTable() {
        const tbody = document.getElementById('repo-tbody');
        const empty = document.getElementById('repo-empty');
        const meta  = document.getElementById('repo-meta');
        if (!tbody) return;

        const repos = getFilteredRepos();

        document.querySelectorAll('.repo-table th.sortable').forEach(th => {
            th.classList.remove('sort-asc','sort-desc');
            if (th.dataset.col === sortCol) th.classList.add('sort-' + sortDir);
        });

        if (repos.length === 0) {
            tbody.innerHTML = '';
            if (empty) empty.style.display = 'flex';
            if (meta)  meta.textContent = '';
            return;
        }
        if (empty) empty.style.display = 'none';
        if (meta)  meta.textContent = `${repos.length} of ${allRepos.length} repos`;

        tbody.innerHTML = repos.map(r => `
            <tr>
                <td class="col-name">
                    <div>
                        <a class="repo-name-link mono" href="${r.html_url}" target="_blank" rel="noopener">
                            ${escapeHtml(r.name)}
                            ${r.fork ? '<span class="repo-fork-badge">fork</span>' : ''}
                        </a>
                        ${r.description ? `<div class="repo-desc">${escapeHtml(r.description)}</div>` : ''}
                    </div>
                </td>
                <td class="col-org">
                    <span class="org-tag ${escapeHtml(r._source)}">@${escapeHtml(r._source)}</span>
                </td>
                <td class="col-lang">
                    <span class="lang-label">
                        ${r.language
                            ? langDot(r.language) + escapeHtml(r.language)
                            : '<span style="color:var(--text-dim)">—</span>'}
                    </span>
                </td>
                <td class="col-stars">
                    <span class="star-count">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        ${r.stargazers_count}
                    </span>
                </td>
                <td class="col-forks">
                    <span class="fork-count">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="3" x2="6" y2="15"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><circle cx="6" cy="6" r="3"/><path d="M18 9a9 9 0 0 1-9 9"/></svg>
                        ${r.forks_count}
                    </span>
                </td>
                <td class="col-updated" style="color:var(--text-muted);font-size:0.8125rem;">${relTime(r.pushed_at)}</td>
                <td class="col-link">
                    <a href="${r.html_url}" target="_blank" rel="noopener" class="repo-link-btn" title="Open on GitHub">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                    </a>
                </td>
            </tr>
        `).join('');
    }

    // ── Sort headers ──────────────────────────────────
    document.querySelectorAll('.repo-table th.sortable').forEach(th => {
        th.addEventListener('click', () => {
            const col = th.dataset.col;
            if (sortCol === col) { sortDir = sortDir === 'asc' ? 'desc' : 'asc'; }
            else { sortCol = col; sortDir = col === 'name' ? 'asc' : 'desc'; }
            renderTable();
        });
    });

    // ── Filter buttons ────────────────────────────────
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterSrc = btn.dataset.filter;
            renderTable();
        });
    });

    // ── Search input ──────────────────────────────────
    const searchEl = document.getElementById('repo-search');
    if (searchEl) searchEl.addEventListener('input', () => { searchQ = searchEl.value.trim(); renderTable(); });

    // ── GitHub sources config (mirrors config.php) ────
    // type: "org" → api.php?action=org_info / org_repos
    // type: "user" → api.php?action=user_info / user_repos
    const SOURCES = [
        { handle: 'xpsystems',    type: 'org'  },
        { handle: 'xpsystems-ai', type: 'user' },
    ];

    const TEAM = ['michaelninder', 'DogWaterDev'];

    // ── Load org/user cards ───────────────────────────
    SOURCES.forEach(async ({ handle, type }) => {
        try {
            const action = type === 'org' ? 'org_info' : 'user_info';
            const param  = type === 'org' ? { org: handle } : { user: handle };
            const info   = await api(action, param);

            // Avatar
            const avatarWrap = document.getElementById(`avatar-${handle}`);
            if (avatarWrap && info.avatar_url) {
                const img = new Image();
                img.alt = handle;
                img.onload = () => {
                    avatarWrap.innerHTML = '';
                    avatarWrap.appendChild(img);
                };
                img.src = info.avatar_url;
            }

            // Repo count
            const repoNumEl = document.querySelector(`#org-repos-${handle} .org-stat-num`);
            if (repoNumEl) repoNumEl.textContent = info.public_repos ?? '—';
        } catch (_) { /* silently degrade */ }
    });

    // ── Load team member stats ────────────────────────
    TEAM.forEach(async (github) => {
        try {
            const user = await api('user_info', { user: github });

            const statsWrap   = document.getElementById(`gh-stats-${github}`);
            if (statsWrap) {
                const reposEl     = statsWrap.querySelector('[data-type="repos"]');
                const followersEl = statsWrap.querySelector('[data-type="followers"]');
                if (reposEl)     animateCount(reposEl,     user.public_repos || 0);
                if (followersEl) animateCount(followersEl, user.followers    || 0);
            }
        } catch (_) { /* silently degrade */ }
    });

    // ── Load all repos ────────────────────────────────
    (async () => {
        try {
            const repos = await api('all_repos');
            allRepos = Array.isArray(repos) ? repos : [];

            const totalStars = allRepos.reduce((s, r) => s + (r.stargazers_count || 0), 0);
            const totalForks = allRepos.reduce((s, r) => s + (r.forks_count      || 0), 0);

            animateCount(document.getElementById('stat-repos'), allRepos.length);
            animateCount(document.getElementById('stat-stars'), totalStars);
            animateCount(document.getElementById('stat-forks'), totalForks);

            renderTable();
        } catch (err) {
            const tbody = document.getElementById('repo-tbody');
            if (tbody) tbody.innerHTML = `
                <tr><td colspan="7">
                    <div class="repo-loading" style="color:var(--text-dim)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Could not load repositories. Please try again shortly.
                    </div>
                </td></tr>`;
            ['stat-repos','stat-stars','stat-forks'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = '—';
            });
        }
    })();

})();