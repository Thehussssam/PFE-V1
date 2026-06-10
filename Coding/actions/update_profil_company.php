<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth_check.php';

requireRole('company');

// Check POST data
if (!isset($_POST['nom_entreprise'], $_POST['location'], $_POST['description'])) {
    die("Missing data");
}

// Get session company ID
$idEntreprise = $_SESSION['user_id'];

// Get form data
$nom_entreprise = trim($_POST['nom_entreprise']);
$location = trim($_POST['location']);
$description = trim($_POST['description']);

// Update query
$sql = "UPDATE entreprise 
        SET nom_entreprise = ?, 
            location = ?, 
            description = ?
        WHERE id_entreprise = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $nom_entreprise,
    $location,
    $description,
    $idEntreprise
]);

// Redirect back to profile
header("Location: ../entreprise/profile.php?updated=1");
exit;
?>