<?php
$menu = "u_edit-all-service";
include("../header_u.php");
if (isset($_REQUEST['ms_id'])) {
  $ms_id = $_REQUEST['ms_id'];
  $del_stmt = $conn->prepare('DELETE FROM main_service WHERE ms_id=:ms_id');
  $del_stmt->bindParam(':ms_id', $ms_id, PDO::PARAM_INT);
  $del_stmt->execute();
  //  sweet alert 
  echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

  if ($del_stmt->rowCount() > 0) {
    echo '<script>
      setTimeout(function() {
       swal({
           title: "ลบข้อมูล ..บริการเสริม.. สำเร็จ",
           type: "success"
       }, function() {
           window.location.href = "u_edit-all-service.php //หน้าที่ต้องการให้กระโดดไป
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
                  window.location = "u_edit-all-service.php //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
  }
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
    <div class="card-header card-navy card-outline bg-navy">
      <h5>ข้อมูลการรับบริการ</h5>
    </div>

    <!-- Stat card-body-->
    <div class="card-body bg-light ">
      <!------------------------------บริการหลัก---------------------------------->
      <!-- Stat card 01 -->
      <div class="card ">
        <div class="card-body  ">
          <!-- start col -->
          <div class="col-md-12">

            <div class="row p-3">
              <div class="col-6">
                <a href="u_add-main_service.php" class="btn btn-success btn-sm  ">
                  <i class="fas fa-plus-circle"></i> เพิ่มบริการเริ่มต้น</a>
              </div>
              <div class="col-6">
                <a class="h3"><strong>บริการเริ่มต้น</strong></a>
              </div>
            </div>

            <!-- start table -->
            <table class="table">
              <thead>
                <tr class="h6 bg-light text-center">
                  <th scope="col" style="width: 15%;">รูปภาพ</th>
                  <th scope="col" style="width: 15%;">ประเภทรถ</th>
                  <th scope="col" style="width: 30%;">บริการเริ่มต้น</th>
                  <th scope="col" style="width: 10%;">ค่าบริการ</th>
                  <th scope="col"></th>
                </tr>
              </thead>

              <tbody>
                <?php
                $stmt = $conn->prepare("SELECT * FROM main_service");
                $stmt->execute();
                $result = $stmt->fetchAll();
                foreach ($result as $row) {
                ?>
                  <tr>
                    <td hidden class="text-center"><?= $row['ms_id']; ?></td>
                    <td class="text-center"><img src="../pic_car/<?= $row['img_car']; ?>" width="80px" height="65px"></td>
                    <td class="text-center"><?= $row['car_type']; ?></td>
                    <td class="text-center"><?= $row['service']; ?></td>
                    <td class="text-center"><?= $row['ms_charge']; ?></td>
                    <td class="text-center">
                      <a href="u_edit-mainService.php?ms_id=<?= $row['ms_id']; ?>" class="btn btn-outline-light btn-sm" style="background-color:#EE9A4D;">
                        <i class="fas fa-pencil-alt"> </i> แก้ไขบริการ</a>
                      <a href="u_edit-img-mainService.php?ms_id=<?= $row['ms_id']; ?>" class="btn btn-outline-warning btn-sm" style="color:#EE9A4D;">
                        <i class="fas fa-image"></i> เปลี่ยนรูปภาพ</a>
                      <a href="u_add-onService.php?ms_id=<?= $row['ms_id']; ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle"></i> บริการเสริม </a>
                      <a href="u_edit-all-service.php?ms_id=<?= $row['ms_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล !!');">
                        <i class="fas fa-trash-alt"></i> ลบ</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <!-- /.table -->

          </div>
        </div>
        <!--/. col -->
      </div>
      <!------------------------------บริการหลัก---------------------------------->

    </div>
    <!-- /. card-body  -->

  </div>
  <!--/.card  -->
</section>
<!-- /.Main content-->

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