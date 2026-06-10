<?php
require_once '../includes/auth_check.php';
requireRole('company');

require_once '../config/database.php';

$idEntreprise = $_SESSION['user_id'];

// total jobs
$sql = "SELECT COUNT(*) AS total_jobs FROM jobs WHERE id_entreprise = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$idEntreprise]);
$totalJobs = $stmt->fetch(PDO::FETCH_ASSOC);

// total applications
$sql2 = "SELECT COUNT(*) AS total_applications
        FROM candidature c
        INNER JOIN jobs j ON c.id_job = j.id_job
        WHERE j.id_entreprise = ?";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([$idEntreprise]);
$totalApplications = $stmt2->fetch(PDO::FETCH_ASSOC);

// accepted applications
$sql3 = "SELECT COUNT(*) AS total_accepted
    FROM candidature c
    INNER JOIN jobs j ON c.id_job = j.id_job
    WHERE j.id_entreprise = ?
    AND c.statut = 'acceptee'";
$stmt3 = $pdo->prepare($sql3);
$stmt3->execute([$idEntreprise]);
$totalAccepted = $stmt3->fetch(PDO::FETCH_ASSOC);

// pending applicants
$sql4 = "SELECT 
        c.id_candidature,
        c.date_postulation,
        u.nom,
        u.prenom,
        j.titre AS job_title
    FROM candidature c
    INNER JOIN utilisateur u ON c.id_user = u.id_user
    INNER JOIN jobs j ON c.id_job = j.id_job
    WHERE j.id_entreprise = ?
    AND c.statut = 'en_attente'
    ORDER BY c.date_postulation DESC";
$stmt4 = $pdo->prepare($sql4);
$stmt4->execute([$idEntreprise]);
$applicants = $stmt4->fetchAll(PDO::FETCH_ASSOC);

// company jobs
$sql5 = "SELECT id_job, titre, type_contrat, location FROM jobs WHERE id_entreprise = ? ORDER BY date_publication DESC";
$stmt5 = $pdo->prepare($sql5);
$stmt5->execute([$idEntreprise]);
$companyJobs = $stmt5->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard - JobConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include '../templates/sidebar.php'; ?>

    <main class="dashboard-content">

        <header class="dashboard-header">
            <h1>Welcome back, <?= htmlspecialchars($_SESSION['user_name']); ?></h1>
            <p>Here's what's happening with your recruitment pipeline.</p>
        </header>

        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Active Job Postings</span>
                    <span class="metric-value"><?= (int) $totalJobs['total_jobs']; ?></span>
                </div>
                <div class="metric-icon blue-bg">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Total Applications</span>
                    <span class="metric-value"><?= (int) ($totalApplications['total_applications'] ?? 0); ?></span>
                </div>
                <div class="metric-icon green-bg">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Accepted Applications</span>
                    <span class="metric-value"><?= (int) ($totalAccepted['total_accepted'] ?? 0); ?></span>
                </div>
                <div class="metric-icon purple-bg">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="main-content">

            <div class="jobs-section">
                
                <div class="manage-jobs-header">
                    <h2>Your Job Postings</h2>
                </div>

                <div class="posted-jobs-list">
                    <?php if (!empty($companyJobs)): ?>
                        <?php foreach ($companyJobs as $job): ?>
                            <div class="job-manage-card">
                                <div class="job-manage-info">
                                    <h4><?= htmlspecialchars($job['titre']); ?></h4>
                                    <div class="job-manage-tags">
                                        <span class="tag-contract"><i class="fa-solid fa-file-contract"></i> <?= htmlspecialchars($job['type_contrat']); ?></span>
                                        <span class="tag-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']); ?></span>
                                    </div>
                                </div>
                                <div class="job-manage-actions">
                                    <a href="../actions/delete_job_action.php?id=<?= (int)$job['id_job']; ?>" class="btn-delete">
                                        <i class="fa-solid fa-trash-can"></i> Supprimer
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-jobs-text">You haven't posted any jobs yet.</p>
                    <?php endif; ?>
                </div>
                <div class="create-job-box">
                    <div class="plus-circle">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <p>Need to hire for a new role?</p>
                    <a href="add_job.php" class="btn-primary">Create Job Requisition</a>
                </div>
            </div>

            <div class="applicants-section">
                <div class="section-header">
                    <h2>Recent Applicants</h2>
                </div>

                <?php if (!empty($applicants)): ?>
                    <?php foreach ($applicants as $app): ?>
                        <div class="applicant-card">
                            <div class="applicant-meta">
                                <h4><?= htmlspecialchars($app['prenom'] . ' ' . $app['nom']); ?></h4>
                                <p>
                                    <?= htmlspecialchars($app['job_title']); ?> • 
                                    <?= date('Y-m-d', strtotime($app['date_postulation'])); ?>
                                </p>
                            </div>
                            <div class="card-actions">
                                <a href="update_statu.php?id=<?= (int) $app['id_candidature']; ?>" class="btn-primary">
                                    Update Status
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #6b7280; padding: 20px 0;">No applicants yet.</p>
                <?php endif; ?>
            </div>

        </div>

    </main>

</div>

</body>
</html>