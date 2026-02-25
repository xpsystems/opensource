<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_config['site_title']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($site_config['site_description']) ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'components/navbar.php'; ?>

    <!-- Hero Section -->
    <header class="hero">
        <div class="container">
            <h1 class="hero-title reveal">Welcome to XP-Systems</h1>
            <p class="hero-description reveal" style="--delay: 100ms">
                This is a template page. Replace this content with your actual service information.
            </p>
        </div>
    </header>

    <!-- Divider: Hero -> Content -->
    <div class="section-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C300,100 900,0 1200,100 L1200,120 L0,120 Z" class="divider-fill-alt"></path>
        </svg>
    </div>

    <!-- Main Content -->
    <main class="services-section">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Our Services</h2>
            </div>
            <!-- Add your content grid/cards here -->
        </div>
    </main>

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