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

$stmt = $crud->read("appointments", "appointment_id");
$num = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vital Eats</title>
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
        .session-info {
            text-align: center;
            margin: 20px auto;
        }
        input[disabled] {
            background-color: #e7f5e9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: auto;
            margin-left: 10px;
        }
        a {
            color: #2d6a4f;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        button {
            background-color: #2d6a4f;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1b4332;
        }
        .table-container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
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

    <div class="session-info">
        <label for="userName">Current Session is:</label>
        <input name="userName" disabled value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
        <a href="logout.php"><button>Logout</button></a><br>
    </div>

    <h1>Vital Eats</h1>
    <div class="table-container">
        <a href="create.php"><button>Add Order</button></a><br><br>

        <?php if ($num > 0) { ?>
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Order</th>
                    <th>Payment</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { extract($row); ?>
                    <tr>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $order; ?></td>
                        <td><?php echo $payment; ?></td>
                        <td><?php echo $createBy; ?></td>
                        <td><?php echo $updateBy; ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $appointment_id; ?>">Edit</a> |
                            <a href="delete.php?id=<?php echo $appointment_id; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No orders found.</p>
        <?php } ?>

