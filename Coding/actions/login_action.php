<?php

session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit;
}

//GET DATA
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    $_SESSION['login_error'] = "All fields are required";
    header("Location: ../login.php");
    exit;
}

$emailLower = strtolower($email);

//ADMIN LOGIN (HARD CODED)
if (
    $emailLower === 'hussam@admin.com' &&
    $password === 'admin123'
) {
    $_SESSION['user_email'] = $email;
    $_SESSION['user_id'] = 0;
    $_SESSION['user_name'] = 'Hussam';

    header("Location: ../admin/dashboard.php");
    exit;
}

//DETECT ACCOUNT TYPE
if (str_ends_with($emailLower, '@gmail.com')) {
    $table = "utilisateur";
} elseif (str_ends_with($emailLower, '@company.com')) {
    $table = "entreprise";
} else {
    $_SESSION['login_error'] = "Use @gmail.com or @company.com";
    header("Location: ../login.php");
    exit;
}

//GET USER FROM DB
$stmt = $pdo->prepare("SELECT * FROM $table WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['login_error'] = "Account not found";
    header("Location: ../login.php");
    exit;
}

//VERIFY PASSWORD
if (!password_verify($password, $user['mot_de_passe'])) {
    $_SESSION['login_error'] = "Wrong password";
    header("Location: ../login.php");
    exit;
}

//CREATE SESSION (CLEAN)
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_id'] = ($table === "utilisateur")
    ? $user['id_user']
    : $user['id_entreprise'];
$_SESSION['user_name'] = ($table === "utilisateur")
    ? $user['prenom']
    : $user['nom_entreprise'];

//REDIRECT
if ($table === "utilisateur") {
    header("Location: ../index.php");
} else {
    header("Location: ../entreprise/dashboard.php");
}

exit;
?>