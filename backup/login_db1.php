<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['manager_login'])) {
    header("location: m_serve.php");
}
if (isset($_SESSION['employee_login'])) {
    header("location: u_serve.php");
}

if (isset($_REQUEST['btn_login'])) {
    $arole = $_REQUEST['arole'];
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    if (empty($arole)) {
        $_SESSION['error'] = "กรุณาใส่เลือกตำแหน่ง";
        header("location: login.php");
    } else if (empty($username)) {
        $_SESSION['error'] = "กรุณาใส่ Username";
        header("location: login.php");
    } else if (empty($password)) {
        $_SESSION['error'] = "กรุณาใส่ Password";
        header("location: login.php");
    } else if ($arole and $username and $password) {

        try {
            $select_stmt = $conn->prepare("SELECT arole,username,password FROM `admins`
            WHERE arole = :arole AND username = :username AND password = :password");
            $select_stmt->bindParam(":arole", $arole,);
            $select_stmt->bindParam(":username", $username,);
            $select_stmt->bindParam(":password", $password,);
            $select_stmt->execute();

            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $dbarole = $row['arole'];
                $dbusername = $row['username'];
                $dbpassword = $row['password'];
            }

            if ($arole != null and $username != null and $password != null) {
                if ($select_stmt->rowCount() > 0) {
                    if ($arole == $dbarole and $username == $dbusername and $password == $password) {
                        switch ($dbarole) {
                            case 'Manager':
                                $_SESSION['manager_login'] = $username;
                                setcookie("username", $username, time() + (86400 * 30), "/");
                                $_SESSION['success'] = "เข้าสู่ระบบ 'ผู้จัดการ' สำเร็จ";
                                header("location: m_serve.php");
                                break;
                            case 'Employee':
                                $_SESSION['employee_login'] = $username;
                                setcookie("username", $username, time() + (86400 * 30), "/");
                                $_SESSION['success'] = "เข้าสู่ระบบ 'พนักงาน' สำเร็จ";
                                header("location: u_serve.php");
                                break;

                            default:
                                $_SESSION['error'] = "อีเมล รหัสผ่าน ตำแหน่ง อาจไม่ถูกต้อง";
                                header("location: login.php");
                        }
                    }
                } else {
                    $_SESSION['error'] = "อีเมล รหัสผ่าน ตำแหน่ง อาจไม่ถูกต้อง";
                    header("location: login.php");
                }
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}
