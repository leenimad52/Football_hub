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
    <title>Create New Team</title>
    <link rel="stylesheet" type="text/css" href="css/createTeam.css"> 
</head>
<body>
    <div class="container">
        <h1>Create New Team</h1>
        <?php
        // session_start();
        if (isset($_SESSION['email'])) {
            // Display the create team form for authenticated users
            echo '
            <form method="post">
                <label for="teamName">Team Name:</label>
                <input type="text" id="teamName" name="teamName" required>
                <label for="skillLevel">Skill Level:</label>
                <input type="number" id="skillLevel" name="skillLevel" min="1" max="5" required>
                <label for="gameDay">Game Day:</label>
                <input type="text" id="gameDay" name="gameDay" required>
                <button type="submit" class="create-team-button">Create Team</button>
            </form>';
        } else {
            // Display a message for non-authenticated users
            echo '<p>Please login or sign up to create a new team.</p>';
        }
        ?>
    </div>
</body>
</html>
<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['email'])) {
    $teamName = $_POST["teamName"];
    $skillLevel = $_POST["skillLevel"];
    $gameDay = $_POST["gameDay"];
    $email = $_SESSION["email"];

    try {
        $stmt = $conn->prepare("INSERT INTO teams (team_name, skill_level, email, game_day) VALUES (:team_name, :skill_level, :email, :game_day)");
        $stmt->bindParam(':team_name', $teamName);
        $stmt->bindParam(':skill_level', $skillLevel);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':game_day', $gameDay);

        if ($stmt->execute()) {
            echo "Team created successfully!";
        } else {
            echo "Error creating team.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
