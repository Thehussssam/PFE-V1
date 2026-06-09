<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<?php
require '../config/database.php';

$stmt = $pdo->query("SELECT * FROM jobs WHERE statut = 'ouverte' ORDER BY date_publication DESC");

$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Jobs Page -->
<main class="jobs-page-wrapper">
    <div class="jobs-page-container">

        <!-- Main Content -->
        <div class="jobs-main">

            <!-- Results Header -->
            <div class="jobs-results-header">
                <div class="results-info">
                    <h2>
                        <span><?= count($jobs) ?></span> Available Jobs
                    </h2>
                    <p>Showing the most relevant opportunities in your area.</p>
                </div>

            </div>

            <!-- Jobs List -->
            <div class="jobs-list" id="jobsList">

                <?php if (!empty($jobs)): ?>

                    <?php foreach ($jobs as $job): ?>

                        <?php
                        $companyStmt = $pdo->prepare("
                            SELECT nom_entreprise
                            FROM entreprise
                            WHERE id_entreprise = ?
                        ");
                        $companyStmt->execute([$job['id_entreprise']]);
                        $company = $companyStmt->fetch(PDO::FETCH_ASSOC);
                        ?>

                        <div class="job-list-card">

                            <div class="job-list-info">

                                <!-- Title -->
                                <div class="job-list-title-row">
                                    <h3 class="job-list-title">
                                        <?= htmlspecialchars($job['titre']) ?>
                                    </h3>
                                </div>

                                <!-- Meta -->
                                <div class="job-list-meta">

                                    <div class="job-list-meta-item">
                                        <span class="job-list-company">
                                            <?= htmlspecialchars($company['nom_entreprise'] ?? 'Unknown Company') ?>
                                        </span>
                                    </div>

                                    <div class="job-list-meta-item">
                                        <span class="job-list-location">
                                            <?= htmlspecialchars($job['location']) ?>
                                        </span>
                                    </div>

                                </div>

                                <!-- Tags -->
                                <div class="job-list-tags">

                                    <span class="job-list-tag tag-blue">
                                        <?= htmlspecialchars($job['type_contrat']) ?>
                                    </span>

                                    <span class="job-list-tag">
                                        <?= htmlspecialchars($job['categorie']) ?>
                                    </span>

                                    <span class="job-list-posted">
                                        <?= date('d/m/Y', strtotime($job['date_publication'])) ?>
                                    </span>

                                </div>

                            </div>

                            <!-- Actions -->
                            <div class="job-list-actions">

                                <a href="apply.php?id=<?php echo $job['id_job']; ?>" class="btn-apply-now">
                                    Apply Now
                                </a>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="job-list-card">
                        <p>No jobs available at the moment.</p>
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>
</main>

<?php include '../includes/footer.php'; ?>