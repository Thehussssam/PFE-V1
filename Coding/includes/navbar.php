<?php

require_once __DIR__ . '/session.php';

?>

<nav class="navbar">

    <div class="nav-container">

        <!-- LOGO -->
        <a href="/index.php" class="navbar-logo">

            <img src="/assets/images/logo.png" alt="JobConnect Logo" class="logo-img" width="32" height="32">

            <span class="logo-text"> Job<span class="logo-accent">Connect</span></span>

        </a>

        <!-- LINKS -->
        <div class="nav-links">

            <!-- PUBLIC LINKS (everyone sees them) -->
            <a href="/utilisateur/jobs.php">Find Jobs</a>
            <a href="/utilisateur/categories.php">Categories</a>
        
        </div>

        <!-- AUTH SECTION -->
        <div class="nav-auth">

            <?php if (isLoggedIn()): ?>

                <?php if (isCandidate()): ?>
                    <a href="/utilisateur/dashboard.php" class="btn">My Profil</a>
                <?php endif; ?>

                <a href="/logout.php" class="btn-logout">Logout</a>

            <?php else: ?>

                <a href="/login.php" class="btn-login">Login</a>
                <a href="/register.php" class="btn-register">Register</a>

            <?php endif; ?>

        </div>

    </div>

</nav>