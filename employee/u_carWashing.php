<?php
$menu = "u_carWashing";
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
          <p class="h2"><strong>รายการที่..กำลังดำเนินการ</strong></p>
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
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">เวลา</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;">ปรับสถานะ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">แก้ไขบริการเสริม</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;">ยกเลิก</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $stmt = $conn->prepare("SELECT * FROM order_main natural join customer  where status = 'wash' ");
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
                  <td class="text-center"><?= $row['date']; ?></td>
                  <td class="text-center">
                    <input hidden value="<?= $row['order_id']; ?>">
                    <a class="btn btn-success btn-md" href="u_carWashing_update_stmt.php?order_id=<?= $row['order_id']; ?>" onclick="return confirm('ยืนยันการปรับสถานะ !!');">
                      เสร็จแล้ว
                    </a>
                  </td>
                  <td class="text-center">
                    <input hidden value="<?= $row['order_id']; ?>">

                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal<?php echo $row['order_id']; ?>">
                      แก้ไขบริการเสริม
                    </button>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?php echo $row['order_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">บริการเสริม</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <hr>
                            <input type="text" hidden name="ms_id" value="<?php echo $row['ms_id']; ?>">

                            <input hidden type="text" name="cus_id" value="<?php echo $row['cus_id']; ?>">
                            <input hidden type="text" name="status" value="wait">

                            <div class="form-row h6">
                              <div class="form-group col-md-4">
                                <input type="text" value="<?php echo $row['cus_fname']; ?>" name="cus_fname" class="form-control text-center " readonly>
                              </div>
                              <div class="form-group col-md-4">
                                <input type="text" value="<?php echo $row['cus_lname']; ?>" name="cus_lname" class="form-control text-center" readonly>
                                </select>
                              </div>
                              <div class="form-group  col-md-4">
                                <input type="number" value="<?php echo $row['cus_tel']; ?>" name="cus_tel" class="form-control text-center" readonly>
                              </div>
                            </div>
                            <div class="form-row h6">
                              <div class="form-group col-md-4">
                                <input type="text" value="<?php echo $row['car_brand']; ?>" name="car_brand" class="form-control text-center" readonly>
                              </div>
                              <div class="form-group col-md-4">
                                <input type="text" value="<?php echo $row['car_series']; ?>" name="car_series" class="form-control text-center" readonly>
                                </select>
                              </div>
                              <div class="form-group  col-md-4">
                                <input type="text" value="<?php echo $row['car_id']; ?>" name="car_id" class="form-control text-center" readonly>
                              </div>
                            </div>


                            <hr>

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
                                $stmt = $conn->prepare("SELECT * FROM order_main natural join customer  where order_id = $order_id ");
                                $stmt->execute();
                                $result = $stmt->fetchAll();
                                $num = 1;
                                $mscharge = 0;
                                foreach ($result as $r) {
                                  $mscharge = $r['charge'];
                                ?>

                                  <tr>
                                    <th scope="row" class="text-center"><?= $num++ ?></th>
                                    <td><?= $r['service']; ?></td>
                                    <td></td>
                                    <td class="text-center"><?= $r['charge']; ?></td>
                                    <td></td>
                                  </tr>
                                <?php }
                                $stmt = $conn->prepare("SELECT * FROM order_add_on where order_id = $order_id   ");
                                $stmt->execute();
                                $result = $stmt->fetchAll();
                                $num = 2;
                                foreach ($result as $row3) {
                                ?>
                                  <tr>
                                    <th scope="row" class="text-center"><?= $num++ ?></th>
                                    <td></td>
                                    <td><?= $row3['add_service']; ?></td>
                                    <td class="text-center"><?= $row3['add_charge']; ?></td>
                                    <td><!----ลบ---->
                                      <a href="u_carWashing_del-add-on.php?add_on_id=<?= $row3['add_on_id']; ?>&order_id=<?= $row3['order_id']; ?>&add_charge=<?= $row3['add_charge']; ?>" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                      </a>
                                    </td>
                                  </tr>
                                <?php } ?>
                                <?php

                                $stmt = $conn->prepare("SELECT * FROM order_main  where order_id = $order_id ");
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                
                                ?>
                                <tr>
                                  <td colspan="2"></td>
                                  <td class="text-right"><b>รวม</b></td>
                                  <td class="text-center"><?php echo  $result['total']; ?>
                                  </td>
                                  <td class="text-left"><b>บาท</b></td>
                                </tr>
                              </tbody>
                            </table>
                            <!-- /.table -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--/. Modal -->
                  </td>
                  <td class="text-center">
                    <input hidden value="<?= $row['order_id']; ?>">
                    <a class="btn btn-danger btn-md" href="u_carWashing_cancel_stmt.php?order_id=<?= $row['order_id']; ?>" onclick="return confirm('ยกเลิกรายการ !!');">
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