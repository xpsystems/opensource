<footer class="site-footer">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand">
                <span class="footer-logo"><?= htmlspecialchars($site_config['site_name']) ?></span>
                <span class="footer-copy">&copy; <?= htmlspecialchars($site_config['current_year']) ?> xpsystems. All rights reserved.</span>
                <span class="footer-version"><?= htmlspecialchars($site_config['version']) ?></span>
            </div>
            <div class="footer-links">
                <?php foreach ($footer_links as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>" class="footer-link"><?= htmlspecialchars($link['label']) ?></a>
                <?php endforeach; ?>
            </div>
            <div class="footer-right">
                <?php include __DIR__ . '/theme-toggle.php'; ?>
            </div>
        </div>
    </div>
</footer>