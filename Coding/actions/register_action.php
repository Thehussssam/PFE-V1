<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../register.php");
    exit;
}

//GET FORM DATA
$prenom = trim($_POST['prenom'] ?? '');
$nom = trim($_POST['nom'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

//VALIDATION
if ($prenom === '' || $nom === '' || $email === '' || $password === '') {
    $_SESSION['register_error'] = "All fields are required";
    header("Location: ../register.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = "Invalid email format";
    header("Location: ../register.php");
    exit;
}

//DETECT USER TYPE BY EMAIL
$emailLower = strtolower($email);

if (str_ends_with($emailLower, '@gmail.com')) {

    $table = "utilisateur";

} elseif (str_ends_with($emailLower, '@company.com')) {

    $table = "entreprise";

} else {

    $_SESSION['register_error'] = "Use @gmail.com or @company.com only";
    header("Location: ../register.php");
    exit;
}

//CHECK IF EMAIL EXISTS
$check = $pdo->prepare("SELECT 1 FROM $table WHERE email = ?");
$check->execute([$email]);

if ($check->fetch()) {
    $_SESSION['register_error'] = "Email already exists";
    header("Location: ../register.php");
    exit;
}

//HASH PASSWORD
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

//INSERT USER / COMPANY

if ($table === "utilisateur") {

    $stmt = $pdo->prepare("
        INSERT INTO utilisateur (prenom, nom, email, mot_de_passe)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $prenom,
        $nom,
        $email,
        $hashedPassword
    ]);

} else {

    $stmt = $pdo->prepare("
        INSERT INTO entreprise (nom_entreprise, email, mot_de_passe)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $nom,
        $email,
        $hashedPassword
    ]);
}

//SUCCESS
$_SESSION['register_success'] = "Account created successfully";
header("Location: ../login.php");
exit;
?>