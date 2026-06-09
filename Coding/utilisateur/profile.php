<?php
require_once '../includes/auth_check.php';
requireRole('candidate');

require_once '../config/database.php';

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id_user = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Profile</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/profil.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include '../templates/sidebar.php'; ?>

    <main class="dashboard-content">

        <header class="settings-header">
            <h1>Settings</h1>
            <p>Manage your account preferences, profile visibility, and security settings.</p>
        </header>

        <form action="../actions/update_profile.php" method="POST">

            <section class="settings-card">
                <h2>Personal Information</h2>

                <div class="profile-info-grid">

                    <div class="inputs-grid">

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>">
                        </div>

                        <div class="form-group full-width">
                            <label>Email Address</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>">
                        </div>

                    </div>

                </div>
            </section>

            <section class="settings-card">

                <h2>Professional Bio</h2>

                <div class="form-group full-width">
                    <textarea name="bio" rows="4"><?= htmlspecialchars($user['bio']) ?></textarea>
                </div>

                <div class="form-actions">
                    
                    <button type="submit" class="btn-save">
                        Save Profile
                    </button>
                </div>

            </section>

        </form>

    </main>

</div>

</body>
</html>