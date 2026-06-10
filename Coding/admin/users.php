<?php
require_once '../includes/auth_check.php';
requireRole('admin');

require_once '../config/database.php';

// GET ALL USERS + COMPANIES (UNION)
$sqlAllUsers = "
(
    SELECT
        email AS nom,
        'User' AS type,
        date_creation
    FROM utilisateur
)
UNION ALL
(
    SELECT
        email AS nom,
        'Company' AS type,
        date_creation
    FROM entreprise
)
ORDER BY date_creation DESC
";
$stmtAllUsers = $pdo->query($sqlAllUsers);
$allUsers = $stmtAllUsers->fetchAll(PDO::FETCH_ASSOC);

// TOTAL USERS COUNT
$totalCount = count($allUsers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users - JobConnect Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/admin-users.css">
</head>
<body>

<div class="dashboard-layout">


    <main class="dashboard-content all-users-page">

        <header class="dashboard-header">
            <h1>All Users</h1>
            <p><?= (int) $totalCount; ?> registered accounts on the platform.</p>
        </header>

        <div class="main-content">

            <section class="jobs-section">
                <div class="section-header">
                    <h2>Users</h2>
                    <a href="dashboard.php">Back to Dashboard</a>
                </div>

                <div class="card">
                    <?php if (!empty($allUsers)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allUsers as $user): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($user['nom']) ?></strong></td>
                                        <td>
                                            <?php if ($user['type'] === 'Company'): ?>
                                                <span class="status pending">Company</span>
                                            <?php else: ?>
                                                <span class="status accepted">User</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="../actions/delete_user_action.php?email=<?= urlencode($user['nom']); ?>&type=<?= $user['type']; ?>" class="btn-delete-user">
                                                <i class="fa-solid fa-trash-can"></i> Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="empty-users-msg">No users found.</p>
                    <?php endif; ?>
                </div>
            </section>

        </div>

    </main>

</div>

</body>
</html>
