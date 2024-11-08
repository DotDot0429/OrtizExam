<?php
// Include the database and Developer class
include_once '../core/db.php';
include_once '../class/Developer.php';

session_start(); // Start the session at the beginning of the file

// Check if the user is logged in by verifying if the 'username' session variable is set
if (!isset($_SESSION['username'])) {
     // If not logged in, redirect to login page
     header("Location: login.php");
     exit();
}

// Initialize the database and developer object
$database = new Database();
$db = $database->getConnection();
$crud = new crud($db);

// Get ID of the record to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

// Set ID property of the record to be edited
$crud->id = $id;

// Get the current data of the record
$crud->readOne();
$stmt1 = $crud->read("providers", "provider_id");

// Check if the form was submitted
if ($_POST) {
     // Set the new property values from the form input
     $crud->customerName = htmlspecialchars(strip_tags($_POST['customerName']));
     $crud->order = htmlspecialchars(strip_tags($_POST['order']));
     $crud->payment = htmlspecialchars(strip_tags($_POST['payment']));
     $crud->appointDate = htmlspecialchars(strip_tags($_POST['appointDate']));

     // Update the record
     if ($crud->update()) {
          echo "<div>Order updated.</div>";
     } else {
          echo "<div>Unable to update appointment.</div>";
     }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #2d6a4f;
            margin-top: 30px;
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
    </style>
</head>

<body>

    <h1>Edit Order</h1>

    <!-- Form to edit an appointment -->
    <form action="update.php?id=<?php echo $id; ?>" method="post">
        <label for="customerName">Customer Name:</label>
        <input type="text" name="customerName" required value="<?php echo htmlspecialchars($crud->customerName ?? ''); ?>">

        <label for="order">Order:</label>
        <select name="order" required>
            <option value="Select order">Select order</option>
            <option value="Chicken Salad" <?php if($crud->order == 'Chicken Salad') echo 'selected'; ?>>Chicken Salad</option>
            <option value="Tofu Salad" <?php if($crud->order == 'Tofu Salad') echo 'selected'; ?>>Tofu Salad</option>
            <option value="Acai Berry Bowl" <?php if($crud->order == 'Acai Berry Bowl') echo 'selected'; ?>>Acai Berry Bowl</option>
            <option value="Mixed Berry Bowl" <?php if($crud->order == 'Mixed Berry Bowl') echo 'selected'; ?>>Mixed Berry Bowl</option>
            <option value="Avocado Sandwich" <?php if($crud->order == 'Avocado Sandwich') echo 'selected'; ?>>Avocado Sandwich</option>
            <option value="Veggie Sandwich" <?php if($crud->order == 'Veggie Sandwich') echo 'selected'; ?>>Veggie Sandwich</option>
            <option value="Berry Oats" <?php if($crud->order == 'Berry Oats') echo 'selected'; ?>>Berry Oats</option>
            <option value="Almond Oats" <?php if($crud->order == 'Almond Oats') echo 'selected'; ?>>Almond Oats</option>
        </select>

        <label for="payment">Payment:</label>
        <input type="text" name="payment" required value="<?php echo htmlspecialchars($crud->payment ?? ''); ?>">

        <label for="appointDate">Date:</label>
        <input type="date" name="appointDate" value="<?php echo htmlspecialchars($crud->appointDate ?? ''); ?>">

        <input type="submit" value="Update">
    </form>

    <a href="index.php">Back</a>

</body>

</html>

