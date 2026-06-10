<?php
// delete_job_action.php
require_once '../includes/auth_check.php';
requireRole('company');
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $idJob = (int)$_GET['id'];
    $idEntreprise = $_SESSION['user_id'];

    $sql = "DELETE FROM jobs WHERE id_job = ? AND id_entreprise = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idJob, $idEntreprise]);
}

header("Location: ../entreprise/dashboard.php");
exit();