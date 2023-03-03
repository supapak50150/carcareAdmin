<?php
session_start();
require_once '../config/db.php';


if (isset($_GET['order_id'])) {

  $order_id = $_GET['order_id'];

  $sql = "UPDATE  order_main SET status = 'successfully' WHERE order_id = $order_id";
  $update_stmt = $conn->prepare($sql);
  $update_stmt->execute();
  header("location:u_carFinishWash.php");
} else {
  $_SESSION['error'] = "มีบางอย่างผิดพลาด";
  header("location:u_carFinishWash.php");
}

?>