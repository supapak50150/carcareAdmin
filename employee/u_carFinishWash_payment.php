<?php
session_start();
require_once '../config/db.php';



$order_id = $_POST['order_id'];
$payment = $_POST['payment'];


$stmt = "UPDATE  `order_main` SET payment = '$_POST[payment]' where order_id = $order_id";
$update_stmt = $conn->prepare($stmt);
$update_stmt->execute();

echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';


if ($update_stmt) {
    echo '<script>
        setTimeout(function() {
        swal({
        title: "บันทึกการชำระเงินเรียบร้อยแล้ว",
        type: "success"
        }, function() {
        window.location = "u_carFinishWash.php"; 
        });
        }, 1000);
    </script>';
} else {
    echo '<script>
        setTimeout(function() {
        swal({
        title: "เกิดข้อผิดพลาด",
        type: "error"
        }, function() {
        window.location = "u_carFinishWash.php"; 
        });
        }, 1000);
    </script>';
}
