<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth_check.php';

requireRole('company');

// Check POST data
if (!isset($_POST['titre'], $_POST['categorie'], $_POST['location'], $_POST['type_contrat'], $_POST['description'], $_POST['id_entreprise'])) {
    die("Missing data");
}

// Get data
$titre = trim($_POST['titre']);
$categorie = trim($_POST['categorie']);
$location = trim($_POST['location']);
$type_contrat = trim($_POST['type_contrat']);
$description = trim($_POST['description']);
$id_entreprise = $_POST['id_entreprise'];

// Security: ensure entreprise = session user
if ($id_entreprise != $_SESSION['user_id']) {
    die("Invalid entreprise ID");
}

// Insert into DB
$sql = "INSERT INTO jobs 
        (titre, categorie, location, type_contrat, description, id_entreprise) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $titre,
    $categorie,
    $location,
    $type_contrat,
    $description,
    $id_entreprise
]);

// Redirect to dashboard
header("Location: ../entreprise/dashboard.php?job_created=1");
exit;
?>