<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<?php
require_once 'includes/session.php';

if (isLoggedIn()) {

    if (isAdmin()) {
        header('Location: /admin/dashboard.php');
        exit;
    }

    if (isCompany()) {
        header('Location: /entreprise/dashboard.php');
        exit;
    }
}

require 'config/database.php';

$sql = "SELECT * FROM jobs WHERE statut = 'ouverte'";
$stmt = $pdo->query($sql);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="main-content">

    <section class="hero-section">
        <div class="hero-container">

            <div class="hero-text-content">
                <h1 class="hero-title">
                    Find your <span class="highlight-blue">dream job</span><br>with confidence.
                </h1>
                <p class="hero-subtitle">
                    Connect with industry leaders and innovative startups. We streamline your career journey with personalized recommendations and direct employer access.
                </p>
            </div>

            <div class="hero-visual">
                <div class="hero-image-wrapper">
                    <img src="assets/images/bg.jpg" alt="Hero image" class="hero-img">
                </div>
            </div>

        </div>
    </section>

    <section class="stats-bar">
        <div class="stats-container">
            <div class="stat-item">
                <h3 class="stat-number">10k+</h3>
                <p class="stat-label">ACTIVE JOBS</p>
            </div>

            <div class="stat-item">
                <h3 class="stat-number">5k+</h3>
                <p class="stat-label">TOP COMPANIES</p>
            </div>

            <div class="stat-item">
                <h3 class="stat-number">50k+</h3>
                <p class="stat-label">HIRED CANDIDATES</p>
            </div>
        </div>
    </section>

    <section class="featured-section">
        <div class="featured-container">

            <div class="featured-header">
                <div class="featured-titles">
                    <h2 class="section-title">Featured Opportunities</h2>
                    <p class="section-subtitle">Hand-picked premium listings from leading tech partners.</p>
                </div>

                <a href="utilisateur/jobs.php" class="view-all-jobs">
                    View all jobs
                </a>
            </div>
            <div class="job-grid">

<?php foreach($jobs as $job): ?>

<?php
$stmtEntreprise = $pdo->prepare("
    SELECT nom_entreprise, location
    FROM entreprise
    WHERE id_entreprise = ?
");
$stmtEntreprise->execute([$job['id_entreprise']]);
$entreprise = $stmtEntreprise->fetch(PDO::FETCH_ASSOC);
?>

<div class="job-card">

    <div class="job-card-body">

        <h3 class="job-title-card">
            <?php echo htmlspecialchars($job['titre']); ?>
        </h3>

        <p class="company-location">
            <?php echo htmlspecialchars($entreprise['nom_entreprise']); ?>
            •
            <?php echo htmlspecialchars($entreprise['location']); ?>
        </p>

        <div class="tags-row">

            <span class="pill-tag">
                <?php echo htmlspecialchars($job['type_contrat']); ?>
            </span>

            <span class="pill-tag">
                <?php echo htmlspecialchars($job['categorie']); ?>
            </span>

        </div>

    </div>

    <div class="job-card-footer">
        <a href="utilisateur/apply.php?id=<?php echo $job['id_job']; ?>" class="btn-apply-now">
            Apply Now
        </a>
    </div>

</div>

<?php endforeach; ?>

</div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-card">
                <h2 class="cta-title">Ready to take the next step?</h2>
                <p class="cta-description">
                    Join thousands of professionals who have found their passion through JobConnect.
                </p>

                <div class="cta-buttons">
                    <a href="register.php" class="btn-cta-primary">Create Account</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>