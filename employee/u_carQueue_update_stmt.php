<?php
session_start();
require_once '../config/db.php';


if (isset($_GET['order_id'])) {

  $order_id = $_GET['order_id'];

  $sql = "UPDATE  order_main SET status = 'wash' WHERE order_id = $order_id";
  $update_stmt = $conn->prepare($sql);
  $update_stmt->execute();
  header("location:u_carQueue.php");
} else {
  $_SESSION['error'] = "มีบางอย่างผิดพลาด";
  header("location:u_carQueue.php");
}

?>