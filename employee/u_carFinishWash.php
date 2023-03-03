<?php
$menu = "u_carFinishWash";
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
          <p class="h2"><strong>รายการที่..ล้างเสร็จแล้ว</strong></p>
          <hr>
          <!-- Stat table-->
          <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row" class="h6 text-center">
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">รหัสออเดอร์</th>
                <th tabindex="0" rowspan="1" colspan="1">ข้อมูลลูกค้า/บริการ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">ประเภทรถ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">ยี่ห้อ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">รุ่น</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">เลขทะเบียน</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">ค่าบริการ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">การชำระเงิน</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">พิมพ์ใบเสร็จ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">ปรับสถานะ</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $stmt = $conn->prepare("SELECT * FROM order_main natural join customer  where status = 'waitPayment' ");
              $stmt->execute();
              $result = $stmt->fetchAll();

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
                  <td class="text-center"><b>฿</b> <?= $row['total']; ?></td>
                  <td class="text-center">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter<?= $row['order_id']; ?>">
                      <i class="fas fa-money-bill-wave"></i> ชำระเงิน
                    </button>
                    <!--/. Button trigger modal -->

                    <!-- Modal -->
                    <form method="post" action="u_carFinishWash_payment.php">
                      <div class="modal fade" id="exampleModalCenter<?= $row['order_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title" id="exampleModalLongTitle">ลักษณะการชำระเงิน</h3>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="input-group m-1">
                                <div class="row">
                                  <div class="col-6 h6 text-left">

                                    <input hidden name="order_id" value="<?= $row['order_id']; ?>">
                                    <p><b>ชื่อ-นามสกุล :</b><?= $row['cus_fname'] . ' ' . $row['cus_lname']; ?></p>
                                    <p><b>เลขทะเบียน :</b><?= $row['car_id']; ?></p>
                                    <p><b>ค่าบริการ :</b><a><b>฿</b> <?= $row['total']; ?></a> </p>
                                  </div>

                                  <div class="col-6 ">
                                    <div class="input-group-prepend h5 ">
                                      <p>
                                        <span class="border m-1  rounded">
                                          <label class="m-1 ">
                                            <input type="radio" name="payment" required value="Cash" />
                                            เงินสด
                                          </label>
                                        </span>
                                        <span class="border m-1 rounded">
                                          <label class="m-1">
                                            <input type="radio" name="payment" required value="Transfer-Money" />
                                            เงินโอน
                                          </label>
                                        </span>
                                        <span class="border m-1 rounded">
                                          <label class="m-1">
                                            <input type="radio" name="payment" required value="Credit-Card" />
                                            บัตรเครดิต
                                          </label>
                                        </span>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                              <button type="submit" class="btn btn-success"> บันทึกการชำระเงิน </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /. Modal -->
                    </form>
                  </td>
                  <td class="text-center">
                    <a href="../invoice-print.php?order_id=<?php echo $order_id ?>" rel="noopener" target="_blank" class="btn btn-info"><i class="fas fa-print"></i> พิมพ์ใบเสร็จ</a>
                  </td>
                  <td class="text-center">
                    <input hidden value="<?= $row['order_id']; ?>">
                    <a class="btn btn-primary btn-md" href="u_carFinishWash_update_stmt.php?order_id=<?= $row['order_id']; ?>" onclick="return confirm('ยืนยันการปรับสถานะ !!');">
                      ชำระเงิน/รับรถ
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