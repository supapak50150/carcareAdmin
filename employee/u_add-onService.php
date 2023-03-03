<script type="text/javascript">
    var phpvar = "<?php echo $_GET['ms_id']; ?>";
</script>
<?php
$menu = "u_add-onService";
include("../header_u.php");

if (isset($_GET['ms_id'])) {
    $select_stmt = $conn->prepare("SELECT * FROM main_service where ms_id=?");
    $select_stmt->execute([$_GET['ms_id']]);
    $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_REQUEST['btn_add_on'])) {
    $car_type = $_REQUEST['car_type'];
    $add_onservice = $_REQUEST['add_onservice'];
    $add_onservice_charge = $_REQUEST['add_onservice_charge'];
    $ms_id = $_REQUEST['ms_id'];

    $insert_stmt = $conn->prepare("INSERT INTO add_on_service (car_type,add_onservice,add_onservice_charge,ms_id)
    VALUES (:car_type,:add_onservice,:add_onservice_charge,:ms_id)");
    $insert_stmt->bindParam(':car_type', $car_type, PDO::PARAM_STR);
    $insert_stmt->bindParam(':add_onservice', $add_onservice, PDO::PARAM_STR);
    $insert_stmt->bindParam(':add_onservice_charge', $add_onservice_charge, PDO::PARAM_STR);
    $insert_stmt->bindParam(':ms_id', $ms_id, PDO::PARAM_STR);
    $result = $insert_stmt->execute();
    // sweet alert 


    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    if ($result) {
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "เพิ่มข้อมูล ..บริการเสริม.. สำเร็จ",
                  type: "success"
              }, function() {
                  window.location.href = "u_add-onService.php?ms_id="+phpvar; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    } else {
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
}


if (isset($_REQUEST['add_on_id'])) {
    $add_on_id = $_REQUEST['add_on_id'];
    $del_stmt = $conn->prepare('DELETE FROM add_on_service WHERE add_on_id=:add_on_id');
    $del_stmt->bindParam(':add_on_id', $add_on_id, PDO::PARAM_INT);
    $del_stmt->execute();
    //  sweet alert 
    echo '
      <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    if ($del_stmt->rowCount() > 0) {
        echo '<script>
        setTimeout(function() {
         swal({
             title: "ลบข้อมูล ..บริการเสริม.. สำเร็จ",
             type: "success"
         }, function() {
             window.location.href = "u_add-onService.php?ms_id="+phpvar; //หน้าที่ต้องการให้กระโดดไป
         });
       }, 1000);
   </script>';
    } else {
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
        <h1><i class="nav-icon fas fa-list-alt p-2"></i>เพิ่มข้อมูลบริการเสริม</h1>
    </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<?php
$car_id = $_GET['ms_id'];
$stmt = $conn->prepare("SELECT * FROM main_service where ms_id = $car_id ");
$stmt->execute([$_GET['ms_id']]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<section class="content">

    <!-- Stat card -->
    <div class="card">
        <div class="card-header card-navy card-outline">
            <p class="h5 ">ข้อมูลบริการเสริม.. <?php echo $result['car_type']; ?></p>
        </div>

        <!-- Stat card-body -->
        <div class="card-body">
            <!-- Stat card 02 -->
            <div class="card">
                <div class="card-body">
                    <!------------------------------เพิ่มบริการเสริม---------------------------------->
                    <form id="add_on_service" class="h5" action="" method="post">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>ประเภทรถ</label>
                                <input type="text" hidden name="ms_id" value="<?php echo $car_id; ?>">
                                <input type="text" name="car_type" value="<?php echo $result['car_type']; ?>" class="form-control text-center" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>บริการเสริม</label>
                                <input type="text" name="add_onservice" class="form-control" required>
                                </select>
                            </div>
                            <div class="form-group  col-md-4">
                                <label>ค่าบริการ</label>
                                <input type="number" name="add_onservice_charge" class="form-control" required>
                            </div>
                        </div>
                        <div class="text-right"><button type="submit" name="btn_add_on" class="btn btn-success btn-lg">บันทึกข้อมูล</button>
                            <button type="reset" class="btn btn-danger btn-lg">ยกเลิก</button>
                            <a class="btn btn-outline-secondary btn-lg " href="u_edit-all-service.php">ย้อนกลับ</a>

                        </div>

                    </form>
                    <!-----------------------------/.เพิ่มบริการเสริม---------------------------------->
                    <hr>
                    <!-- Stat table-->
                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row" class="h6 text-center">
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;">ลำดับ</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">ประเภทรถ</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 40%;">บริการเสริม</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 15%;">ค่าบริการ</th>
                                <th tabindex="0" rowspan="1" colspan="1"></th>
                        </thead>
                        <tbody>
                            <?php

                            $stmt = $conn->prepare("SELECT * FROM add_on_service where ms_id = $car_id");
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
                                        <a href="u_edit-add-onService.php?add_on_id=<?= $row['add_on_id']; ?>&ms_id=<?= $row['ms_id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt"></i> แก้ไข</a>
                                        <a href="u_add-onService.php?add_on_id=<?= $row['add_on_id']; ?>&ms_id=<?= $row['ms_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล !!');">
                                            <i class="fas fa-trash-alt"></i> ลบ</a>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                    <!-- /.table-->

                </div>
            </div>
            <!-- /.card 02-->
        </div>
        <!-- /.card-body -->
    </div>


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