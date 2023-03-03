<?php
$menu = "m_member";
include("../header_m.php");
if (isset($_REQUEST['user_id'])) {
  $user_id = $_REQUEST['user_id'];
  $del_stmt = $conn->prepare('DELETE FROM user WHERE user_id=:user_id');
  $del_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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
           window.location.href = "m_member.php; //หน้าที่ต้องการให้กระโดดไป
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
                  window.location = "m_member.php; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
  }
} //isset
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1><i class="nav-icon fas fa-address-card p-2"></i>จัดการข้อมูลพนักงาน</h1>
   
  </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<section class="content">
  <div class="card">
    <div class="card-header card-navy card-outline bg-navy">
      <h5>รายชื่อพนักงาน</h5>
      
    </div>

    <!-- Stat card-body -->
    <div class="card-body ">
    <a href="m_reg.php" class="btn btn-success btn-sm  m-2 ">
                  <i class="fas fa-plus-circle"></i> เพิ่มพนักงาน</a>
      <div class="col-md-12">
        <!-- start table -->
        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
          <thead>
            <tr role="row" class="h6 text-center">
              <th scope="col" style="width: 1%;">ลำดับ</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">รูปประจำตัว</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 15%;">ข้อมูลพนักงาน</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 7%;">ตำแหน่ง</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">เบอร์โทรศัพท์</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">อีเมล์</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">เวลาลงทะเบียน</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 7%;">ยกเลิก</th>
            </tr>
          </thead>
          <tbody class="h6">
            <?php
            $user_id = $_SESSION['manager_login'];
            $select_stmt = $conn->prepare("SELECT* FROM user WHERE user_status != 'Admin' and user_id != $user_id");
            $select_stmt->execute();
            $result = $select_stmt->fetchAll();
            $num = 0;
            foreach ($result as $row) {
              $num++;
            ?>
              <tr>
                <th scope="row" class="text-center"><?= $num ?></th>
                <td class="text-center">
                  <img src="../pic_profile/<?= $row['img_profile']; ?>" width="100px" height="100px" class="img-circle">
                </td>
                <td>
                  <input hidden value="<?= $row['user_id']; ?>">

                  <p><b>ชื่อ-นามสกุล : </b>
                    <?= $row['firstname'] . ' ' . $row['lastname']; ?>
                  </p>
                  <p><b>เพศ : </b><?php if ($row['gender'] == 'female') {
                                    echo "ผู้หญิง";
                                  } else {
                                    echo "ผู้ชาย";
                                  } ?>
                  </p>
                  <p><b>ที่อยู่ : </b><?= $row['address']; ?>
                  </p>
                </td>
                <td class="text-center"><?php if ($row['user_status'] == 'Manager') {
                                          echo "<b>ผู้จัดการ</b>";
                                        } else {
                                          echo "พนักงาน";
                                        }

                                        ?>
                </td>
                <td class="text-center"><?= $row['tel']; ?></td>
                <td class="text-center"><?= $row['email']; ?></td>
                <td class="text-center"><?= $row['created']; ?></td>
                <td class="text-center">
                  <a href="m_member.php?user_id=<?= $row['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูลพนักงาน !!');">
                    <i class="fas fa-trash"></i> ยกเลิกพนักงาน
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <!-- /.table-->
      </div>

    </div>
    <!-- /.card-body -->
  </div>
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