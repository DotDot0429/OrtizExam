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
$stmt1 = $crud->read("providers", "provider_id");

if ($_POST) {
     // Set values for new fields
     $crud->customerName = htmlspecialchars(strip_tags($_POST['customerName']));
     $crud->order = htmlspecialchars(strip_tags($_POST['order']));
     $crud->payment = htmlspecialchars(strip_tags($_POST['payment']));
     $crud->appointDate = htmlspecialchars(strip_tags($_POST['appointDate']));

     if ($crud->create()) {
          echo "<div>Order created.</div>";
     } else {
          echo "<div>Unable to create an Order.</div>";
     }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            text-align: center;
            color: #2d6a4f;
        }
        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        label, input, select {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
        input[type="text"], select, input[type="date"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #2d6a4f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #1b4332;
        }
        a {
            color: #2d6a4f;
            text-align: center;
            display: block;
            margin-top: 20px;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #2d6a4f;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h2>Vital Eats Menu</h2>
    <table>
        <tr>
            <th>Menu Item</th>
            <th>Options</th>
            <th>Price (PHP)</th>
        </tr>
        <tr><td>Salad Bowls</td><td>Chicken Salad</td><td>300</td></tr>
        <tr><td>Salad Bowls</td><td>Tofu Salad</td><td>250</td></tr>
        <tr><td>Smoothie Bowls</td><td>Acai Berry Bowl</td><td>300</td></tr>
        <tr><td>Smoothie Bowls</td><td>Mixed Berry Bowl</td><td>220</td></tr>
        <tr><td>Sandwiches</td><td>Avocado Sandwich</td><td>250</td></tr>
        <tr><td>Sandwiches</td><td>Veggie Sandwich</td><td>200</td></tr>
        <tr><td>Overnight Oats</td><td>Berry Oats</td><td>200</td></tr>
        <tr><td>Overnight Oats</td><td>Almond Oats</td><td>180</td></tr>
    </table>

    <h1>Add Order</h1>
    <form action="create.php" method="post">
        <label for="customerName">Customer Name:</label>
        <input type="text" name="customerName" required>

        <label for="order">Order:</label>
        <select name="order" required>
            <option value="">Select order</option>
            <option value="Chicken Salad">Chicken Salad</option>
            <option value="Tofu Salad">Tofu Salad</option>
            <option value="Acai Berry Bowl">Acai Berry Bowl</option>
            <option value="Mixed Berry Bowl">Mixed Berry Bowl</option>
            <option value="Avocado Sandwich">Avocado Sandwich</option>
            <option value="Veggie Sandwich">Veggie Sandwich</option>
            <option value="Berry Oats">Berry Oats</option>
            <option value="Almond Oats">Almond Oats</option>
        </select>

        <label for="payment">Payment:</label>
        <input type="text" name="payment" required>

        <label for="appointDate">Date:</label>
        <input type="date" name="appointDate">

        <input type="submit" value="Add Order">
    </form>

    <a href="index.php">Back</a>

</body>
</html>
