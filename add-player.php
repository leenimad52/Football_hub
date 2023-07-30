
<?php
include "db.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if( $_SESSION['ISIN'] != "TRUE" ) {
    header("location: registration.php");

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamId = $_POST["teamId"];
    $playerName = $_POST["playerName"];

    try {
        // Insert the new player into the players table
        $stmt = $conn->prepare("INSERT INTO players (player_name, team_name) VALUES (:player_name, (SELECT team_name FROM teams WHERE id = :team_id))");
        $stmt->bindParam(':player_name', $playerName);
        $stmt->bindParam(':team_id', $teamId);

        if ($stmt->execute()) {
            echo "New player added successfully!";
        } else {
            echo "Error adding player.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?> 
