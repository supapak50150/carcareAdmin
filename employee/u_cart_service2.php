<script type="text/javascript">
  var phpvar = "<?php echo $_GET['ms_id']; ?>";
</script>
<?php
$menu = "u_customer_service";
include("../header_u.php");

if (isset($_GET['ms_id'])) {
  $select_stmt = $conn->prepare("SELECT * FROM main_service where ms_id=?");
  $select_stmt->execute([$_GET['ms_id']]);
  $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_GET['cus_id'])) {
  $select_stmt = $conn->prepare("SELECT * FROM customer where cus_id=?");
  $select_stmt->execute([$_GET['cus_id']]);
  $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1><i class="nav-icon fas fa-car p-2"></i>การรับบริการ</h1>
  </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<section class="content">

  <!-- Stat card -->
  <div class="card">
    <div class="h4 card-header card-navy card-outline bg-navy">การรับบริการเสริม</div>

    <!-- Stat card-body -->
    <div class="card-body bg-light ">

      <form action="" method="post">

        <?php
        $cus_id = $_GET['cus_id'];
        $select_stmt = $conn->prepare("SELECT * FROM customer where cus_id=$cus_id");
        $select_stmt->execute([$_GET['cus_id']]);
        $result = $select_stmt->fetch(PDO::FETCH_ASSOC);

        ?>

        <input hidden type="text" value="<?php echo $cus_id; ?>">
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
            <label>เลขทะเบียน</label>
            <input type="text" value="<?php echo $result['car_id']; ?>" name="car_num" class="form-control" readonly>
          </div>
        </div>

        <?php if (isset($_SESSION['warning'])) : ?>
          <div class="alert alert-warning">
            <h4 class="text-center text-light">
              <?php
              echo $_SESSION['warning'];
              unset($_SESSION['warning']);
              ?>
            </h4>
          </div>
        <?php endif ?>
        <?php if (isset($_SESSION['error'])) : ?>
          <div class="alert alert-danger">
            <h4>
              <?php
              echo $_SESSION['error'];
              unset($_SESSION['error']);
              ?>
            </h4>
          </div>
        <?php endif ?>
        <div class="row">
          <div class="col-6">
            <!------------------------------------เลือกบริการเสริม-------------------------------------------->
            <div class="card">
              <div class="h5 card-header font-weight-bold text-center" style="background-color:#EE9A4D;">บริการเสริม</div>
              <div class="card-body  ">
                <div class="col-md-12">

                  <!-- Stat table-->
                  <table id="example" class="table table-sm table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row" class="h6 text-center">
                        <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;">ลำดับ</th>
                        <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">ประเภทรถ</th>
                        <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">บริการเสริม</th>
                        <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">ค่าบริการ</th>
                        <th tabindex="0" rowspan="1" colspan="1"></th>
                    </thead>
                    <tbody>
                      <?php
                      $ms_id = $_GET['ms_id'];
                      $stmt = $conn->prepare("SELECT * FROM add_on_service where ms_id = $ms_id ");
                      $stmt->execute();
                      $result = $stmt->fetchAll();
                      $num = 0;
                      foreach ($result as $row) {
                        $num++;
                      ?>
                        <tr>
                          <th scope="result" class="text-center"><?= $num ?></th>
                          <td class="text-center"><b><?= $row['car_type']; ?></b></td>
                          <td class="text-center"><?= $row['add_onservice']; ?></td>
                          <td class="text-center"><?= $row['add_onservice_charge']; ?></td>
                          <td class="text-center">

                            <a href="u_cart_service_db2.php?add_on_id=<?= $row['add_on_id']; ?>&ms_id=<?= $row['ms_id']; ?>&cus_id=<?php echo $cus_id; ?>" class="btn btn-outline-light btn-sm" style="background-color:#EE9A4D;">
                              <i class="fas fa-plus-circle"></i>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <!-- /.table-->
                </div>
              </div>
            </div>
          </div>
          <!-----------------------------------------------สรุปรายการ----------------------------------------------------->
          <div class="col-6">
            <div class="card">
              <div class="h5 card-header font-weight-bold text-center" style="background-color:#C5E1A5;">สรุปรายการ</div>
              <div class="card-body  ">
                <div class="col-md-12">
                  <!-- start table -->
                  <table class="table table-sm table-hover">
                    <thead class="h6 bg-light">
                      <tr>
                        <th scope="col" class="text-center" style="width: 5%;">ลำดับ</th>
                        <th scope="col" style="width: 35%;">บริการเริ่มต้น</th>
                        <th scope="col">บริการเสริม</th>
                        <th scope="col" class="text-center" style="width: 15%;">ค่าบริการ </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ms_id = $_GET['ms_id'];
                      $stmt = $conn->prepare("SELECT * FROM main_service where ms_id = $ms_id");
                      $stmt->execute();
                      $result = $stmt->fetchAll();
                      $num = 1;
                      $mscharge = 0;
                      foreach ($result as $row) {
                        $mscharge = $row['ms_charge'];
                      ?>
                        <tr>
                          <th scope="row" class="text-center"><?= $num++ ?></th>
                          <td><?= $row['service']; ?></td>
                          <td></td>
                          <td class="text-center"><?= $row['ms_charge']; ?></td>
                          <td></td>
                        </tr>
                      <?php }
                      $stmt = $conn->prepare("SELECT * FROM cart_service natural join add_on_service where ms_id = $ms_id");
                      $stmt->execute();
                      $result = $stmt->fetchAll();
                      $num = 2;
                      foreach ($result as $row) {
                      ?>
                        <tr>
                          <th scope="row" class="text-center"><?= $num++ ?></th>
                          <td></td>
                          <td><?= $row['add_onservice']; ?></td>
                          <td class="text-center"><?= $row['add_onservice_charge']; ?></td>
                          <td><!----ลบ---->
                            <a href="u_cart_service_del2.php?add_on_id=<?= $row['add_on_id']; ?>&ms_id=<?= $row['ms_id']; ?>&cus_id=<?php echo $cus_id; ?>" class="btn btn-outline-danger btn-sm">
                              <i class="fas fa-trash-alt"></i>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>
                      <?php
                      $stmt = $conn->prepare("SELECT *,sum(add_onservice_charge)as total_services FROM cart_service natural join add_on_service  natural join main_service where cus_id = $cus_id ");
                      $stmt->execute();
                      $result = $stmt->fetch(PDO::FETCH_ASSOC);
                      if ($result) {
                        $total = $result['total_services'] + $mscharge;
                      } else {
                        $total = $mscharge;
                      }
                      ?>
                      <tr>
                        <td colspan="2"></td>
                        <td class="text-right"><b>รวม</b></td>
                        <td class="text-center"><?php echo number_format($total, 2); ?>
                        </td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- /.table -->
                </div>
                <!--------------------------------------------------------------------------------------------------------------------------------------->
                <div class="text-center">
                  <a href="u_order_list_sum2.php?cus_id=<?php echo $cus_id; ?>&ms_id=<?php echo $ms_id; ?>" class="btn btn-success btn-lg">
                    บันทึกข้อมูล
                  </a>
                  <a href="u_cart_service_cancel2.php?cus_id=<?php echo $cus_id; ?>" class="btn btn-danger btn-lg" onclick="return confirm('ยืนยันการลบข้อมูล !!');">ยกเลิก</a>

                </div>
                <!--------------------------------------------------------------------------------------------------------------------------------------->

              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- /.card-body -->
  </div>
  <!-- /.card -->
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