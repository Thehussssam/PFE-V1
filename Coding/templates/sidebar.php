<?php
// session helpers
require_once __DIR__ . '/../includes/session.php';
?>

<aside class="sidebar">

    <div>

        <!-- logo -->
        <div class="sidebar-logo">

            <a href="/index.php" class="navbar-logo">

                <img src="/assets/images/logo.png" alt="JobConnect Logo" class="logo-img" width="32" height="32">

                <span class="logo-text">
                    Job<span class="logo-accent">Connect</span>
                </span>

            </a>

        </div>

        <!-- menu -->
        <nav class="sidebar-menu">

            <?php if (isCompany()): ?>

                <a href="/entreprise/dashboard.php">
                    <i class="fa-solid fa-gauge"></i>
                    Dashboard
                </a>

                <a href="/entreprise/profile.php">
                    <i class="fa-solid fa-gear"></i>
                    Settings
                </a>

            <?php elseif (isAdmin()): ?>

                <a href="/admin/dashboard.php">
                    <i class="fa-solid fa-gauge"></i>
                    Dashboard
                </a>

            <?php else: ?>

                <a href="/utilisateur/dashboard.php">
                    <i class="fa-solid fa-gauge"></i>
                    Dashboard
                </a>

                <a href="/utilisateur/profile.php">
                    <i class="fa-solid fa-gear"></i>
                    Settings
                </a>

            <?php endif; ?>

        </nav>

    </div>

    <!-- user info -->
    <div class="sidebar-user">

        <div>

            <h4>
                <?= htmlspecialchars($_SESSION['user_name'] ?? 'Guest'); ?>
            </h4>

            <span>
                <?php
                    if (isAdmin()) {
                        echo 'Admin';
                    } elseif (isCompany()) {
                        echo 'Company';
                    } else {
                        echo 'Candidate';
                    }
                ?>
            </span>

        </div>

        <a href="/logout.php" class="btn-logout">Logout</a>

    </div>

</aside>