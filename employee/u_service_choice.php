<?php

include("../header_u.php");

if (isset($_GET['ms_id'])) {
  $select_stmt = $conn->prepare("SELECT * FROM main_service where ms_id=?");
  $select_stmt->execute([$_GET['ms_id']]);
  $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1><i class="nav-icon fas fa-car p-2"></i>การรับบริการเสริม</h1>
  </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<section class="content">


  <?php
  $ms_id = $_GET['ms_id'];
  $stmt = $conn->prepare("SELECT * FROM cart_customer where cus_id = ( SELECT MAX(cus_id) FROM cart_customer ) ");
  $stmt->execute([$_GET['ms_id']]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  ?>
  <!-- Stat card -->
  <div class="card">
    <div class="h4 card-header card-navy card-outline bg-navy">เลือกบริการเสริม</div>

    <!-- Stat card-body -->
    <div class="card-body bg-light ">
      <div class="container">

        <!---------------------------ข้อมูลลูกค้า/รถ----------------------------->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="h4 card-header font-weight-bold text-center bg-warning">การรับบริการเสริม</div>
              <div class="card-body ">
                <form action="" method="post">
                  <h2 class="card-text text-center m-3">ลูกค้าต้องการรับ <b>บริการเสริม</b> หรือไม่ ?</h2>
                  <!---------------------------/.ข้อมูลลูกค้า/รถ----------------------------->

                  <input hidden type="text" name="ms_id" value="<?php echo $result['ms_id']; ?>">
                  <input hidden type="text" name="cus_id" value="<?php echo $result['cus_id']; ?>">
                  <div class="form-row h6">
                    <div class="form-group col-md-4">
                      <label>ชื่อ</label>
                      <input type="text" value="<?php echo $result['cus_fname']; ?>" name="cus_fname" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-4">
                      <label>นามสกุล</label>
                      <input type="text" value="<?php echo $result['cus_lname']; ?>" name="cus_lname" class="form-control" readonly>
                      </select>
                    </div>
                    <div class="form-group  col-md-4">
                      <label>เบอร์โทรศัพท์</label>
                      <input type="number" value="<?php echo $result['cus_tel']; ?>" name="cus_tel" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="form-row h6">
                    <div class="form-group col-md-4">
                      <label>ยี่ห้อ</label>
                      <input type="text" value="<?php echo $result['car_brand']; ?>" name="car_brand" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-4">
                      <label>รุ่น</label>
                      <input type="text" value="<?php echo $result['car_series']; ?>" name="car_series" class="form-control" readonly>
                      </select>
                    </div>
                    <div class="form-group  col-md-4">
                      <label>เลขทะเบียน</label>
                      <input type="text" value="<?php echo $result['car_id']; ?>" name="car_num" class="form-control" readonly>
                    </div>
                  </div>

                  <div class="row text-center m-5 ">
                    <div class="col-4 ">
                      <a href="u_order_list_sum.php?ms_id=<?= $result['ms_id']; ?>&cus_id=<?= $result['cus_id']; ?>" class="btn btn-primary btn-lg btn-block">
                        <i class="fas fa-clipboard-check"></i></i>&nbsp;&nbsp; ไม่,สรุปรายการ</a>
                    </div>
                    <div class="col-4">
                      <a href="u_service_choice_del.php?cus_id=<?= $result['cus_id']; ?>" class="btn btn-danger btn-lg btn-block" onclick="return confirm('ยืนยันการลบข้อมูล !!');">ยกเลิก</a>
                    </div>
                    <div class="col-4">
                      <a href="u_cart_service.php?ms_id=<?= $result['ms_id']; ?>&cus_id=<?= $result['cus_id']; ?>" class="btn btn-success btn-lg btn-block">
                        ใช่,เลือกบริการเสริม <i class="fas fa-arrow-right"></i></a>
                    </div>

                  </div>

                  <!--------------------------------------------------------------------------->
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.card-body -->

  </div><!-- /.card -->
</section><!-- /.content -->

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