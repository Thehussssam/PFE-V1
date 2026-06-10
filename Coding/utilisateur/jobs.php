<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<?php
require '../config/database.php';

$user_id = $_SESSION['user_id'] ?? null;

/* =========================
   FUNCTION: already applied
========================= */
function hasAlreadyApplied($pdo, $user_id, $job_id) {
    if (!$user_id) return false;

    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM candidature 
        WHERE id_user = ? AND id_job = ?
    ");

    $stmt->execute([$user_id, $job_id]);

    return $stmt->fetchColumn() > 0;
}

/* =========================
   GET JOBS
========================= */
$stmt = $pdo->query("
    SELECT * 
    FROM jobs 
    WHERE statut = 'ouverte' 
    ORDER BY date_publication DESC
");

$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="jobs-page-wrapper">
    <div class="jobs-page-container">

        <div class="jobs-main">

            <div class="jobs-results-header">
                <div class="results-info">
                    <h2>
                        <span><?= count($jobs) ?></span> Available Jobs
                    </h2>
                    <p>Showing the most relevant opportunities in your area.</p>
                </div>
            </div>

            <div class="jobs-list" id="jobsList">

                <?php if (!empty($jobs)): ?>

                    <?php foreach ($jobs as $job): ?>

                        <?php
                        // company info
                        $companyStmt = $pdo->prepare("
                            SELECT nom_entreprise 
                            FROM entreprise 
                            WHERE id_entreprise = ?
                        ");
                        $companyStmt->execute([$job['id_entreprise']]);
                        $company = $companyStmt->fetch(PDO::FETCH_ASSOC);

                        // check already applied
                        $alreadyApplied = hasAlreadyApplied($pdo, $user_id, $job['id_job']);
                        ?>

                        <div class="job-list-card">

                            <div class="job-list-info">

                                <div class="job-list-title-row">
                                    <h3 class="job-list-title">
                                        <?= htmlspecialchars($job['titre']) ?>
                                    </h3>
                                </div>

                                <div class="job-list-meta">
                                    <span class="job-list-company">
                                        <?= htmlspecialchars($company['nom_entreprise'] ?? 'Unknown Company') ?>
                                    </span>
                                </div>

                                <div class="job-list-tags">

                                    <span class="job-list-tag tag-blue">
                                        <?= htmlspecialchars($job['location']) ?>
                                    </span>

                                    <span class="job-list-tag">
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

                            <!-- ACTIONS (same UX as before) -->
                            <div class="job-list-actions">

                                <?php if ($user_id): ?>

                                    <?php if ($alreadyApplied): ?>

                                        <button class="btn-applied" disabled>
                                            Applied Before
                                        </button>

                                    <?php else: ?>

                                        <a href="apply.php?id=<?= $job['id_job']; ?>" class="btn-apply-now">
                                            Apply Now
                                        </a>

                                    <?php endif; ?>

                                <?php else: ?>

                                    <a href="../login.php" class="btn-apply-now">
                                        Apply Now
                                    </a>

                                <?php endif; ?>

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