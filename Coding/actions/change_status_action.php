<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
session_start();

requireRole('admin');

if (!isset($_GET['id'], $_GET['action'])) {
    die("Invalid request");
}

$idJob = $_GET['id'];
$action = $_GET['action'];

if ($action === 'approve') {

    // approve → job becomes visible
    $sql = "UPDATE jobs SET statut = 'ouverte' WHERE id_job = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idJob]);

} elseif ($action === 'reject') {

    // reject → delete job completely
    $sql = "DELETE FROM jobs WHERE id_job = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idJob]);

} else {
    die("Invalid action");
}

header("Location: ../admin/dashboard.php?success=1");
exit;
?>