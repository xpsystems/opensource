<nav class="nav-header">
    <div class="nav-inner">
        <a href="https://xpsystems.eu" class="nav-logo"><?= htmlspecialchars($site_config['site_name']) ?></a>

        <div class="nav-links">
            <?php foreach ($nav_links as $link): ?>
                <a href="<?= htmlspecialchars($link['url']) ?>"
                   class="nav-link<?= !empty($link['active']) ? ' active' : '' ?>">
                    <?= htmlspecialchars($link['label']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="nav-right">
            <?php include __DIR__ . '/theme-toggle.php'; ?>
            <button class="nav-hamburger" aria-label="Toggle menu" type="button">
                <svg class="icon-hamburger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                <svg class="icon-close"     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>
</nav>
<div class="nav-overlay"></div>