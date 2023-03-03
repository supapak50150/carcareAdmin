<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['btn_reg'])) {
    $manager = $_POST['manager'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $c_password = md5($_POST['c_password']);
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    $filename = $_FILES["img_profile"]["name"];
    $tempname = $_FILES["img_profile"]["tmp_name"];

    $folder = "../pic_profile";
    
    if (empty($manager)) {
        $_SESSION['error'] = "กรุณาเลือกตำแหน่ง";
        header("location: register_manager.php");
    } else if (empty($firstname)) {
        $_SESSION['error'] = "กรุณาใส่ firstname";
        header("location: register_manager.php");
    } else if (empty($lastname)) {
        $_SESSION['error'] = "กรุณาใส่ lastname";
        header("location: register_manager.php");
    } else if (empty($username)) {
        $_SESSION['error'] = "กรุณาใส่ Username";
        header("location: register_manager.php");
    } else if (empty($password)) {
        $_SESSION['error'] = "กรุณาใส่ รหัสผ่าน";
        header("location: register_manager.php");
    } else if (strlen($_POST['password']) < 8) {
        $_SESSION['error'] = "รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัว";
        header("location: register_manager.php");
    } else if (empty($c_password)) {
        $_SESSION['error'] = "กรุณายืนยันรหัสผ่าน";
        header("location: register_manager.php");
    } else if ($password != $c_password) {
        $_SESSION['error'] = "รหัสผ่านไม่ตรงกัน";
        header("location: register_manager.php");
    } else if (empty($address)) {
        $_SESSION['error'] = "กรุณาใส่ address";
        header("location: register_manager.php");
    } else if (empty($gender)) {
        $_SESSION['error'] = "กรุณาใส่ gender";
        header("location: register_manager.php");
    } else if (empty($tel)) {
        $_SESSION['tel'] = "กรุณาใส่ tel";
        header("location: register_manager.php");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "กรุณาใส่ email ให้ถูกต้อง";
        header("location: register_manager.php");
    } else {
        try {

            $select_stmt = $conn->prepare("SELECT username,email FROM user WHERE  username = :username OR email = :email");
            $select_stmt->bindParam(":username", $username,);
            $select_stmt->bindParam(":email", $email,);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['username'] == $username) {
                $_SESSION['warning'] = "มี username นี้อยู่ในระบบแล้ว";
                header("location: register_manager.php");
            } else if ($row['email'] == $email) {
                $_SESSION['warning'] = "มี email นี้อยู่ในระบบแล้ว";
                header("location: register_manager.php");
            } else if (!isset($_SESSION['error'])) {
                $insert_stmt = $conn->prepare("INSERT INTO user(user_status,firstname,lastname,username,password,address,gender,tel,email,img_profile) 
                VALUES(:manager,:firstname,:lastname,:username,:password,:address,:gender,:tel,:email,:img_profile)");

                move_uploaded_file($_FILES['img_profile']['tmp_name'],"../pic_profile/".$filename);
 
                $insert_stmt->bindParam(":manager", $manager, PDO::PARAM_STR);
                $insert_stmt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
                $insert_stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
                $insert_stmt->bindParam(":username", $username, PDO::PARAM_STR);
                $insert_stmt->bindParam(":password", $password, PDO::PARAM_STR);
                $insert_stmt->bindParam(":address", $address, PDO::PARAM_STR);
                $insert_stmt->bindParam(":gender", $gender, PDO::PARAM_STR);
                $insert_stmt->bindParam(":tel", $tel, PDO::PARAM_STR);
                $insert_stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $insert_stmt->bindParam(":img_profile", $filename, PDO::PARAM_STR);
                $insert_stmt->execute();
                header("location:../login.php");
            } else {
                $_SESSION['error'] = "มีบางอย่างผิดพลาด กรุณากรอกข้อมูลให้ถูกต้อง ";
                header("location: register_manager.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
