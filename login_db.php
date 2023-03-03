<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['admin_login'])) {
    header("location: admin/register_manager.php");
}
if (isset($_SESSION['manager_login'])) {
    header("location: manager/m_serve.php");
}
if (isset($_SESSION['employee_login'])) {
    header("location: employee/u_serve.php");
}

if (isset($_POST['btn_login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    if (empty($username)) {
        $_SESSION['error'] = "กรุณาใส่ Username";
        header("location: login.php");
    } else if (empty($password)) {
        $_SESSION['error'] = "กรุณาใส่ Password";
        header("location: login.php");
    } else if ($username and $password) {

        try {
            $select_stmt = $conn->prepare("SELECT * FROM `user` 
            WHERE username = :username AND password = :password");
            $select_stmt->bindParam(":username", $username,);
            $select_stmt->bindParam(":password", $password,);
            $select_stmt->execute();

            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $dbuserstatus = $row['user_status'];
                $dbusername = $row['username'];
                $dbpassword = $row['password'];
                $id = $row['user_id'];
            }
            if ($username != null and $password != null) {
                if ($select_stmt->rowCount() > 0) {
                    if ($username == $dbusername and $password == $password) {
                        if ($dbuserstatus == 'Manager') {
                            $_SESSION['manager_login'] = $id;
                            setcookie("username", $username, time() + (86400 * 30), "/");
                            $_SESSION['success'] = "เข้าสู่ระบบ 'ผู้จัดการ' สำเร็จ";

                            echo '
                                <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
                            if (isset($_SESSION['success'])) {

                                echo '<script>
                                                 setTimeout(function() {
                                                  swal({
                                                      title: "เข้าสู่ระบบ ..ผู้จัดการ.. สำเร็จ",
                                                      type: "success"
                                                  }, function() {
                                                      window.location = "manager/m_serve.php"; //หน้าที่ต้องการให้กระโดดไป
                                                  });
                                                }, 1000);
                                            </script>';
                            }
                        } else if ($dbuserstatus == 'Employee'){
                            $_SESSION['employee_login'] = $id;
                            setcookie("username", $username, time() + (86400 * 30), "/");
                            $_SESSION['success'] = "เข้าสู่ระบบ 'พนักงาน' สำเร็จ";

                            echo '
                            <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
                            if (isset($_SESSION['success'])) {

                                echo '<script>
                                             setTimeout(function() {
                                              swal({
                                                  title: "เข้าสู่ระบบ ..พนักงาน.. สำเร็จ",
                                                  type: "success"
                                              }, function() {
                                                  window.location = "employee/u_serve.php"; //หน้าที่ต้องการให้กระโดดไป
                                              });
                                            }, 1000);
                                        </script>';
                            }
                        } else {
                            $_SESSION['admin_login'] = $id;
                            setcookie("username", $username, time() + (86400 * 30), "/");
                            $_SESSION['success'] = header("location: admin/register_manager.php");
                           
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
