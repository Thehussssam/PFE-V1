<?php

require_once __DIR__ . '/session.php';

/* =====================
   CHECK LOGIN ONLY
===================== */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit;
    }
}

/* =====================
   CHECK ROLE
===================== */
function requireRole($role) {

    requireLogin();

    $currentRole = getUserRole();

    if ($currentRole !== $role) {

        // Redirect based on actual role
        switch ($currentRole) {

            case 'admin':
                header('Location: /admin/dashboard.php');
                break;

            case 'company':
                header('Location: /entreprise/dashboard.php');
                break;

            default:
                header('Location: /index.php');
                break;
        }

        exit;
    }
}