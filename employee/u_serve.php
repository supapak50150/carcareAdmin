<?php
$menu = "u_serve";
include("../header_u.php"); 

if (isset($_GET['car_id']) && $_GET['car_id']!='') {
 
  //ประกาศตัวแปรรับค่าจากฟอร์ม
  $car_id = "%{$_GET['car_id']}%";

  //คิวรี่ข้อมูลมาแสดงจากการค้นหา
  $stmt = $conn->prepare("SELECT * FROM customer WHERE car_id LIKE ?");
  $stmt->execute([$car_id]);
  $stmt->execute();
  $result = $stmt->fetchAll();
}else{
   //คิวรี่ข้อมูลมาแสดงตามปกติ *แสดงทั้งหมด
  $stmt = $conn->prepare("SELECT * FROM customer");
  $stmt->execute();
  $result = $stmt->fetchAll();
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
  <div class="card">
    <div class="card-header card-navy card-outline bg-navy">
      <h5>สถานะการรับบริการ</h5>
      <?php include("u_tabStatus.php"); ?>
      <div class="col-lg ">
        <form class="form-inline" action="u_serve.php" method="get">
          <label for="inputCarNum" class="text-md m-2">ค้นหาเลขทะเบียนรถ</label>
          <input class="form-control mr-sm-2" name="car_id" required type="text" 
          value="<?php if (isset($_GET['car_id'])) {
            echo $_GET['car_id'];} ?>" placeholder="ระบุเลขทะเบียนรถ" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
          <a  href="u_serve.php" class="btn btn-warning m-1">ล้างการค้นหา</a>
        </form>
      </div>
    </div>
  </div>
  <?php include("../card-service.php"); ?>
  
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