<?php
session_start();
require_once '../config/db.php';

$server = "localhost";
$user = "root";
$pass = "";
$database = "car_care_admin";

$conn1 = mysqli_connect($server, $user, $pass, $database);

if (!$conn1) {
    die("<script>alert('Connection Failed.')</script>");
}

if (isset($_REQUEST['submit_order'])) {

    $ms_id = $_REQUEST['ms_id'];
    $cus_id = $_REQUEST['cus_id'];
    $status = $_REQUEST['status'];
    $admin = $_REQUEST['admin'];
    $total = $_REQUEST['total'];
    $user_id = $_REQUEST['user_id'];

    $cus_fname = $_REQUEST['cus_fname'];
    $cus_lname = $_REQUEST['cus_lname'];
    $cus_tel = $_REQUEST['cus_tel'];
    $car_brand = $_REQUEST['car_brand'];
    $car_series = $_REQUEST['car_series'];
    $car_id = $_REQUEST['car_id'];
    $car_type = $_REQUEST['car_type'];
    $service = $_REQUEST['service'];
    $charge = $_REQUEST['charge'];


 
    $stmt_insert = $conn->prepare("INSERT INTO customer (cus_id, cus_fname, cus_lname, cus_tel, car_brand, car_series, car_id, car_type, ms_id) 
    VALUES (:cus_id,:cus_fname,:cus_lname,:cus_tel, :car_brand, :car_series, :car_id, :car_type, :ms_id)");

    $stmt_insert->bindParam(':cus_id', $cus_id, PDO::PARAM_STR);
    $stmt_insert->bindParam(':cus_fname', $cus_fname, PDO::PARAM_STR);
    $stmt_insert->bindParam(':cus_lname', $cus_lname, PDO::PARAM_STR);
    $stmt_insert->bindParam(':cus_tel', $cus_tel, PDO::PARAM_STR);
    $stmt_insert->bindParam(':car_brand', $car_brand, PDO::PARAM_STR);
    $stmt_insert->bindParam(':car_series', $car_series, PDO::PARAM_STR);
    $stmt_insert->bindParam(':car_id', $car_id, PDO::PARAM_STR);
    $stmt_insert->bindParam(':car_type', $car_type, PDO::PARAM_STR);
    $stmt_insert->bindParam(':ms_id', $ms_id, PDO::PARAM_STR);
    $result = $stmt_insert->execute();

    $cus_id2 = $conn->lastInsertId();
 
    $stmt_insert2 = $conn->prepare("INSERT INTO order_main (cus_id,date,update_date,status,admin,total, service, charge,user_id) 
    VALUES ($cus_id2,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP(),:status, :admin, :total, :service, :charge, :user_id)");

    $stmt_insert2->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt_insert2->bindParam(':admin', $admin, PDO::PARAM_STR);
    $stmt_insert2->bindParam(':total', $total, PDO::PARAM_STR);
    $stmt_insert2->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt_insert2->bindParam(':service', $service, PDO::PARAM_STR);
    $stmt_insert2->bindParam(':charge', $charge, PDO::PARAM_STR);
    $result2 = $stmt_insert2->execute();
   
    $order_id  = $conn->lastInsertId();
    //echo $order_id;


    $add_on_id = $_REQUEST['add_on_id'];

    if ($add_on_id != null) {
        $sql1 = "SELECT * FROM `cart_service` where `cus_id`=$cus_id";
        $stmt1 = $conn1->prepare($sql1);
        $stmt1->execute();
        $res1 = $stmt1->get_result();
        foreach ($res1 as $a) {
            $add = $a['add_on_id'];
            $add_service = $a['add_onservice'];
            $add_charge = $a['add_onservice_charge'];
            $sql2 = "INSERT INTO `order_add_on`(`order_id`, `add_on_id`, `cus_id`, `ms_id`, `add_service`, `add_charge`) 
            VALUES ($order_id,$add,$cus_id,$ms_id,'".$a['add_onservice']."',$add_charge)";
            
            
            if ($conn1->query($sql2) === TRUE) {
            }
            $sql3 = "DELETE FROM `cart_service` where`cus_id`=$cus_id";
            if ($conn1->query($sql3) === TRUE) {
            }
        }
    }

    $del_stmt = $conn->prepare('DELETE FROM cart_customer  WHERE cus_id=:cus_id');
    $del_stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
    $del_stmt->execute();


    if ($result2) {
        header("location:u_carQueue.php");
    } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location:u_order_list_sum.php?ms_id=$ms_id&cus_id=$cus_id");
    }
}
