<?php

require_once '../config/database.php';
require_once '../includes/auth_check.php';

requireRole('candidate');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// get form data
$prenom = trim($_POST['prenom']);
$nom = trim($_POST['nom']);
$email = trim($_POST['email']);
$telephone = trim($_POST['telephone']);
$bio = trim($_POST['bio']);

// update query
$stmt = $pdo->prepare("
    UPDATE utilisateur
    SET
        prenom = ?,
        nom = ?,
        email = ?,
        telephone = ?,
        bio = ?
    WHERE id_user = ?
");

$stmt->execute([
    $prenom,
    $nom,
    $email,
    $telephone,
    $bio,
    $userId
]);

// update session name (important)
$_SESSION['user_name'] = $prenom;

// redirect back to profile
header("Location: ../utilisateur/profile.php");
exit;