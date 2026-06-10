<?php

// start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//login check
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
}

//get user role
function getUserRole() {

    if (!isset($_SESSION['user_email'])) {
        return null;
    }

    $email = strtolower($_SESSION['user_email']);

    if ($email === 'hussam@admin.com') {
        return 'admin';
    }

    if (str_ends_with($email, '@company.com')) {
        return 'company';
    }

    return 'candidate';
}

//role helpers
function isAdmin() {
    return getUserRole() === 'admin';
}

function isCompany() {
    return getUserRole() === 'company';
}

function isCandidate() {
    return getUserRole() === 'candidate';
}

//get email
function getUserEmail() {
    return $_SESSION['user_email'] ?? '';
}