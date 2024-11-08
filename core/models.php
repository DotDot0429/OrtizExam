<?php
class crud
{
     private $conn;
     private $table_name = "order"; 

     public $id;
     public $customerName;
     public $order;
     public $payment;
     public $appointDate;

     public function __construct($db)
     {
          $this->conn = $db;
     }

     public function read($table, $id)
     {
         $query = "SELECT * FROM " . $table . " ORDER BY $id DESC";
         $stmt = $this->conn->prepare($query);
         $stmt->execute();
         return $stmt;
     }
     

     public function readOne()
     {
         $query = "SELECT * FROM " . $this->table_name . " WHERE appointment_id = :id LIMIT 1";
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(":id", $this->id);
         $stmt->execute();
     
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
         if ($row) {
             // Set properties from fetched data
             $this->customerName = $row['customer_name'];
             $this->order = $row['order'];
             $this->payment = $row['payment'];
             $this->appointDate = $row['appointment_date'];
         }
     }
     
     public function create()
     {
         $query = "INSERT INTO " . $this->table_name . "
                   SET customer_name = :customerName, `order` = :order, payment = :payment, appointment_date = :appointDate, createBy = :createBy";
     
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(":customerName", $this->customerName);
         $stmt->bindParam(":order", $this->order);
         $stmt->bindParam(":payment", $this->payment);
         $stmt->bindParam(":appointDate", $this->appointDate);
         $stmt->bindParam(":createBy", $_SESSION['username']); // Assuming you're using session for user tracking
     
         if ($stmt->execute()) {
             return true;
         }
     
         return false;
     }
     

     public function update()
     {
         $timestamp = date("Y-m-d H:i:s");  // Get the current timestamp
         $updateByValue = $_SESSION['username'] . " (" . $timestamp . ")";  // Concatenate username and timestamp
         
         $query = "UPDATE " . $this->table_name . "
                   SET customer_name = :customerName, `order` = :order, payment = :payment, 
                       appointment_date = :appointDate, updateBy = :updateBy
                   WHERE appointment_id = :id";
     
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(":customerName", $this->customerName);
         $stmt->bindParam(":order", $this->order);
         $stmt->bindParam(":payment", $this->payment);
         $stmt->bindParam(":appointDate", $this->appointDate);
         $stmt->bindParam(":updateBy", $updateByValue);  // Bind the combined value
         $stmt->bindParam(":id", $this->id);
     
         if ($stmt->execute()) {
             return true;
         }
     
         return false;
     }
     
     
     

     

     public function delete()
     {
          // SQL query to delete an appointment by its ID
          $query = "DELETE FROM " . $this->table_name . " WHERE appointment_id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(":id", $this->id);

          if ($stmt->execute()) {
               return true;
          }

          return false;
     }
}
?>
