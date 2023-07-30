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
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/content.css">
</head>
<body>
    <div class="container">
        <h1>Welcome!</h1>
        <?php
        // Include the database connection file
        include "db.php";
        
        // Assuming you have the user ID available
        $email ="";
        if (isset($_SESSION['email'])) {
                   // Display a personalized welcome message
                   $email=$_SESSION['email'];
               } 
        
        // Fetch teams data for the specific user from the database
        $query = "SELECT * FROM teams t WHERE t.email = '$email'";
        $stmt = $conn->prepare($query);
       // $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Check if there are any teams for the user
        if ($stmt->rowCount() > 0) {
            // Displaidy the table
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Team Name</th>";
            echo "<th>Skill Level</th>";
            echo "<th>Game Day</th>";
       
            echo "</thead>";
            echo "<tbody>";
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>".$row['team_name']."</td>";
                echo "<td>".$row['skill_level']."</td>";
                echo "<td>".$row['game_day']."</td>";
                echo "<td><a href='editTeam.php?id=".$row['id']."'>Edit</a></td>";

                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No teams found for the user.</p>";
        }
        ?>
    </div>
</body>
</html>
