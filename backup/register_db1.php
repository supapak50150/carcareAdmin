<?php
session_start();
require_once 'config/db.php';

if (isset($_REQUEST['btn_reg'])) {
    $arole = $_REQUEST['arole'];
    $firstname = $_REQUEST['firstname'];
    $lastname = $_REQUEST['lastname'];
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $c_password = $_REQUEST['c_password'];
    $address = $_REQUEST['address'];
    $gender = $_REQUEST['gender'];
    $tel = $_REQUEST['tel'];
    $email = $_REQUEST['email'];


    if (empty($arole)) {
        $_SESSION['error'] = "กรุณาใส่เลือกตำแหน่ง";
        header("location: register.php");
    } else if (empty($firstname)) {
        $_SESSION['error'] = "กรุณาใส่ firstname";
    } else if (empty($lastname)) {
        $_SESSION['error'] = "กรุณาใส่ lastname";
        header("location: register.php");
    } else if (empty($username)) {
        $_SESSION['error'] = "กรุณาใส่ Username";
        header("location: register.php");
    } else if (empty($password)) {
        $_SESSION['error'] = "กรุณาใส่ รหัสผ่าน";
        header("location: register.php");
    } else if (strlen($_POST['password']) < 8) {
        $_SESSION['error'] = "รหัสผ่านต้องมีความยาว 8 ตัวอักษร";
        header("location: register.php");
    } else if (empty($c_password)) {
        $_SESSION['error'] = "กรุณายืนยันรหัสผ่าน";
        header("location: register.php");
    } else if ($password != $c_password) {
        $_SESSION['error'] = "รหัสผ่านไม่ตรงกัน";
        header("location: register.php");
    } else if (empty($address)) {
        $_SESSION['error'] = "กรุณาใส่ address";
        header("location: register.php");
    } else if (empty($gender)) {
        $_SESSION['error'] = "กรุณาใส่ gender";
        header("location: register.php");
    } else if (empty($gender)) {
        $_SESSION['tel'] = "กรุณาใส่ tel";
        header("location: register.php");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "กรุณาใส่ email ให้ถูกต้อง";
        header("location: register.php");
    } else {
        try {

            $select_stmt = $conn->prepare("SELECT username,email FROM admins WHERE  username = :username OR email = :email");
            // $select_stmt->bindParam(":arole", $arole, );
            $select_stmt->bindParam(":username", $username,);
            $select_stmt->bindParam(":email", $email,);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['username'] == $username) {
                $_SESSIONp['warning'] = "มี username นี้อยู่ในระบบแล้ว";
                header("location: register.php");
            } else if ($row['email'] == $email) {
                $_SESSIONp['warning'] = "มี email นี้อยู่ในระบบแล้ว";
                header("location: register.php");
            } else if (!isset($_SESSION['error'])) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $insert_stmt = $conn->prepare("INSERT INTO admins(arole,firstname,lastname,username,password,address,gender,tel,email) 
                VALUES(:arole,:firstname,:lastname,:username,:password,:address,:gender,:tel,:email)");
                $insert_stmt->bindParam(":arole", $arole);
                $insert_stmt->bindParam(":firstname", $firstname);
                $insert_stmt->bindParam(":lastname", $lastname);
                $insert_stmt->bindParam(":username", $username);
                $insert_stmt->bindParam(":password", $passwordHash);
                $insert_stmt->bindParam(":address", $address);
                $insert_stmt->bindParam(":gender", $gender);
                $insert_stmt->bindParam(":tel", $tel);
                $insert_stmt->bindParam(":email", $email);
                $insert_stmt->execute();
                $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว!";
                header("location: register.php");
            } else {
                $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                header("location: register.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
