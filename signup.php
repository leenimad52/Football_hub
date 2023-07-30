<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="css/registration.css">
</head>
<body>
    <?php
    $usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm_password"];

        if ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match.";
        }

        // Check if email already exists in the database
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            $emailErr = "Email already exists.";
        }

        if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
            $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $conn->prepare($query);
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);

            header("Location: home.php");
            exit();
        }
    }
    ?>

    <div class="container">
        <div class="signup-section">
            <h2>Create an Account</h2>
            <form action="signup.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <?php if (!empty($usernameErr)) { ?>
                    <div class="error"><?php echo $usernameErr; ?></div>
                <?php } ?>
                <input type="email" name="email" placeholder="Email" required>
                <?php if (!empty($emailErr)) { ?>
                    <div class="error"><?php echo $emailErr; ?></div>
                <?php } ?>
                <input type="password" name="password" placeholder="Password" required>
                <?php if (!empty($passwordErr)) { ?>
                    <div class="error"><?php echo $passwordErr; ?></div>
                <?php } ?>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <?php if (!empty($confirmPasswordErr)) { ?>
                    <div class="error"><?php echo $confirmPasswordErr; ?></div>
                <?php } ?>
                <button type="submit" class="registration-button">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
