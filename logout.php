<?php
// Start a new session or resume the existing one
session_start();

// Unset all the session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header('Location: login.php');

// Terminate the current script
exit();
?>