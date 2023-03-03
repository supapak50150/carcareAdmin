<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['id'])) {


    $user_id = $_POST["user_id"];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE  user SET firstname=:firstname, lastname=:lastname, email=:email ,
     tel=:tel , address=:address  
WHERE user_id =:user_id");

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->execute();


    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    if ($stmt->rowCount() > 0) {
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "แก้ไขข้อมูลส่วนตัวสำเร็จ",
                  type: "success"
              }, function() {
                  window.location = "u_edit-profile.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    } else {
        header("location: u_edit-profile.php");
    }
    $conn = null; 

}
