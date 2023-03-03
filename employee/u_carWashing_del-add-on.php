<?php
session_start();
require_once '../config/db.php';


if (isset($_REQUEST['order_id'])) {

  $add_on_id = $_REQUEST['add_on_id'];
  $order_id = $_REQUEST['order_id'];
  $add_charge = $_REQUEST['add_charge'];
  



  $sql = "UPDATE  order_main SET total = (total - $add_charge ) WHERE order_id = $order_id";
  $update_stmt = $conn->prepare($sql);
  $update_stmt->execute();

    
  
  $del_stmt = $conn->prepare('DELETE FROM order_add_on  WHERE add_on_id=:add_on_id');
  $del_stmt->bindParam(':add_on_id', $add_on_id, PDO::PARAM_INT);
  $del_stmt->execute();


  header("location:u_carWashing.php");
} else {
  $_SESSION['error'] = "มีบางอย่างผิดพลาด";
  header("location:u_carWashing.php");
}

?>