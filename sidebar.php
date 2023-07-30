<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if( $_SESSION['ISIN'] != "TRUE" ) {
    header("location: registration.php");

}


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/sidebar.css">
</head>
<body>
    <div class="container">
        <aside class="navigationLeft">
            <ul>
                <li><a href="home.php?page=dashboard">Dashboard</a></li>
                <br>
                <li><a href="home.php?page=create">Create New Team</a></li>
                <br>
                <li><a href="home.php?page=edit">Edit Team </a></li>
                <br>
            </ul>
        </aside>
        
    </div>
</body>
</html>
