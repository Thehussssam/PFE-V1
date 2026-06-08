<?php
include 'includes/header.php';
include 'includes/navbar.php';
?>

<main class="auth-page-wrapper">
    <div class="auth-card-container container-register">
        <!-- Header -->
        <div class="auth-header">
            <h1 class="auth-title">Join JobConnect</h1>
            <p class="auth-subtitle">Start your professional journey with the modern recruitment hub.</p>
        </div>
        <!-- Register Card -->
        <div class="auth-card">
            <!-- Error Message -->
            <?php if (isset($_SESSION['register_error'])): ?>
                <div class="auth-alert alert-error">
                    <?php
                        echo $_SESSION['register_error'];
                        unset($_SESSION['register_error']);
                    ?>
                </div>
            <?php endif; ?>
            <!-- Info Message -->
            <div class="auth-info-box">
                <p>Use <strong>@gmail.com</strong> for candidate accounts or <strong>@company.com</strong> for recruiter accounts.</p><br>
            </div>
            <!-- Register Form -->
            <form action="actions/register_action.php" method="POST" class="auth-form">
                <div class="form-row-grid">
                    <!-- Prenom -->
                    <div class="auth-field-group">
                        <label for="prenom" class="field-label">First Name</label>
                        <div class="auth-input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input type="text" id="prenom" name="prenom" placeholder="Aziz" required>
                        </div>
                    </div>
                    <!-- Nom -->
                    <div class="auth-field-group">
                        <label for="nom" class="field-label">Last Name</label>
                        <div class="auth-input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input type="text" id="nom" name="nom" placeholder="Akhennouch" required>
                        </div>
                    </div>
                </div>
                <!-- Email -->
                <div class="auth-field-group">
                    <label for="email" class="field-label">Email Address</label>
                    <div class="auth-input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <input type="email" id="email" name="email" placeholder="example@gmail.com or example@company.com" required>
                    </div>
                </div>
                <!-- Password -->
                <div class="auth-field-group">
                    <label for="password" class="field-label">Password</label>
                    <div class="auth-input-wrapper">
                        <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input type="password" id="password" name="password" placeholder="********" required>
                    </div>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn-auth-submit">
                    <span>Create Account</span>
                    <svg class="btn-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </form>
            <!-- Divider -->
            <div class="auth-divider">
                <span>JOBCONNECT PLATFORM</span>
            </div>
            <!-- Footer -->
            <div class="auth-card-footer">
                <p>Already have an account ? <a href="login.php" class="auth-link-highlight">Log In</a></p>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>