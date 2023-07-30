
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
    <title>Edit Team</title>
    <link rel="stylesheet" type="text/css" href="css/editTeam.css">
    <header> <?php include 'header.php'; ?></header>
</head>
<body>
    <div class="container">
        <h1>Edit Team</h1>
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
                ?>
                <form method="post" action="update-team.php">
                    <input type="hidden" name="teamId" value="<?php echo $team['id']; ?>">
                    <label for="teamName">Team Name:</label>
                    <input type="text" id="teamName" name="teamName" value="<?php echo $team['team_name']; ?>" required>
                    <label for="skillLevel">Skill Level:</label>
                    <input type="number" id="skillLevel" name="skillLevel" min="1" max="5" value="<?php echo $team['skill_level']; ?>" required>
                    <label for="gameDay">Game Day:</label>
                    <input type="text" id="gameDay" name="gameDay" value="<?php echo $team['game_day']; ?>" required>
                    <button type="submit" class="update-team-button">Update Team</button>
                </form>
                <a href="delete-team.php?id=<?php echo $team['id']; ?>" class="delete-team-link">Delete Team</a>
                <?php
            } else {
                echo "Team not found.";
            }
        } else {
            echo "Invalid team ID.";
        }
        ?>
        <a href="home.php" class="dashboard-link">Back to Dashboard</a>
    </div>
</body>
<footer><?php include 'footer1.php'; ?></footer>

</html>

<?php
// Include the database connection file
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamId = $_POST["teamId"];
    $teamName = $_POST["teamName"];
    $skillLevel = $_POST["skillLevel"];
    $gameDay = $_POST["gameDay"];

    try {
        // Update the team information in the teams table
        $stmt = $conn->prepare("UPDATE teams SET team_name = :name, skill_level = :skill_level, game_day = :game_day WHERE id = :team_id");
        $stmt->bindParam(':team_name', $teamName);
        $stmt->bindParam(':skill_level', $skillLevel);
        $stmt->bindParam(':game_day', $gameDay);
        $stmt->bindParam(':team_id', $teamId);

        if ($stmt->execute()) {
            echo "Team updated successfully!";
        } else {
            echo "Error updating team.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>