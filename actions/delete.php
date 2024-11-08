<?php
// Include the database and Developer class
include_once '../core/db.php';
include_once '../class/Developer.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$crud = new crud($db);

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Order ID not found.');

$crud->id = $id;

$message = ''; // Initialize the message

if ($crud->delete()) {
    $message = "Order deleted successfully.";
} else {
    $message = "Unable to delete order.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .message {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        a {
            text-decoration: none;
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Display the success or error message -->
        <div class="message <?php echo $crud->delete() ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
        <a href="index.php">Back</a>
    </div>
</body>
</html>

