<?php
session_start();
require_once '../config/db.php';

if (isset($_REQUEST['ms_id']) && isset($_REQUEST['cus_id']) && isset($_REQUEST['add_on_id']) ) {
  $ms_id = $_REQUEST['ms_id'];
  $cus_id = $_REQUEST['cus_id'];
  $add_on_id = $_REQUEST['add_on_id'];

  $del_stmt = $conn->prepare('DELETE FROM cart_service WHERE add_on_id=:add_on_id');
  $del_stmt->bindParam(':add_on_id', $add_on_id, PDO::PARAM_INT);
  $del_stmt->execute();
  header("location:u_cart_service.php?ms_id=$ms_id&cus_id=$cus_id");
}else{
  $_SESSION['error'] = "มีบางอย่างผิดพลาด";
  header("location:u_cart_service.php?ms_id=$ms_id&cus_id=$cus_id");
}
