<?php
session_start();
require_once '../config/db.php';

    $add_on_id = $_GET['add_on_id'];
    $ms_id = $_GET['ms_id'];

  $insert_stmt = $conn->prepare("INSERT INTO cart_service (cart_id,add_on_id,ms_id)
  VALUES (:cart_id,:add_on_id,:ms_id)");
  
  $insert_stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_STR);
  $insert_stmt->bindParam(':add_on_id', $add_on_id, PDO::PARAM_STR);
  $insert_stmt->bindParam(':ms_id', $ms_id, PDO::PARAM_STR);
  $result = $insert_stmt->execute();

  header("location:u_cart_service.php?ms_id=$ms_id");


?>

