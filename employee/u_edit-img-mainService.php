<?php
$menu = "u_edit-img-mainService";
include("../header_u.php");
if (isset($_GET['ms_id'])) {
    $ms_id =$_GET['ms_id'];
    $select_stmt = $conn->prepare("SELECT* FROM main_service WHERE ms_id=$ms_id");
    $select_stmt->execute([$_GET['ms_id']]);
    $result = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if ($select_stmt->rowCount() < 1) {
        header('Location: u_edit-all-service.php');
        exit();
    }
}
if (isset($_REQUEST['btn_imgCar'])) {
    try {
  
      $image_file = $_FILES["img_car"]["name"];
      $type = $_FILES['img_car']['type'];
      $size = $_FILES['img_car']['size'];
      $temp = $_FILES['img_car']['tmp_name'];
  
  
      $folder = "../pic_car/" . $image_file;
      $dir = "../pic_car/"; 
  
      if ($image_file) {
        if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png") {
          if ($size < 5000000) { // check file size 5MB
            unlink($dir . $result['img_car']); // unlink functoin remove previos file
            move_uploaded_file($temp, '../pic_car/' . $image_file); 
          } else {
            $errorMsg = "ไฟล์ของคุณมีขนาดใหญ่ โปรดอัปโหลดขนาด 5MB";
          }
        } else {
          $errorMsg = "โปรดอัปโหลดรูปแบบ JPG, JPEG, PNG";
        }
      } else {
        $image_file = $result['img_car']; 
      }
  
      if (!isset($errorMsg)) {
        $update_stmt = $conn->prepare("UPDATE main_service SET  img_car = :file_up WHERE ms_id=$ms_id");
        $update_stmt->bindParam(':file_up', $image_file);
  
        if ($update_stmt->execute()) {
          $updateMsg = "เปลี่ยนภาพประกอบ..สำเร็จ";
  ?>
          <script>
            window.location = "u_edit-all-service.php";
          </script>
  <?php }
      }
    } catch (PDOException $e) {
      $e->getMessage();
    }
  }

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
                            <input type="text" class="form-control text-center" name="car_type" readonly value="<?= $result['car_type']; ?>">
                        </div>
                    </div>
                    <!---/.ROW--->


                    <!---form-group--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">เปลี่ยนภาพประกอบ</label>
                        <div class="col-md-4">
                            <img src="../pic_car/<?php echo $result['img_car'] ?>" class="img-fluid m-3" style="width: 250px; height: 200px;">
                            <input type="file" name="img_car" accept="image/jpeg, image/png, image/jpg" required>
                        </div>
                    </div>
                    <!---/.form-group--->
                    <hr>

                    <input type="submit" name="btn_imgCar" class="btn btn-success btn-lg " value="เปลี่ยนรูปภาพประกอบ">
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