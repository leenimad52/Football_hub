<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if( $_SESSION['ISIN'] != "TRUE" ) {
    header("location: registration.php");

}


?>

<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamId = $_POST["teamId"];
    $teamName = $_POST["teamName"];
    $skillLevel = $_POST["skillLevel"];
    $gameDay = $_POST["gameDay"];

    try {
        // Update the team information in the teams table
        $stmt = $conn->prepare("UPDATE teams SET team_name = :team_name, skill_level = :skill_level, game_day = :game_day WHERE id = :team_id");
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