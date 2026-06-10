<?php
require_once '../includes/auth_check.php';
requireRole('admin');

require_once '../config/database.php';

if (isset($_GET['email']) && isset($_GET['type'])) {
    $email = $_GET['email'];
    $type = $_GET['type'];

    if ($type === 'User') {
        // Delete applications first
        $sql1 = "DELETE FROM candidature WHERE id_user = (SELECT id_user FROM utilisateur WHERE email = ?)";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([$email]);

        // Delete user account
        $sql2 = "DELETE FROM utilisateur WHERE email = ?";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$email]);

        // DELETE COMPANY
    } elseif ($type === 'Company') {
        // Delete applications linked to company jobs
        $sql1 = "DELETE FROM candidature WHERE id_job IN (SELECT id_job FROM jobs WHERE id_entreprise = (SELECT id_entreprise FROM entreprise WHERE email = ?))";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([$email]);

        // Delete company jobs
        $sql2 = "DELETE FROM jobs WHERE id_entreprise = (SELECT id_entreprise FROM entreprise WHERE email = ?)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$email]);

        // Delete company account
        $sql3 = "DELETE FROM entreprise WHERE email = ?";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute([$email]);
    }
}

header("Location: ../admin/users.php"); 
exit();