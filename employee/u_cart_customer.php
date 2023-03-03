<script type="text/javascript">
  var phpvar = "<?php echo $_GET['ms_id']; ?>";
</script>
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
    <h1><i class="nav-icon fas fa-car p-2"></i>การรับบริการ</h1>
  </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<section class="content">
  <?php
  $car_id = $_GET['ms_id'];
  $stmt = $conn->prepare("SELECT * FROM main_service where ms_id = $car_id ");
  $stmt->execute([$_GET['ms_id']]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  ?>
  <!-- Stat card -->
  <div class="card">
    <div class="h4 card-header card-navy card-outline bg-navy">ข้อมูลลูกค้า/รถ</div>

    <!-- Stat card-body -->
    <div class="card-body bg-light ">
      <div class="container">
        <form action="u_cart_customer_db.php" method="post">
          <!---------------------------ข้อมูลลูกค้า/รถ----------------------------->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="h5 card-header font-weight-bold text-center" style="background-color:#90CAF9;">กรอกข้อมูลลูกค้า/รถ</div>
                <div class="card-body ">
                  <h4 class="text-center text-light">
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

                  </h4>
                  <input hidden type="text" name="ms_id" value="<?php echo $car_id; ?>">
                  <div class="form-row h6">
                    <div class="form-group col-md-4">
                      <label>ชื่อ</label>
                      <input type="text" class="form-control" name="cus_fname"  required>
                    </div>
                    <div class="form-group col-md-4">
                      <label>นามสกุล</label>
                      <input type="text" class="form-control" name="cus_lname" required>
                      </select>
                    </div>
                    <div class="form-group  col-md-4">
                      <label>เบอร์โทรศัพท์</label>
                      <input type="number" class="form-control" name="cus_tel" required>
                    </div>
                  </div>
                  <div class="form-row h6">
                    <div class="form-group col-md-4">
                      <label>ยี่ห้อ</label>
                      <input type="text" class="form-control" name="car_brand" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label>รุ่น</label>
                      <input type="text" class="form-control" name="car_series" required>
                      </select>
                    </div>
                    <div class="form-group  col-md-4">
                      <label>เลขทะเบียน</label>
                      <input type="text" class="form-control" name="car_id" required>
                    </div>
                  </div>
                  <!---------------------------/.ข้อมูลลูกค้า/รถ----------------------------->
                  <div class="text-center">
                    <button type="submit" name="btn_customer" class="btn btn-success btn-lg ">ถัดไป</h6></button>
                    <button type="reset" class="btn btn-danger btn-lg">ยกเลิก</button>
                    <a class="btn btn-outline-secondary btn-lg " href="u_serve.php">ย้อนกลับ</a>
                  </div>
                  <!--------------------------------------------------------------------->
                </div>
              </div>
            </div>
          </div>
        </form>
      </div><!-- /.card-body -->
    </div>
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