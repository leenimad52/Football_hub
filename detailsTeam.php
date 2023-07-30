<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if( $_SESSION['ISIN'] != "TRUE" ) {
    header("location: registration.php");

}


?>

<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Team Details</title>
    <link rel="stylesheet" type="text/css" href="css/detailsTeam.css">
    
</head>
<body>
    <div class="container">
        <h1>Team Details</h1>
        <div class="team-info">
            <?php
            include "db.php";

            // Check if the team ID is provided in the URL
            if (isset($_GET['id'])) {
                $teamId = $_GET['id'];

                // Retrieve team details from the database based on the team ID
                $stmt = $conn->prepare("SELECT * FROM teams WHERE id = :team_id");
                $stmt->bindParam(':team_id', $teamId);
                $stmt->execute();

                // Check if the team exists
                if ($stmt->rowCount() > 0) {
                    $team = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<h2>".$team['team_name']."</h2>";
                    echo "<p>Skill Level: ".$team['skill_level']."</p>";
                    echo "<p>Game Day: ".$team['game_day']."</p>";
                    echo "<hr>";
                  

                    // Retrieve players from the database based on the team name
                    $stmt = $conn->prepare("SELECT * FROM players WHERE team_name = :team_name");
                    $stmt->bindParam(':team_name', $team['team_name']);
                    $stmt->execute();

                    echo "<h3>Players</h3>";
                    echo "<ul>";
                    while ($player = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>".$player['name']."</li>";
                    }
                    echo "</ul>";

                    // Check if the team has reached the maximum number of players (9)
                    if ($stmt->rowCount() >= 9) {
                        echo "<p>The team is already full. You cannot add more players.</p>";
                    } else {
                        // Display the add player form
                        echo "<hr>";
                        echo "<div class='add-player-form'>";
                        echo "<h3>Add New Player</h3>";
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='teamId' value='".$teamId."'>";
                        echo "<input type='text' name='playerName' placeholder='Player Name' required>";
                        echo "<button type='submit' class='add-player-button'>Add Player</button>";
                        echo "</form>";
                        echo "</div>";

                        // Process the form submission
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $teamId = $_POST["teamId"];
                            $playerName = $_POST["playerName"];

                            try {
                                // Insert the new player into the players table
                                $stmt = $conn->prepare("INSERT INTO players (player_name, team_name) VALUES (:name, (SELECT name FROM teams WHERE id = :team_id))");
                                $stmt->bindParam(':player_name', $playerName);
                                $stmt->bindParam(':team_id', $teamId);

                                if ($stmt->execute()) {
                                    echo "<p class='success-message'>New player added successfully!</p>";
                                } else {
                                    echo "<p class='error-message'>Error adding player.</p>";
                                }
                            } catch(PDOException $e) {
                                echo "<p class='error-message'>Error: " . $e->getMessage() . "</p>";
                            }
                        }
                    }
                } else {
                    echo "Team not found.";
                }
            } else {
                echo "Invalid team ID.";
            }
            echo "<hr>";
            ?>
        </div>
        <a href="home.php" class="dashboard-link">Back to Dashboard</a>
    </div>
</body>
</html> -->
