
<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if( $_SESSION['ISIN'] != "TRUE" ) {
    header("location: ./registration.php");

}

?>

<?php
// Include the database connection file
include "db.php";

// Check if the team ID is provided in the URL
if (isset($_GET['id'])) {
    $teamId = $_GET['id'];

    try {
        // Delete the team from the teams table
        $stmt = $conn->prepare("DELETE FROM teams WHERE id = :team_id");
        $stmt->bindParam(':team_id', $teamId);

        if ($stmt->execute()) {
            echo "Team deleted successfully!";
            header("Location: home.php"); // Redirect to the home after deleting the team
            exit();
        } else {
            echo "Error deleting team.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid team ID.";
}
?>
