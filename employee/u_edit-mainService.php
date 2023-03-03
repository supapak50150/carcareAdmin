<?php
$menu = "u_edit-mainService";
include("../header_u.php");
if (isset($_GET['ms_id'])) {
    $select_stmt = $conn->prepare("SELECT* FROM main_service WHERE ms_id=?");
    $select_stmt->execute([$_GET['ms_id']]);
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if ($select_stmt->rowCount() < 1) {
        header('Location: u_edit-all-service.php');
        exit();
    }
}
if (isset($_POST['ms_id']) && isset($_POST['service']) && isset($_POST['ms_charge']) && isset($_POST['car_type'])) {

    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $ms_id = $_POST['ms_id'];
    $car_type = $_POST['car_type'];
    $service = $_POST['service'];
    $ms_charge = $_POST['ms_charge'];
    //sql update
    $stmt = $conn->prepare("UPDATE  main_service SET car_type=:car_type, service=:service, ms_charge=:ms_charge WHERE ms_id=:ms_id");
    $stmt->bindParam(':ms_id', $ms_id, PDO::PARAM_INT);
    $stmt->bindParam(':car_type', $car_type, PDO::PARAM_STR);
    $stmt->bindParam(':service', $service, PDO::PARAM_STR);
    $stmt->bindParam(':ms_charge', $ms_charge, PDO::PARAM_STR);
    $stmt->execute();

    // sweet alert 
    echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    if ($stmt->rowCount() > 0) {
        echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "แก้ไขข้อมูล ..บริการหลัก.. สำเร็จ",
                      type: "success"
                  }, function() {
                      window.location = "u_edit-all-service.php"; //หน้าที่ต้องการให้กระโดดไป
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
    $conn = null; //close connect db
} //isset
?>


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1><i class="nav-icon fas fa-list-alt p-2"></i>จัดการข้อมูลการรับบริการ</h1>
    </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<section class="content">

    <!-- Stat card -->
    <div class="card">
        <div class="card-header card-navy card-outline">
            <h5>แก้ไขข้อมูลการบริการ</h5>
        </div>


        <!-- Stat card-body -->
        <div class="card-body">

            <form id="edit-profile-form" class="form h6" action="" method="post" enctype="multipart/form-data">
                <div class="card-body ">
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ประเภทรถ</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control text-center" name="car_type" readonly value="<?= $row['car_type']; ?>">
                        </div>
                    </div>
                    <!---/.ROW--->
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">บริการ</label>
                        <div class="col-md-4">
                            <textarea type="text" class="form-control " name="service" required><?= $row['service']; ?></textarea>
                        </div>
                    </div>
                    <!---/.ROW--->
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ค่าบริการ</label>
                        <div class="col-md-4">
                            <input type="number" class="form-control text-center" name="ms_charge" required value="<?= $row['ms_charge']; ?>">
                        </div>
                        <label class="col-sm-2 col-form-label">บาท</label>
                    </div>
                    <!---/.ROW--->
                    
                    <hr>
                    <input type="hidden" name="ms_id" value="<?= $row['ms_id']; ?>">
                    <button type="submit" class="btn btn-success btn-lg ">บันทึกข้อมูล</button>
                    <button type="reset" class="btn btn-danger btn-lg ">ยกเลิก</button>
                    <a class="btn btn-outline-secondary btn-lg " href="u_edit-all-service.php">ย้อนกลับ</a>
                </div>
            </form>

        </div>
        <!-- /.card-body -->

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