<?php

// session helpers
require_once __DIR__ . '/session.php';

//check login
function requireLogin() {

    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit;
    }

}

//check role
function requireRole($role) {

    requireLogin();

    $currentRole = getUserRole();

    if ($currentRole !== $role) {

        // redirect by role
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