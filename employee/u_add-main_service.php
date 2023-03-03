<?php
include("../header_u.php");
if (isset($_REQUEST['btn_add_service'])) {
    $car_type = $_REQUEST['car_type'];
    $service = $_REQUEST['service'];
    $ms_charge = $_REQUEST['ms_charge'];

    $filename = $_FILES["img_car"]["name"];
    $tempname = $_FILES["img_car"]["tmp_name"];

    $folder = "../pic_car/";

    $insert_stmt = $conn->prepare("INSERT INTO main_service (car_type,service,ms_charge,img_car)
    VALUES (:car_type,:service,:ms_charge,:img_car)");

    move_uploaded_file($_FILES['img_car']['tmp_name'], "../pic_car/" . $filename);

    $insert_stmt->bindParam(':car_type', $car_type, PDO::PARAM_STR);
    $insert_stmt->bindParam(':service', $service, PDO::PARAM_STR);
    $insert_stmt->bindParam(':ms_charge', $ms_charge, PDO::PARAM_STR);
    $insert_stmt->bindParam(":img_car", $filename, PDO::PARAM_STR);
    $result = $insert_stmt->execute();
    // sweet alert 


    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    if ($result) {
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "เพิ่ม ..บริการเริ่มต้น.. สำเร็จ",
                  type: "success"
              }, function() {
                  window.location.href = "u_edit-all-service.php"; //หน้าที่ต้องการให้กระโดดไป
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
                  window.location = "u_edit-all-service.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    }
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1><i class="nav-icon fas fa-list-alt p-2"></i>เพิ่มข้อมูลการรับบริการเริ่มต้น</h1>
    </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->


<section class="content">

    <!-- Stat card -->
    <div class="card">
        <div class="card-header card-navy card-outline">
            <p class="h5 ">เพิ่มการบริการเริ่มต้น </p>
        </div>

        <!-- Stat card-body -->
        <div class="card-body">
            <form id="edit-profile-form" class="form h6" action="" method="post" enctype="multipart/form-data">
                <div class="card-body ">
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ประเภทรถ</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control text-center" name="car_type" required>
                        </div>
                    </div>
                    <!---/.ROW--->
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">บริการ</label>
                        <div class="col-md-4">
                            <textarea type="text" class="form-control " name="service" required></textarea>
                        </div>
                    </div>
                    <!---/.ROW--->
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ค่าบริการ</label>
                        <div class="col-md-4">
                            <input type="number" class="form-control text-center" name="ms_charge" required>
                        </div>
                        <label class="col-sm-2 col-form-label">บาท</label>
                    </div>
                    <!---/.ROW--->
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ภาพประกอบ</label>
                        <div class="col-md-4">
                            <input type="file" name="img_car" accept="image/jpeg, image/png, image/jpg" required>
                        </div>
                    </div>
                    <!---/.ROW--->
                    <hr>

                    <button type="submit" class="btn btn-success btn-lg" name="btn_add_service">บันทึกข้อมูล</button>
                    <button type="reset" class="btn btn-danger btn-lg ">ยกเลิก</button>
                    <a class="btn btn-outline-secondary btn-lg " href="u_edit-all-service.php">ย้อนกลับ</a>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>


    </div>
    <!--/.card -->
</section>
<!-- /.content -->

<!-- footer -->
<?php include('../footer.php'); ?>
<script>
    $(function() {
        $(".datatable").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>
</body>

</html>