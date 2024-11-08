<?php
include_once '../core/db.php';

$error_message = ''; // Initialize the error message variable
$success_message = ''; // Initialize the success message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate that password and confirm password match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match. Please try again."; // Store the error message
    } else {
        $database = new Database();
        $db = $database->getConnection();

        // Check if username already exists
        $query = "SELECT * FROM user WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error_message = "Username already exists. Please choose a different username."; // Store the error message
        } else {
            // Insert the new user with hashed password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO user (username, password) VALUES (:username, :password)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);

            if ($stmt->execute()) {
                // Success: store the success message
                $success_message = "Account created successfully! <a href='login.php'>Login here</a>.";
            } else {
                $error_message = "Unable to create account. Please try again later."; // Store the error message
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f5e9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 300px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #4caf50;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #2e7d32;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #2e7d32;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #4caf50;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #388e3c;
        }

        .message {
            margin-top: 15px;
            font-size: 0.9em;
            text-align: center; /* Center the message */
            width: 100%; /* Ensure it spans full width of container */
            display: block; /* Ensure it's treated as a block element */
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        <form method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" value="Register">

            <!-- Success or Error message positioned below the register button -->
            <div class="message">
                <?php
                // Display success message if it's set
                if (!empty($success_message)) {
                    echo "<p class='success-message'>$success_message</p>";
                }

                // Display error message if it's set
                if (!empty($error_message)) {
                    echo "<p class='error-message'>$error_message</p>";
                }
                ?>
            </div>
        </form>
    </div>
</body>
</html>
