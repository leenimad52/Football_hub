<?php
session_start(); // Start the session if it hasn't been started already
unset($_SESSION['ISIN']);
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

header("Location: index.html"); // Redirect to the homepage or any other desired page
exit();
?>
