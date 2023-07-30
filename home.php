
<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if( $_SESSION['ISIN'] != "TRUE" ) {
    header("location: ./registration.php");

}

?>

<link rel="stylesheet" href="css/test.css">

<div class="container">
    <header> <?php include 'header.php'; ?></header>
    <div class="content-container">
        <div class="sidebar"><?php include 'sidebar.php'; ?></div>
      
        <div class="content">
            <?php
            if (isset($_SESSION['email'])) {
                // Display a welcome message
                echo "<h1>Welcome, ".$_SESSION['email']."!</h1>";
            } 
            
            $selectedPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

            //  selected page
            if ($selectedPage === 'create') {
                include 'createTeam.php';
            } elseif ($selectedPage === 'edit') {
                include 'editTeam2.php';
            } else {
                include 'content.php'; // Default file
            }
            ?>
        </div>
    </div>
    <footer><?php include 'footer1.php'; ?></footer>
</div>
