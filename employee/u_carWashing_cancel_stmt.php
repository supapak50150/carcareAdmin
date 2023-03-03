<?php
session_start();
require_once '../config/db.php';


if (isset($_REQUEST['order_id'])) {

  $order_id = $_REQUEST['order_id'];

  $del_stmt = $conn->prepare('DELETE FROM order_main  WHERE order_id=:order_id');
  $del_stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
  $del_stmt->execute();

  $del_stmt1 = $conn->prepare('DELETE FROM order_add_on  WHERE order_id=:order_id');
  $del_stmt1->bindParam(':order_id', $order_id, PDO::PARAM_INT);
  $del_stmt1->execute();


  header("location:u_carWashing.php");
} else {
  $_SESSION['error'] = "มีบางอย่างผิดพลาด";
  header("location:u_carWashing.php");
}

?>