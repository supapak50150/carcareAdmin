<?php
$menu = "m_income";
?>
<?php include("../header_m.php"); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1><i class="nav-icon fas fa-chart-line p-2"></i>รายการทั้งหมด</h1>
  </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<section class="content">

  <!-- Stat card -->
  <div class="card">
    <div class="card-header card-navy card-outline bg-navy">

      <div class="row">
        <div class="col-lg ">
          <a class="btn btn-primary" href="m_income.php">รายการทั้งหมด</a>
          <a class="btn btn-warning" href="m_income-day.php">รายวัน</a>
          <a class="btn btn-success" href="m_income-month.php">รายเดือน</a>
          <a class="btn btn-info" href="m_income-year.php">รายปี</a>
        </div>
      </div>

    </div>


    <!-- Stat card-body -->
    <div class="card-body ">
      <p class="h2 text-center"><strong>รายการทั้งหมด</strong></p>
      <div class="col-md-12">
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
              <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">เวลา</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">เจ้าหน้าที่</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">ข้อมูลใบเสร็จ</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $stmt = $conn->prepare("SELECT * FROM order_main natural join customer   where status = 'successfully' ");
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
                  $stmt = $conn->prepare("SELECT * FROM order_add_on   where order_id = $order_id");
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
                <td class="text-center"><?= $row['date']; ?></td>
                <td class="text-center"><?= $row['admin']; ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-outline-light btn-lg" style="background-color: #5C6BC0;" data-toggle="modal" data-target="#exampleModal<?php echo $row['order_id']; ?>">
                    แสดงใบเสร็จ
                  </button>
                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal<?php echo $row['order_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">ใบเสร็จการรับบริการ</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <!-- ข้อมูลใบเสร็จ -->
                        <div class="container">
                          <div class="card m-4">
                            <!--- start card-header --->
                            <div class="card-header bg-white">
                              <div class="row">
                                <div class="col-sm">
                                  <img src="..\assets\dist\img\logoCarCare.png" width="100" height="45">
                                </div>
                                <div class="col-sm text-center h2">
                                  ใบเสร็จ
                                </div>


                                <div class="col-sm">
                                  <?php
                                  $order_id = $row['order_id'];
                                  $stmt = $conn->prepare("SELECT *,replace(replace(replace(replace(CURRENT_TIMESTAMP(),'/',''),'-',''),' ',''),':','')  as bill FROM order_main   where order_id = $order_id ");

                                  $stmt->execute();
                                  $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
                                  ?>
                                  <div class="float-right m-2"><b>เลขที่ใบเสร็จ: </b><span><?php echo $result2['bill']; ?></span>
                                  </div>
                                  <span class="float-right m-2"> วันที่-เวลา
                                    <strong><?= $row['date']; ?></strong></span>
                                </div>
                              </div>
                            </div>
                            <!--- /.card-header --->

                            <div class="card-body">
                              <!--- ข้อมูลร้าน - ลูกค้า --->
                              <div class="row mb-4">
                                <div class="col-sm-6">
                                  <div><strong>Car Care คาร์แคร์ </strong></div>
                                  <div>
                                    <strong>ที่อยู่ :</strong> <span>69 สาทร ซอย 4 กรุงเทพมหานคร 10120</span>
                                  </div>
                                  <div>
                                    <strong>เบอร์โทร :</strong>
                                    <span>089-665-9986 </span>
                                  </div>
                                  <div>
                                    <strong>เลขประจำตัวผู้เสียภาษี :</strong>
                                    <span>1234567890999 </span>
                                  </div>
                                </div>

                                <div class="col-sm-6">
                                  <div>
                                    <strong>ชื่อ-นามสกุลลูกค้า:</strong>
                                    <span><?= $row['cus_fname'] . ' ' . $row['cus_lname']; ?></span>
                                  </div>
                                  <div>
                                    <strong>รถ:</strong>
                                    <span><?= $row['car_type']; ?></span>
                                    <strong>ยี่ห้อ:</strong>
                                    <span><?= $row['car_brand']; ?></span>
                                    <strong>รุ่น:</strong>
                                    <span><?= $row['car_series']; ?></span>
                                    <strong>เลขทะเบียน:</strong>
                                    <span><?= $row['car_id']; ?></span>
                                    <strong>เบอร์โทรศัพท์:</strong>
                                    <span><?= $row['cus_tel']; ?></span>
                                  </div>
                                </div>
                              </div>
                              <!--- /.ข้อมูลร้าน - ลูกค้า --->
                              <!----ตารางการบริการ---->
                              <div class="table">
                                <table class="table ">
                                  <thead>
                                    <tr>
                                      <th scope="col" class="text-center" style="width: 5%;">ลำดับ</th>
                                      <th scope="col" class="text-center" style="width: 15%;">บริการเริ่มต้น</th>
                                      <th scope="col" class="text-center">บริการเสริม</th>
                                      <th scope="col" class="text-center" style="width: 15%;">ค่าบริการ</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>1</td>
                                      <td><?= $row['service']; ?></td>
                                      <td></td>
                                      <td><?= $row['charge']; ?></td>
                                    </tr>
                                    <tr>
                                      <?php
                                      $order_id = $row['order_id'];
                                      $stmt = $conn->prepare("SELECT * FROM order_add_on  where order_id = $order_id");
                                      $stmt->execute();
                                      $result = $stmt->fetchAll();
                                      $num = 2;
                                      foreach ($result as $row2) {
                                      ?>

                                        <td><?= $num++ ?></td>
                                        <td></td>
                                        <td><?= $row2['add_service']; ?></td>
                                        <td><?= $row2['add_charge']; ?></td>
                                    </tr>
                                  <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                              <!----ตารางการบริการ---->
                              <!--start row -->
                            <div class="row">
                              <div class="col-4">
                                <strong>ลักษณะการชำระเงิน</strong>
                                <table class="table table-sm ">
                                  <tbody class="table ">
                                    <tr>
                                      <td>
                                        <strong>
                                          <?php
                                          if ($row['payment'] == 'Cash') {
                                            echo 'เงินสด';
                                          }
                                          if ($row['payment'] == 'Transfer-Money') {
                                            echo 'เงินโอน';
                                          }
                                          if ($row['payment'] == 'Credit-Card') {
                                            echo "บัตรเครดิต";
                                          }

                                          ?>
                                      </td>
                                      <td>
                                        <strong><?php echo $row['total']; ?></strong>
                                      </td>
                                      <td class="text-right">
                                        <strong>บาท</strong>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <!--/. row-->
                              <div class="col-lg-4 col-sm-5 ml-auto">
                                <table class="table ">
                                  <tbody>
                                    <tr>
                                      <td>
                                        <strong>รวม</strong>
                                      </td>
                                      <td class="text-right">
                                        <strong><?= $row['total']; ?></strong>
                                      </td>
                                      <td class="text-right">
                                        <strong>บาท</strong>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <!--/. row-->
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--/. ข้อมูลใบเสร็จ -->


                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                          <a href="../invoice-print.php?order_id=<?php echo $order_id ?>" rel="noopener" target="_blank" class="btn btn-primary">พิมพ์ใบเสร็จ</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/. Modal -->
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <!-- /.table-->

      </div>
    </div>
    <!-- /.card-body -->
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