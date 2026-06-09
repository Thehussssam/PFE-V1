<?php

require_once '../includes/auth_check.php';
requireRole('candidate');

$idJob = $_GET['id'] ?? 0;

if (!$idJob) {
    header("Location: ../utilisateur/jobs.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lettre de Motivation</title>
    <link rel="stylesheet" href="../assets/css/test1.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <form class="form-container" action="../actions/apply_action.php" method="POST">
        <input type="hidden" name="job_id" value="<?= $idJob ?>">
        
        <header class="form-header">
            <div class="header-text">
                <h1>Lettre de Motivation</h1>
                <p>Dites-nous ce qui fait de vous le candidat idéal pour ce poste.</p>
            </div>
        </header>

        <div class="input-section">
            <label for="motivation-message">Votre Message</label>
            <div class="textarea-wrapper">
                <textarea 
                    id="motivation-message" 
                    name="lettre_motivation" 
                    placeholder="Bonjour l'équipe CloudScale Innovations, je suis passionné par..."
                    maxlength="2000" 
                    required></textarea>
            </div>
        </div>

        <hr class="divider">

        <footer class="form-footer">
            <button type="submit" class="btn-apply">Apply</button>
        </footer>

    </form>

</body>
</html>