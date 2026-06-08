<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =====================
   CHECK LOGIN
===================== */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
}

/* =====================
   GET ROLE
===================== */
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

/* =====================
   ROLE HELPERS
===================== */
function isAdmin() {
    return getUserRole() === 'admin';
}

function isCompany() {
    return getUserRole() === 'company';
}

function isCandidate() {
    return getUserRole() === 'candidate';
}

/* =====================
   GET EMAIL
===================== */
function getUserEmail() {
    return $_SESSION['user_email'] ?? '';
}