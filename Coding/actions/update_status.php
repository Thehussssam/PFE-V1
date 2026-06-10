<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth_check.php';

requireRole('company');

if (!isset($_POST['id_candidature'], $_POST['status'])) {
    die("Invalid request");
}

$id = $_POST['id_candidature'];
$status = $_POST['status'];

// Validate allowed status values
$allowed_status = ['en_attente', 'acceptee', 'refusee'];

if (!in_array($status, $allowed_status)) {
    die("Invalid status value");
}

// UPDATE database
$sql = "UPDATE candidature 
        SET statut = ? 
        WHERE id_candidature = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$status, $id]);

header("Location: ../entreprise/dashboard.php?success=1");
exit;
?>