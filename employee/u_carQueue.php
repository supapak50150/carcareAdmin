<?php
$menu = "carQueue";
include("../header_u.php");

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
  <div class="card">
    <div class="card-header card-navy card-outline bg-navy">
      <h5>สถานะการรับบริการ</h5>
      <?php include("u_tabStatus.php"); ?>
    </div>
  </div>

  <!-- Stat card-body -->
  <div class="card-body bg-light">

    <div class="card">
      <div class="card-body">

        <!-- Stat col -->
        <div class="col-md-12">
          <p class="h2"><strong>รายการที่..รอคิวล้าง</strong></p>
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
          <hr>
          <!-- Stat table-->
          <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row" class="h6 text-center">
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">รหัสออเดอร์</th>
                <th tabindex="0" rowspan="1" colspan="1" >ข้อมูลลูกค้า/บริการ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">ประเภทรถ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">ยี่ห้อ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">รุ่น</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">เลขทะเบียน</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">เวลา</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">พิมพ์ใบรับรถ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">ปรับสถานะ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;">ยกเลิก</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $update_stmt = $conn->prepare("SELECT * FROM order_main natural join customer  where status = 'wait' ");
              $update_stmt->execute();
              $result = $update_stmt->fetchAll();

              foreach ($result as $row) {
              ?>
                <tr>
                  <th scope="row" class="text-center"><?= $row['order_id']; ?></th>
                  <td class="text">
                    <div><b>ชื่อ-นามสกุล :</b><?= $row['cus_fname'] . ' ' . $row['cus_lname']; ?></div>
                    <p><b>เบอร์โทรศัพท์ :</b><?= $row['cus_tel']; ?></p>
                    <p><b>บริการเริ่มต้น :</b><?= $row['service']; ?></p>

                    <?php
                    $order_id = $row['order_id'];
                    $stmt = $conn->prepare("SELECT * FROM order_add_on  where order_id = $order_id");
                    $stmt->execute();
                    $result2 = $stmt->fetchAll();
                    $num = 1;
                    foreach ($result2 as $row2) {
                    ?>
                      <div><b>บริการเสริม <?= $num++; ?> :</b> <?= $row2['add_service']; ?></div>
                      

                    <?php } ?>
                  </td>
                  <td class="text-center"><?= $row['car_type']; ?></td>
                  <td class="text-center"><?= $row['car_brand']; ?></td>
                  <td class="text-center"><?= $row['car_series']; ?></td>
                  <td class="text-center"><?= $row['car_id']; ?></td>
                  <td class="text-center"><?= $row['date']; ?></td>
                  <td class="text-center">
                  <a href="../car-receipt.php?order_id=<?php echo $order_id ?>" rel="noopener" target="_blank" class="btn btn-info">
                  <i class="fas fa-print"></i> พิมพ์ใบรับรถ</a>
                  </td>
                  <td class="text-center">
                    <input hidden value="<?= $row['order_id']; ?>">
                    <a class="btn btn-warning btn-md" href="u_carQueue_update_stmt.php?order_id=<?= $row['order_id']; ?>" onclick="return confirm('ยืนยันการปรับสถานะ !!');">
                      ดำเนินการ
                    </a>
                  </td>
                  <td class="text-center">
                    <input hidden value="<?= $row['order_id']; ?>">
                    <a class="btn btn-danger btn-md" href="u_carQueue_cancel_stmt.php?order_id=<?= $row['order_id']; ?>" onclick="return confirm('ยกเลิกรายการ !!');">
                      ยกเลิก
                    </a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <!-- /.table-->
        </div>
        <!-- /. col -->
      </div>
    </div>

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