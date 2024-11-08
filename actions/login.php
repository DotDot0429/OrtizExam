<?php
session_start();
include_once '../core/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $username = $_POST['username'];
     $password = $_POST['password'];

     $database = new Database();
     $db = $database->getConnection();

     // Fetch the user record by username
     $query = "SELECT * FROM user WHERE username = :username";
     $stmt = $db->prepare($query);
     $stmt->bindParam(':username', $username);
     $stmt->execute();

     // Check if a user with the provided username exists
     if ($stmt->rowCount() == 1) {
          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          // Verify the provided password against the hashed password
          if (password_verify($password, $user['password'])) {
               $_SESSION['username'] = $user['username'];
               header("Location: index.php"); // Redirect to main page
               exit();
          } else {
               echo "<p>Invalid username or password.</p>";
          }
     } else {
          echo "<p>Invalid username or password.</p>";
     }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        p {
            margin-top: 15px;
        }

        a {
            color: #2e7d32;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Create one here</a>.</p>
    </div>
</body>
</html>

