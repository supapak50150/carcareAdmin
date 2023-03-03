<?php
$menu = "m_serve";
include("../header_m.php");
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
      <?php include("m_tabStatus.php"); ?>
    </div></div>
   <!-- Stat card-body-->
   <div class="card-body bg-light ">
      <!------------------------------บริการหลัก---------------------------------->
      <!-- Stat card 01 -->
      <div class="card ">
        <div class="card-body  ">
          <!-- start col -->
          <div class="col-md-12">
            <p class="h3 text-center"><strong>บริการเริ่มต้น</strong></p>
            <!-- start table -->
            <table class="table">
              <thead>
                <tr class="h6 bg-light text-center">
                  <th scope="col" style="width: 15%;">รูปภาพ</th>
                  <th scope="col" style="width: 15%;">ประเภทรถ</th>
                  <th scope="col">บริการเริ่มต้น</th>
                  <th scope="col" style="width: 15%;">ค่าบริการ</th>
                  <th scope="col" style="width: 15%;"></th>
                </tr>
              </thead>

              <tbody>
                <?php
                //require_once 'config/db.php';
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
                      <a href="m_add-onService.php?ms_id=<?= $row['ms_id']; ?>" class="btn btn-primary btn-sm">
                      <i class="fas fa-arrow-right"></i> บริการเสริม </a>
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