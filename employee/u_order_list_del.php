<?php
session_start();
require_once '../config/db.php';

if (isset($_REQUEST['cus_id'])) {

  $cus_id = $_REQUEST['cus_id'];

  $del_stmt = $conn->prepare('DELETE FROM cart_service WHERE cus_id=:cus_id');
  $del_stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
  $del_stmt->execute();
  $del_stmt2 = $conn->prepare('DELETE FROM cart_customer  WHERE cus_id=:cus_id');
  $del_stmt2->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
  $del_stmt2->execute();
  header("location:u_serve.php");
} else {
  $_SESSION['error'] = "มีบางอย่างผิดพลาด";
  header("location:u_order_list_sum.php?ms_id=$ms_id&cus_id=$cus_id");
}
