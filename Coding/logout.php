<?php
// start session
session_start();

// clear all session data
session_unset();

// destroy session completely (logout user)
session_destroy();

// redirect to homepage
header('Location: index.php');
exit;
?>