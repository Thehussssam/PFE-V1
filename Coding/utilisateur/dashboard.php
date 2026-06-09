<?php
require_once '../includes/auth_check.php';
requireRole('candidate');

require_once '../config/database.php';

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Count total applied jobs
$stmtApplied = $pdo->prepare("SELECT COUNT(*) FROM candidature WHERE id_user = ?");
$stmtApplied->execute([$userId]);
$appliedCount = $stmtApplied->fetchColumn();

// Count accepted jobs
$stmtAccepted = $pdo->prepare("SELECT COUNT(*) FROM candidature WHERE id_user = ? AND statut = 'acceptee'");
$stmtAccepted->execute([$userId]);
$acceptedCount = $stmtAccepted->fetchColumn();

// Count rejected jobs
$stmtRejected = $pdo->prepare("SELECT COUNT(*) FROM candidature WHERE id_user = ? AND statut = 'refusee'");
$stmtRejected->execute([$userId]);
$rejectedCount = $stmtRejected->fetchColumn();

// Count pending jobs
$stmtPending = $pdo->prepare("
    SELECT COUNT(*)
    FROM candidature
    WHERE id_user = ? AND statut = 'en_attente'
");
$stmtPending->execute([$userId]);
$pendingCount = $stmtPending->fetchColumn();

// Fetch recent applications for the table
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
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
</head>
<body>

<div class="dashboard-layout">

    <!-- SIDEBAR -->
    <?php include '../templates/sidebar.php'; ?>

    <!-- CONTENT -->
    <main class="dashboard-content">

        <!-- HEADER -->
        <header class="dashboard-header">
            <h1>Welcome back, <?php echo htmlspecialchars($userName); ?> 👋</h1>
            <p>You can manage your profile and track all your job applications here.</p>
        </header>

        <!-- STATS -->
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

        <!-- MAIN CONTENT -->
        <div class="main-content">

            <!-- TABLE -->
            <section class="applications-section">

                <div class="section-header">
                    <h2>My Applications</h2>
                </div>

                <div class="card">

                    <?php if (!empty($recentApplications)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Company</th>
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
                                        <td><?= date('M d', strtotime($app['date_postulation'])) ?></td>
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
                        <p style="text-align: center; color: #6B7280; padding: 20px 0;">You haven't applied to any jobs yet.</p>
                    <?php endif; ?>

                </div>

            </section>

        </div>

    </main>

</div>

</body>
</html>