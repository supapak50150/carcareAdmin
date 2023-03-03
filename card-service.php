<head>
  <style>
    .img {
      margin: auto;
      width: 200px;
      height: 200px;

    }
  </style>
</head>

<!-- start card-body -->
<div class="card-body">
  <!-- start row -->
  <div class="row">
    <?php if (isset($_SESSION['employee_login'])) { ?>
      <!-- /. card a -->
      <div class="col-lg-4 col-6 p-1">
        <!-- card b -->
        <div class="card ">
          <h4 class="card-header bg-info text-center">ผลการค้นหา</h4>
          <div class="card-body">
            <!-- Stat table-->
            <table id="example" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
              <thead>
                <tr role="row" class="h6 text-center">
                  <th tabindex="0" rowspan="1" colspan="1">ข้อมูลลูกค้า/รถ</th>
                  <th tabindex="0" rowspan="1" colspan="1">เลขทะเบียน</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 30%;"></th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($_SESSION['error'])) : ?>
                  <div class="alert alert-danger text-center">
                    <h4>
                      <?php
                      echo $_SESSION['error'];
                      unset($_SESSION['error']);
                      ?>
                    </h4>
                  </div>
                <?php endif ?>
                <?php
                if (isset($_GET['car_id']) && $_GET['car_id'] != '') {
                  $car_id = $_GET['car_id'];

                  $stmt1 = $conn->prepare("SELECT * FROM customer WHERE car_id LIKE '%$car_id%'");
                  $stmt1->execute();
                  $result1 = $stmt1->fetchAll();
                  foreach ($result1 as $rw) {
                    $ms_id = $rw['ms_id'];
                  }
                  $stmt = $conn->prepare("SELECT * FROM customer natural join main_service WHERE car_id LIKE '%$car_id%'and ms_id = '$ms_id' ");
                  $stmt->execute();
                  $result = $stmt->fetchAll();
                  foreach ($result as $row) {
                    if (isset($row['ms_id']) != ($rw['ms_id']) ){
                      $_SESSION['error'] = 'ไม่มีบริการนี้อยู่ในระบบแล้ว';
                    }
                ?>

                    <tr>
                      <td>
                        <div><b>ชื่อ-นามสกุล :</b> <?= $row['cus_fname'] . ' ' . $row['cus_lname']; ?></div>
                        <div><b>เบอร์โทรศัพท์ :</b> <?= $row['cus_tel']; ?></div>
                        <div><b>ประเภทรถ :</b><?= $row['car_type']; ?></div>
                        <div><b>ยี่ห้อ :</b><?= $row['car_brand']; ?></div>
                        <div><b>รุ่น :</b> <?= $row['car_series']; ?></div>
                      </td>
                      <td class="text-center">
                        <?= $row['car_id']; ?>
                      </td>
                      <td class="text-center">
                        <!--------------------------------------------------------------------------------------------------------------------------------------->
                        <div class="text-center">
                          <div><a class="btn btn-success btn-sm m-1" type="submit" href="u_order_list_sum2.php?cus_id=<?= $row['cus_id']; ?>&ms_id=<?= $row['ms_id']; ?>">สรุปรายการ</a></div>
                          <div><a class="btn btn-primary btn-sm " type="submit" href="u_cart_service2.php?cus_id=<?= $row['cus_id']; ?>&ms_id=<?= $row['ms_id']; ?>">เลือกบริการเสริม</a></div>
                        </div>
                        <!--------------------------------------------------------------------------------------------------------------------------------------->
                      </td>
                    </tr>
                <?php }
                  
                } ?>
              </tbody>
            </table>
            <!-- /. table-->
          </div>
        </div>
        <!-- /.card b -->
      </div>
      <!-- /. card a -->
    <?php } ?>



    <?php
    $stmt = $conn->prepare("SELECT * FROM main_service");
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
    ?>
      <!-- /. card a -->
      <div class="col-lg-2-sm-4 p-1">
        <!-- card b -->
        <div class="card text-center">
          <p hidden><?= $row['ms_id']; ?></p>
          <h5 class="card-header bg-primary"><?= $row['car_type']; ?></h5>
          <a><img src="../pic_car/<?= $row['img_car']; ?>" width="190px " height="140px"></a>

          <div class="card-body text-lg ">
            <?php if (isset($_SESSION['employee_login'])) { ?>
              <a class="btn btn-success btn-block " href="u_cart_customer.php?ms_id=<?= $row['ms_id']; ?>">เลือกบริการ</a>
            <?php } ?>
          </div>
        </div>
        <!-- /.card b -->
      </div>
      <!-- /. card a -->
    <?php } ?>

  </div>
  <!-- /.row -->
</div>
<!-- /.card-body -->