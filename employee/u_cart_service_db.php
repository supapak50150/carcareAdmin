<?php
session_start();
require_once '../config/db.php';

$add_on_id = $_GET['add_on_id'];
$ms_id = $_GET['ms_id'];
$cus_id = $_GET['cus_id'];

$select_stmt = $conn->prepare("SELECT add_on_id FROM cart_service WHERE  add_on_id = $add_on_id ");
$select_stmt->bindParam(":add_on_id", $add_on_id,);
$select_stmt->execute();
$row = $select_stmt->fetch(PDO::FETCH_ASSOC);

if ($row['add_on_id'] == $add_on_id) {
  $_SESSION['warning'] = "คุณเลือกบริการเสริมนี้ไปแล้ว";
  header("location:u_cart_service.php?ms_id=$ms_id&cus_id=$cus_id");
} else if (!isset($_SESSION['error'])) {

  $stmt = $conn->prepare("SELECT * FROM add_on_service WHERE  add_on_id = $add_on_id ");
  $stmt->execute();
  $row2 = $stmt->fetchAll();
  foreach ($row2 as $r) {

    $add = $r['add_on_id'];
    $add_service = $r['add_onservice'];
    $add_charge = $r['add_onservice_charge'];


    $insert_stmt = $conn->prepare("INSERT INTO cart_service (add_on_id,cus_id,add_onservice,add_onservice_charge)
  VALUES (:add_on_id,:cus_id,:add_onservice,:add_onservice_charge)");

    $insert_stmt->bindParam(':add_on_id', $add, PDO::PARAM_STR);
    $insert_stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_STR);
    $insert_stmt->bindParam(':add_onservice', $add_service, PDO::PARAM_STR);
    $insert_stmt->bindParam(':add_onservice_charge', $add_charge, PDO::PARAM_STR);
    $result = $insert_stmt->execute();

    header("location:u_cart_service.php?ms_id=$ms_id&cus_id=$cus_id");
  }
} else {
  $_SESSION['error'] = "มีบางอย่างผิดพลาด";
  header("location:u_cart_service.php?ms_id=$ms_id&cus_id=$cus_id");
}
