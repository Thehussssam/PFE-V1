<?php
require_once '../includes/auth_check.php';
requireRole('company');

require_once '../config/database.php';

$userId = $_SESSION['user_id'];

// get company data
$stmt = $pdo->prepare("SELECT * FROM entreprise WHERE id_entreprise = ?");
$stmt->execute([$userId]);
$company = $stmt->fetch(PDO::FETCH_ASSOC);

// safety check
if (!$company) {
    die("Company not found or invalid session ID");
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

        <form action="../actions/update_profil_company.php" method="POST">

    <section class="settings-card">
        <h2>Company Information</h2>

        <div class="inputs-grid">

            <div class="form-group full-width">
                <label>Company Name</label>
                <input type="text" name="nom_entreprise" 
                       value="<?= htmlspecialchars($company['nom_entreprise']) ?>">
            </div>

            <div class="form-group full-width">
                <label>Location</label>
                <input type="text" name="location" 
                       value="<?= htmlspecialchars($company['location']) ?>">
            </div>

            <div class="form-group full-width">
                <label>Description</label>
                <textarea name="description" rows="5"><?= htmlspecialchars($company['description']) ?></textarea>
            </div>

        </div>
    </section>

    <div class="form-actions">
        <button type="submit" class="btn-save">Save Profile</button>
    </div>

</form>

    </main>

</div>

</body>
</html>