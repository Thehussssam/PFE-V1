<?php
// session start
session_start();

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- auth page -->
<main class="auth-page-wrapper">
    <div class="auth-card-container">

        <!-- header -->
        <div class="auth-header">
            <h1 class="auth-title">Welcome back</h1>
            <p class="auth-subtitle">Start your professional journey with the modern recruitment hub.</p>
        </div>

        <!-- login card -->
        <div class="auth-card">

            <!-- error message -->
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="auth-alert alert-error">
                    <?php
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- success message -->
            <?php if (isset($_SESSION['register_success'])): ?>
                <div class="auth-alert alert-success">
                    <?php
                        echo $_SESSION['register_success'];
                        unset($_SESSION['register_success']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- login form -->
            <form action="actions/login_action.php" method="POST" class="auth-form">

                <!-- email field -->
                <div class="auth-field-group">
                    <label for="email" class="field-label">Email Address</label>

                    <div class="auth-input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>

                        <input type="email" id="email" name="email" placeholder="name@gmail.com" required>
                    </div>
                </div>

                <!-- password field -->
                <div class="auth-field-group">
                    <label for="password" class="field-label">Password</label>

                    <div class="auth-input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>

                        <input type="password" id="password" name="password" placeholder="********" required>
                    </div>
                </div>

                <!-- submit button -->
                <button type="submit" class="btn-auth-submit">Sign In</button>

            </form>

            <!-- footer link -->
            <div class="auth-card-footer">
                <p>
                    Don't have an account?
                    <a href="register.php" class="auth-link-highlight">Sign Up for free</a>
                </p>
            </div>

        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>