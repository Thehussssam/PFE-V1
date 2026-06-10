<?php
require_once '../config/database.php';
session_start();

// Protect page (must be logged in)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get form data
    $lettre_motivation = trim($_POST['lettre_motivation'] ?? '');

    // User + job IDs
    $candidate_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 
    $job_id = isset($_POST['job_id']) ? intval($_POST['job_id']) : 1;       

     // Validate input
    if (!empty($lettre_motivation)) {
        
        try {
            // Insert application
            $sql = "INSERT INTO candidature (id_user, id_job, lettre_motivation, statut, date_postulation)
            VALUES(?,?,?,'en_attente',NOW())";
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
            $candidate_id,
            $job_id,
            $lettre_motivation
            ]);

            // Success redirect
            header('Location: ../utilisateur/jobs.php');
            exit();

        } catch (PDOException $e) {
            echo "Erreur lors de l'enregistrement: " . $e->getMessage();
        }

    } else {
                $_SESSION['apply_error'] = "La lettre de motivation ne peut pas être vide !";
                
                header('Location: ../utilisateur/jobs.php');
                exit();
            }
} else {
    header('Location: ../index.php');
    exit();
}
?>