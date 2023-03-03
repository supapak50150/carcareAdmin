<?php
session_start();
require_once '../config/db.php';



if (isset($_REQUEST['btn_customer'])) {
  $cus_fname = $_REQUEST['cus_fname'];
  $cus_lname = $_REQUEST['cus_lname'];
  $cus_tel = $_REQUEST['cus_tel'];
  $car_brand = $_REQUEST['car_brand'];
  $car_series = $_REQUEST['car_series'];
  $car_id = $_REQUEST['car_id'];
  $ms_id = $_REQUEST['ms_id'];

 
      $insert_stmt = $conn->prepare("INSERT INTO cart_customer (cus_fname,cus_lname,cus_tel,car_brand,car_series,car_id,ms_id)
        VALUES (:cus_fname,:cus_lname,:cus_tel,:car_brand,:car_series,:car_id,:ms_id)");
      $insert_stmt->bindParam(':cus_fname', $cus_fname, PDO::PARAM_STR);
      $insert_stmt->bindParam(':cus_lname', $cus_lname, PDO::PARAM_STR);
      $insert_stmt->bindParam(':cus_tel', $cus_tel, PDO::PARAM_STR);
      $insert_stmt->bindParam(':car_brand', $car_brand, PDO::PARAM_STR);
      $insert_stmt->bindParam(':car_series', $car_series, PDO::PARAM_STR);
      $insert_stmt->bindParam(':car_id', $car_id, PDO::PARAM_STR);
      $insert_stmt->bindParam(':ms_id', $ms_id, PDO::PARAM_STR);
      $result = $insert_stmt->execute();
      header("location: u_service_choice.php?ms_id=$ms_id");
    } else {
      
      header("location: u_cart_customer.php?ms_id=$ms_id");
    }
?>