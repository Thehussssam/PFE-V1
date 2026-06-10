<?php
require_once '../includes/auth_check.php';
requireRole('company');
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
$lettre = "";

// get motivation letter
if ($id) {
    $sql = "SELECT lettre_motivation FROM candidature WHERE id_candidature = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $lettre = $data['lettre_motivation'] ?? "";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Statut</title>
    <link rel="stylesheet" href="../assets/css/style_status.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="page-wrapper">

        <?php if (!empty($lettre)): ?>
            <div class="motivation-box">
                <h3>Lettre de motivation</h3>
                <p><?= nl2br(htmlspecialchars($lettre)); ?></p>
            </div>
        <?php endif; ?>

        <form class="status-container" action="../actions/update_status.php" method="POST">

            <input type="hidden" name="id_candidature" value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">

            <header class="status-header">
                <h1>Changer le Statut</h1>
                <p>Mettre à jour l'état de la candidature de l'apprenant.</p>
            </header>

            <div class="select-group">
                <label for="application-status">Nouveau Statut</label>

                <div class="select-wrapper">
                    <select id="application-status" name="status" required>
                        <option value="" disabled selected>Choisir un statut...</option>
                        <option value="acceptee">Acceptée</option>
                        <option value="refusee">Refusée</option>
                    </select>
                </div>
            </div>

            <hr class="divider">

            <footer class="status-footer">
                <button type="submit" class="btn-update">Mettre à jour</button>
            </footer>

        </form>

    </div>

</body>
</html>