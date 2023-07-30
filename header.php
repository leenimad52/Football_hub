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
    <title>FOOTBALL HUB</title>
    <link rel="stylesheet" href="css/headerStyle.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="Images/small_logo.png" alt="Logo">
        </div>
        <div class="app-name">
            <h1>FOOTBALL HUB</h1>
        </div>
        <nav>
            <ul>
                <li id="aboutus"><a href="aboutus.html">About Us</a></li>
                <li>
                    <div class="user-profile">
                        <img src="Images/userpic.png" alt="User Picture">
                        <span class="username">
                            <?php
                            if (isset($_SESSION['email'])) {
                                // Display a personalized welcome message
                                echo "<h1>".$_SESSION['email']."!</h1>";
                            }
                            ?>
                        </span>
                    </div>
                </li>
                <li id="logout">
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
</body>

</html>
