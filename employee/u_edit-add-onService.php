<script type="text/javascript">
    var phpvar = "<?php echo $_GET['ms_id']; ?>";
</script>
<?php
$menu = "u_edit-add-onService";
include("../header_u.php");

if(isset($_GET['add_on_id'])){
    $stmt = $conn->prepare("SELECT* FROM add_on_service WHERE add_on_id=?");
    $stmt->execute([$_GET['add_on_id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($stmt->rowCount() < 1){
        header('Location: u_edit-all-service.php');
        exit();
    }
  }//isset
  if(isset($_POST['addOnServe_id'])) {

    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $add_on_id = $_POST['add_on_id'];
    $car_type = $_POST['car_type'];
    $add_onservice = $_POST['add_onservice'];
    $add_onservice_charge = $_POST['add_onservice_charge'];
    //sql update
    $stmt = $conn->prepare("UPDATE  add_on_service SET car_type=:car_type, add_onservice=:add_onservice, add_onservice_charge=:add_onservice_charge WHERE add_on_id=:add_on_id");
    $stmt->bindParam(':add_on_id', $add_on_id , PDO::PARAM_INT);
    $stmt->bindParam(':car_type', $car_type , PDO::PARAM_STR);
    $stmt->bindParam(':add_onservice', $add_onservice , PDO::PARAM_STR);
    $stmt->bindParam(':add_onservice_charge', $add_onservice_charge , PDO::PARAM_STR);
    $stmt->execute();
     
    // sweet alert 
        echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
     
     if($stmt->rowCount() > 0){
            echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "แก้ไขข้อมูล ..บริการเสริม.. สำเร็จ",
                      type: "success"
                  }, function() {
                      window.location = "u_add-onService.php?ms_id="+phpvar; //หน้าที่ต้องการให้กระโดดไป
                  });
                }, 1000);
            </script>';
        }else{
           echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "เกิดข้อผิดพลาด",
                      type: "error"
                  }, function() {
                      window.location = "u_add-onService.php?ms_id="+phpvar; //หน้าที่ต้องการให้กระโดดไป
                  });
                }, 1000);
            </script>';
        }
    } //isset
?>


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1><i class="nav-icon fas fa-list-alt p-2"></i>จัดการข้อมูลการรับบริการ</h1>
    </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<section class="content">
    <!-- Stat card -->
    <div class="card">
        <div class="card-header card-navy card-outline">
            <h5>แก้ไขข้อมูลการบริการเสริม</h5>
        </div>
      
        <!-- Stat card-body -->
        <div class="card-body">
            <form  class="form h6" action="" method="post">
                <div class="card-body ">
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ประเภทรถ</label>
                        <div class="col-md-4">
                            <input type="text" name="car_type" value="<?= $row['car_type']; ?>" class="form-control text-center" readonly  >
                        </div>
                    </div>
                    <!---/.ROW--->
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">บริการเสริม</label>
                        <div class="col-md-4">
                            <textarea type="text" name="add_onservice" class="form-control" required><?= $row['add_onservice']; ?></textarea>      
                        </div>
                    </div>
                    <!---/.ROW--->
                    <!---ROW--->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ค่าบริการ</label>
                        <div class="col-md-4">
                            <input type="number" name="add_onservice_charge" value="<?= $row['add_onservice_charge']; ?>" class="form-control text-center" required >
                        </div>
                        <label class="m-2 h6">บาท</label>
                    </div>
                    <!---/.ROW--->

                    <hr>
                    <input type="hidden" name="add_on_id" value="<?= $row['add_on_id'];?>">
                    <button type="submit" name="addOnServe_id" class="btn btn-success btn-lg ">บันทึกข้อมูล</h6></button>
                    <button type="reset" class="btn btn-danger btn-lg">ยกเลิก</button>
                    <a class="btn btn-outline-secondary btn-lg " href="u_add-onService.php?ms_id=<?= $row['ms_id']; ?>">ย้อนกลับ</a>
                </div>
                
            </form>

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