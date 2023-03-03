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

    $service = $_REQUEST['service'];
    $charge = $_REQUEST['charge'];





    $stmt_insert2 = $conn->prepare("INSERT INTO order_main (cus_id,date,update_date,status,admin,total,service,charge,user_id) 
    VALUES (:cus_id,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP(),:status, :admin, :total, :service, :charge, :user_id)");
    $stmt_insert2->bindParam(':cus_id', $cus_id, PDO::PARAM_STR);
    $stmt_insert2->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt_insert2->bindParam(':admin', $admin, PDO::PARAM_STR);
    $stmt_insert2->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt_insert2->bindParam(':total', $total, PDO::PARAM_STR);
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
            VALUES ($order_id,$add,$cus_id,$ms_id,'" . $a['add_onservice'] . "',$add_charge)";


            if ($conn1->query($sql2) === TRUE) {
            }
            $sql3 = "DELETE FROM `cart_service` where`cus_id`=$cus_id";
            if ($conn1->query($sql3) === TRUE) {
            }
        }
    }


    if ($result2) {
        header("location:u_carQueue.php");
    } else {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location:u_order_list_sum2.php?ms_id=$ms_id&cus_id=$cus_id");
    }
}
