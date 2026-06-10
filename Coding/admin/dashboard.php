<?php
require_once '../includes/auth_check.php';
requireRole('admin');

require_once '../config/database.php';

// USERS COUNT
$sqlUsers = "SELECT COUNT(*) AS total_users FROM utilisateur";
$stmtUsers = $pdo->query($sqlUsers);
$totalUsers = $stmtUsers->fetch(PDO::FETCH_ASSOC);

// COMPANIES COUNT
$sqlCompanies = "SELECT COUNT(*) AS total_companies FROM entreprise";
$stmtCompanies = $pdo->query($sqlCompanies);
$totalCompanies = $stmtCompanies->fetch(PDO::FETCH_ASSOC);

// TOTAL ACCOUNTS
$totalAccounts = $totalUsers['total_users'] + $totalCompanies['total_companies'];

// CLOSED JOBS COUNT
$sqlJobsClosed = "SELECT COUNT(*) AS total_closed_jobs FROM jobs WHERE statut = 'fermee'";
$stmtJobsClosed = $pdo->query($sqlJobsClosed);
$totalClosedJobs = $stmtJobsClosed->fetch(PDO::FETCH_ASSOC);

// TOTAL JOBS COUNT
$sqlJobs = "SELECT COUNT(*) AS total_jobs FROM jobs";
$stmtJobs = $pdo->query($sqlJobs);
$totalJobs = $stmtJobs->fetch(PDO::FETCH_ASSOC);

// RECENT USERS (UNION)
$sqlRecentUsers = "
        (SELECT CONCAT(prenom, ' ', nom) AS nom, 'User' AS type, date_creation FROM utilisateur)
        UNION ALL
        (SELECT nom_entreprise AS nom, 'Company' AS type, date_creation FROM entreprise)
        ORDER BY date_creation DESC
        LIMIT 3";
$stmtRecentUsers = $pdo->query($sqlRecentUsers);
$recentUsers = $stmtRecentUsers->fetchAll(PDO::FETCH_ASSOC);

// CLOSED JOBS LIST
$sqlClosedJobs = "SELECT j.id_job, j.titre, j.categorie, j.location, j.date_publication, j.statut, 
                e.nom_entreprise FROM jobs j
                INNER JOIN entreprise e
                ON j.id_entreprise = e.id_entreprise WHERE j.statut = 'fermee'
                ORDER BY j.date_publication DESC";
$stmtClosedJobs = $pdo->prepare($sqlClosedJobs);
$stmtClosedJobs->execute();

$closedJobs = $stmtClosedJobs->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - JobConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            <p>Here's an overview of the platform activity today.</p>
        </header>


        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Total Users</span>
                    <span class="metric-value"><?= (int) $totalAccounts; ?></span>
                </div>
                <div class="metric-icon blue-bg">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Closed Jobs</span>
                    <span class="metric-value"><?= (int) $totalClosedJobs['total_closed_jobs']; ?></span>
                </div>
                <div class="metric-icon green-bg">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-info">
                    <span class="metric-title">Total Job Postings</span>
                    <span class="metric-value"><?= (int) $totalJobs['total_jobs']; ?></span>
                </div>
                <div class="metric-icon purple-bg">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
            </div>
        </div>

        <div class="main-content">

            <section class="jobs-section">
                <div class="section-header">
                    <h2>Recent Users</h2>
                    <a href="users.php">View All Users</a>
                </div>

                <div class="card">
                    <?php if (!empty($recentUsers)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentUsers as $user): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($user['nom']) ?></strong></td>
                                        <td>
                                            <?php if ($user['type'] === 'Company'): ?>
                                                <span class="status pending">Company</span>
                                            <?php else: ?>
                                                <span class="status accepted">User</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p style="text-align: center; color: #6b7280; padding: 20px 0;">No users found.</p>
                    <?php endif; ?>
                </div>
            </section>

            <section class="applicants-section pending-jobs">

                <div class="pending-jobs-header">
                    <h2>Pending Job Postings</h2>
                </div>

                <div class="pending-jobs-body">
                    <table class="pending-jobs-table">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Date Posted</th>
                                <th>Status</th>
                                <th class="col-actions-head">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($closedJobs as $job): ?>

                        <tr>

                            <td class="col-job">
                                <div class="job-title">
                                    <?= htmlspecialchars($job['titre']); ?>
                                </div>

                                <div class="job-meta">
                                    <?= htmlspecialchars($job['categorie']); ?>
                                    •
                                    <?= htmlspecialchars($job['location']); ?>
                                </div>
                            </td>

                            <td class="col-company">
                                <span>
                                    <?= htmlspecialchars($job['nom_entreprise']); ?>
                                </span>
                            </td>

                            <td class="col-date">
                                <?= htmlspecialchars($job['date_publication']); ?>
                            </td>

                            <td class="col-status">
                                <span class="job-status-badge">
                                    <?= htmlspecialchars($job['statut']); ?>
                                </span>
                            </td>

                            <td class="col-actions">
                                <a href="../actions/change_status_action.php?action=approve&id=<?= $job['id_job']; ?>" class="action-approve">
                                    Approve
                                </a>

                                <a href="../actions/change_status_action.php?action=reject&id=<?= $job['id_job']; ?>" class="action-reject">
                                    Reject
                                </a>
                            </td>

                        </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

            </section>

        </div>

    </main>

</div>

</body>
</html>