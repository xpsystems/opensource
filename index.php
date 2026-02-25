<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_config['site_title']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($site_config['site_description']) ?>">
    <link rel="canonical" href="https://opensource.xpsystems.eu">
    <meta property="og:title" content="<?= htmlspecialchars($site_config['site_title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($site_config['site_description']) ?>">
    <meta property="og:url" content="https://opensource.xpsystems.eu">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'components/navbar.php'; ?>

    <!-- ── Hero ──────────────────────────────────────── -->
    <header class="hero oss-hero">
        <div class="hero-grid-bg" aria-hidden="true"></div>
        <div class="container">
            <div class="hero-badge reveal">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                Open Source at XP-Systems
            </div>
            <h1 class="hero-title reveal" style="--delay:60ms">We build<br><span class="hero-title-accent">in the open.</span></h1>
            <p class="hero-description reveal" style="--delay:140ms">
                Infrastructure, tooling, and experiments — publicly available on GitHub.<br>
                Contributions, issues, and forks are always welcome.
            </p>

            <div class="hero-actions reveal" style="--delay:220ms">
                <a href="https://github.com/xpsystems" class="btn btn-primary" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                    github.com/xpsystems
                </a>
                <a href="#repos" class="btn btn-ghost">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Browse Repos
                </a>
            </div>

            <!-- Live GitHub stat counters -->
            <div class="hero-stats reveal" style="--delay:300ms">
                <div class="stat-item">
                    <span class="stat-num" id="stat-repos">—</span>
                    <span class="stat-label">Public Repos</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-num" id="stat-stars">—</span>
                    <span class="stat-label">Total Stars</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-num" id="stat-forks">—</span>
                    <span class="stat-label">Total Forks</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-num" id="stat-members">2</span>
                    <span class="stat-label">Members</span>
                </div>
            </div>
        </div>
    </header>

    <div class="section-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C300,100 900,0 1200,100 L1200,120 L0,120 Z" class="divider-fill-alt"></path>
        </svg>
    </div>

    <!-- ── Organizations ─────────────────────────────── -->
    <section class="oss-section org-section" style="background:var(--bg-alt)">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Our Organizations</h2>
                <p class="section-sub">We maintain two GitHub organizations, each with a distinct focus.</p>
            </div>

            <div class="org-grid">
                <?php foreach ($github_orgs as $org): ?>
                <a href="<?= htmlspecialchars($org['url']) ?>" target="_blank" rel="noopener"
                   class="org-card reveal" data-org="<?= htmlspecialchars($org['handle']) ?>">
                    <div class="org-card-top">
                        <div class="org-avatar" id="avatar-<?= htmlspecialchars($org['handle']) ?>">
                            <!-- Avatar injected by JS -->
                            <div class="org-avatar-placeholder">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                            </div>
                        </div>
                        <div class="org-info">
                            <h3 class="org-name mono">@<?= htmlspecialchars($org['handle']) ?></h3>
                            <p class="org-desc"><?= htmlspecialchars($org['description']) ?></p>
                        </div>
                    </div>
                    <div class="org-card-stats">
                        <span class="org-stat" id="org-repos-<?= htmlspecialchars($org['handle']) ?>">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                            <span class="org-stat-num">…</span> repos
                        </span>
                    </div>
                    <div class="org-link-hint">
                        View on GitHub
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <div class="section-divider" style="margin-top:-80px">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M1200,0 C900,100 300,0 0,100 L0,120 L1200,120 Z" class="divider-fill-bg"></path>
        </svg>
    </div>

    <!-- ── Repositories ──────────────────────────────── -->
    <section class="oss-section" id="repos" style="background:var(--bg); padding-top:60px;">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Repositories</h2>
                <p class="section-sub">All public repositories across our GitHub organizations, fetched live.</p>
            </div>

            <!-- Controls -->
            <div class="repo-controls reveal">
                <div class="repo-search-wrap">
                    <svg class="repo-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="repo-search" class="repo-search" placeholder="Filter repositories…" autocomplete="off">
                </div>
                <div class="repo-filters">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="xpsystems">xpsystems</button>
                    <button class="filter-btn" data-filter="xpsystems-ai">xpsystems-ai</button>
                </div>
            </div>

            <!-- Table -->
            <div class="repo-table-wrap reveal">
                <table class="repo-table" id="repo-table">
                    <thead>
                        <tr>
                            <th class="col-name sortable" data-col="name">
                                Repository
                                <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 15l5 5 5-5M7 9l5-5 5 5"/></svg>
                            </th>
                            <th class="col-org">Org</th>
                            <th class="col-lang">Language</th>
                            <th class="col-stars sortable" data-col="stars">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                Stars
                                <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 15l5 5 5-5M7 9l5-5 5 5"/></svg>
                            </th>
                            <th class="col-forks sortable" data-col="forks">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="3" x2="6" y2="15"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><circle cx="6" cy="6" r="3"/><path d="M18 9a9 9 0 0 1-9 9"/></svg>
                                Forks
                                <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 15l5 5 5-5M7 9l5-5 5 5"/></svg>
                            </th>
                            <th class="col-updated sortable" data-col="updated">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Updated
                                <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7 15l5 5 5-5M7 9l5-5 5 5"/></svg>
                            </th>
                            <th class="col-link"></th>
                        </tr>
                    </thead>
                    <tbody id="repo-tbody">
                        <tr class="repo-loading-row">
                            <td colspan="7">
                                <div class="repo-loading">
                                    <div class="loading-spinner"></div>
                                    <span>Fetching repositories from GitHub…</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="repo-empty" id="repo-empty" style="display:none">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <p>No repositories match your filter.</p>
                </div>
            </div>
            <p class="repo-meta" id="repo-meta"></p>
        </div>
    </section>

    <div class="section-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C300,100 900,0 1200,100 L1200,120 L0,120 Z" class="divider-fill-alt"></path>
        </svg>
    </div>

    <!-- ── Team ──────────────────────────────────────── -->
    <section class="oss-section team-section" style="background:var(--bg-alt)">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Team</h2>
                <p class="section-sub">The people behind xpsystems.</p>
            </div>

            <div class="team-grid">
                <?php foreach ($team_members as $member): ?>
                <div class="team-card reveal" data-github="<?= htmlspecialchars($member['github']) ?>">
                    <div class="team-avatar-wrap">
                        <img class="team-avatar" src="" alt="<?= htmlspecialchars($member['name']) ?>"
                             data-src="https://avatars.githubusercontent.com/<?= htmlspecialchars($member['github']) ?>?s=160">
                        <div class="team-avatar-skeleton"></div>
                    </div>
                    <div class="team-info">
                        <h3 class="team-name"><?= htmlspecialchars($member['name']) ?></h3>
                        <p class="team-role"><?= htmlspecialchars($member['role']) ?></p>
                        <a href="https://github.com/<?= htmlspecialchars($member['github']) ?>" target="_blank" rel="noopener" class="team-github">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                            @<?= htmlspecialchars($member['github']) ?>
                        </a>
                    </div>
                    <div class="team-gh-stats" id="gh-stats-<?= htmlspecialchars($member['github']) ?>">
                        <div class="gh-stat-item">
                            <span class="gh-stat-num" data-type="repos">—</span>
                            <span class="gh-stat-label">Repos</span>
                        </div>
                        <div class="gh-stat-item">
                            <span class="gh-stat-num" data-type="followers">—</span>
                            <span class="gh-stat-label">Followers</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Divider: Content -> Footer -->
    <div class="section-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 L1200,80 L1200,120 L0,120 Z" class="divider-fill-footer"></path>
        </svg>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>