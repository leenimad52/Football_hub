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
        <?php
        include "db.php";

        if (isset($_GET['id'])) {
            $teamId = $_GET['id'];

            $stmt = $conn->prepare("SELECT * FROM teams WHERE id = :team_id");
            $stmt->bindParam(':team_id', $teamId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {// Check if the team exists

                $team = $stmt->fetch(PDO::FETCH_ASSOC);

                // Display team information for all users
                echo "<h2>".$team['team_name']."</h2>";
                echo "<p>Skill Level: ".$team['skill_level']."</p>";
                echo "<p>Game Day: ".$team['game_day']."</p>";
                echo "<hr>";

                // Retrieve players from the database based on the team name
                $stmt = $conn->prepare("SELECT * FROM players WHERE team_name = :team_name");
                $stmt->bindParam(':team_name', $team['team_name']);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "<h3>Players</h3>";
                    echo "<ul>";
                    while ($player = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>".$player['player_name']."</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No players found for this team.</p>";
                }

                // Check if the team has the maximum number of players (9)
                if ($stmt->rowCount() >= 9) {
                    echo "<p>The team is full.</p>";
                } else {
                    // Check if the user is authenticated and has the matching email in the teams table
                    // session_start();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    if (isset($_SESSION['email']) && $_SESSION['email'] == $team['email']) {
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
                                $stmt = $conn->prepare("INSERT INTO players (player_name, team_name) VALUES (:player_name, :team_name)");
                                $stmt->bindParam(':player_name', $playerName);
                                $stmt->bindParam(':team_name', $team['team_name']);

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
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                }
            } else {
                echo "Team not found.";
            }
        } else {
            // Fetch teams data from the database
           // $query = "SELECT teams.*, COUNT(players.id) AS player_count FROM teams LEFT JOIN players ON teams.team_name = players.team_name GROUP BY teams.id";
             $query = "SELECT teams.*, COUNT(players.id) AS player_count FROM teams  JOIN players ON teams.team_name = players.team_name GROUP BY teams.id";
             $result = $conn->query($query);

            // Check if there are any teams
            if ($result->rowCount() > 0) {
                // Iterate through each team and display the data in the table
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Team Name</th>";
                echo "<th>Skill Level</th>";
                echo "<th>Game Day</th>";
                echo "<th>Number of Players</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td><a href='?id=".$row['id']."'>".$row['team_name']."</a></td>";
                    echo "<td>".$row['skill_level']."</td>";
                    echo "<td>".$row['game_day']."</td>";
                    echo "<td>".$row['player_count']."</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No teams found.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
