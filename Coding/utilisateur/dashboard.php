<?php

// auth check (candidate only)
require_once '../includes/auth_check.php';
requireRole('candidate');

// db connection
require_once '../config/database.php';

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// count applied jobs
$stmtApplied = $pdo->prepare("SELECT COUNT(*) FROM candidature WHERE id_user = ?");
$stmtApplied->execute([$userId]);
$appliedCount = $stmtApplied->fetchColumn();

// count accepted jobs
$stmtAccepted = $pdo->prepare("SELECT COUNT(*) FROM candidature WHERE id_user = ? AND statut = 'acceptee'");
$stmtAccepted->execute([$userId]);
$acceptedCount = $stmtAccepted->fetchColumn();

// count rejected jobs
$stmtRejected = $pdo->prepare("SELECT COUNT(*) FROM candidature WHERE id_user = ? AND statut = 'refusee'");
$stmtRejected->execute([$userId]);
$rejectedCount = $stmtRejected->fetchColumn();

// count pending jobs
$stmtPending = $pdo->prepare("SELECT COUNT(*) FROM candidature WHERE id_user = ? AND statut = 'en_attente'");
$stmtPending->execute([$userId]);
$pendingCount = $stmtPending->fetchColumn();

// recent applications
$stmtRecent = $pdo->prepare("
    SELECT c.*, j.titre
    FROM candidature c
    JOIN jobs j ON c.id_job = j.id_job
    WHERE c.id_user = ?
    ORDER BY c.date_postulation DESC
");
$stmtRecent->execute([$userId]);
$recentApplications = $stmtRecent->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Dashboard - JobConnect</title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- styles -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
</head>

<body>

<div class="dashboard-layout">

    <!-- sidebar -->
    <?php include '../templates/sidebar.php'; ?>

    <!-- content -->
    <main class="dashboard-content">

        <!-- header -->
        <header class="dashboard-header">
            <h1>Welcome back, <?= htmlspecialchars($userName); ?></h1>
            <p>You can manage your profile and track all your job applications.</p>
        </header>

        <!-- stats -->
        <section class="stats-cards">

            <div class="card">
                <div class="card-icon"><i class="fa-solid fa-paper-plane" style="color: #0f62fe;"></i></div>
                <div class="card-title">Applied Jobs</div>
                <div class="card-value"><?= $appliedCount ?></div>
            </div>

            <div class="card">
                <div class="card-icon"><i class="fa-solid fa-circle-check" style="color: #00876a;"></i></div>
                <div class="card-title">Accepted Jobs</div>
                <div class="card-value"><?= $acceptedCount ?></div>
            </div>

            <div class="card">
                <div class="card-icon"><i class="fa-solid fa-circle-xmark" style="color: #ff5630;"></i></div>
                <div class="card-title">Rejected Jobs</div>
                <div class="card-value"><?= $rejectedCount ?></div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fa-solid fa-hourglass-half" style="color: #f59e0b;"></i>
                </div>
                <div class="card-title">Pending Jobs</div>
                <div class="card-value"><?= $pendingCount ?></div>
            </div>

        </section>

        <!-- main -->
        <div class="main-content">

            <!-- applications -->
            <section class="applications-section">

                <div class="section-header">
                    <h2>My Applications</h2>
                </div>

                <div class="card">

                    <?php if (!empty($recentApplications)): ?>
                        <table>

                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach ($recentApplications as $app): ?>
                                    <tr>

                                        <td>
                                            <strong><?= htmlspecialchars($app['titre']) ?></strong>
                                        </td>

                                        <td>
                                            <?= date('M d', strtotime($app['date_postulation'])) ?>
                                        </td>

                                        <td>
                                            <?php if ($app['statut'] === 'acceptee'): ?>
                                                <span class="status accepted">Accepted</span>

                                            <?php elseif ($app['statut'] === 'en_attente'): ?>
                                                <span class="status pending">Pending</span>

                                            <?php else: ?>
                                                <span class="status rejected">Rejected</span>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>

                            </tbody>

                        </table>
                    <?php else: ?>
                        <p style="text-align:center; color:#6B7280; padding:20px 0;">
                            You haven't applied to any jobs yet.
                        </p>
                    <?php endif; ?>

                </div>

            </section>

        </div>

    </main>

</div>

</body>
</html>