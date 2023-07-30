
<!DOCTYPE html>
<html>
<head>
    <title>Login </title>
    <link rel="stylesheet" type="text/css" href="css/registration.css">
    <link rel="stylesheet" type="text/css" href="css/error.css">
</head>
<body>
    <div class="container">
        <div class="login-section">
            <h2>Login</h2>
            <form method="post" action="login.php">
                <input type="email" name="email" placeholder="Email" required>
                <?php if (isset($errorMessage) && !empty($errorMessage) && $errorMessage == "Invalid email or password.") { ?>
                    <span class="error"><?php echo $errorMessage; ?></span>
                <?php } ?>
                <input type="password" name="password" placeholder="Password" required>
                <?php if (isset($errorMessage) && !empty($errorMessage) && $errorMessage == "Invalid email or password.") { ?>
                    <span class="error"><?php echo $errorMessage; ?></span>
                <?php } ?>
                <button type="submit" class="registration-button">Log In</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php

// Include the database connection file
include "db.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted email and password
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        // Execute the query
        $stmt->execute();

        // Check if the query returned any rows
        if ($stmt->rowCount() > 0) {
            session_start();
            // Store the email in the session
            $_SESSION['ISIN'] = "TRUE";
            $_SESSION['email'] = $email;

            // Login successful
            echo "Login successful!";
            header("Location: home.php");
            exit();
        } else {
            // Login failed
            $errorMessage = "Invalid email or password.";
          //  echo $errorMessage ;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>


