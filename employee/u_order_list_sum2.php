<?php
include("../header_u.php");
if (isset($_GET['ms_id'])) {
    $select_stmt = $conn->prepare("SELECT * FROM main_service  where ms_id=?");
    $select_stmt->execute([$_GET['ms_id']]);
    $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_GET['cus_id'])) {
    $select_stmt = $conn->prepare("SELECT * FROM customer where cus_id=?");
    $select_stmt->execute([$_GET['cus_id']]);
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
    $cus_id = $_GET['cus_id'];
    $select_stmt = $conn->prepare("SELECT * FROM customer where cus_id=$cus_id");
    $select_stmt->execute([$_GET['cus_id']]);
    $result = $select_stmt->fetch(PDO::FETCH_ASSOC);  ?>
    <!-- Stat card -->
    <div class="card">
        <div class="h4 card-header card-navy card-outline bg-navy">สรุปข้อมูลการรับบริการ</div>
        <!-- Stat card-body -->
        <div class="card-body bg-light ">
            <!---------------------------------------สรุปรายการ--------------------------------------------->
            <div class="card">
                <form action="u_order_list_sum_db2.php" method="post">
                    <div class="h2 card-header font-weight-bold text-center bg-success">สรุปรายการ</div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-6">
                                <div class="h3 text-center">ข้อมูลลูกค้า/รถ</div>
                                <hr>
                                <input type="text" hidden name="ms_id" value="<?php echo $result['ms_id']; ?>">

                                <input hidden type="text" name="cus_id" value="<?php echo $result['cus_id']; ?>">
                                <input hidden type="text" name="status" value="wait">

                                <div class="form-row h6">
                                    <div class="form-group col-md-4">
                                        <label>ชื่อ</label>
                                        <input type="text" value="<?php echo $result['cus_fname']; ?>" name="cus_fname" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>นามสกุล</label>
                                        <input type="text" value="<?php echo $result['cus_lname']; ?>" name="cus_lname" class="form-control" readonly>
                                        </select>
                                    </div>
                                    <div class="form-group  col-md-4">
                                        <label>เบอร์โทรศัพท์</label>
                                        <input type="number" value="<?php echo $result['cus_tel']; ?>" name="cus_tel" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-row h6">
                                    <div class="form-group col-md-4">
                                        <label>ยี่ห้อ</label>
                                        <input type="text" value="<?php echo $result['car_brand']; ?>" name="car_brand" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>รุ่น</label>
                                        <input type="text" value="<?php echo $result['car_series']; ?>" name="car_series" class="form-control" readonly>
                                        </select>
                                    </div>
                                    <div class="form-group  col-md-4">
                                        <label>เลขทะเบียน</label>
                                        <input type="text" value="<?php echo $result['car_id']; ?>" name="car_id" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-row h6">
                                    <?php
                                    if (isset($_SESSION['employee_login'])) {
                                        $user_id = $_SESSION['employee_login'];
                                        $stmt = $conn->query("SELECT * FROM user WHERE user_id = $user_id");
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                    ?>
                                        <div class="form-group col-md-4">
                                            <label>เจ้าหน้าที่</label>
                                            <input hidden type="text" name="user_id" value="<?php echo $result['user_id']; ?>">
                                            <input type="text" class="form-control text-center" name="admin" value="<?php echo $result['firstname']. ' ' .$result['lastname'] ; ?>" readonly>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- สรุปรายการการรับบริการ -->

                            <div class="col-6">
                                <div class="h3 text-center">รายการการรับบริการ</div>
                                <hr>
                                <!-- start table -->
                                <table class="table table-hover table-sm">
                                    <thead class="h6 bg-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 5%;">ลำดับ</th>
                                            <th scope="col" style="width: 35%;">บริการเริ่มต้น</th>
                                            <th scope="col">บริการเสริม</th>
                                            <th scope="col" class="text-center" style="width: 15%;">ค่าบริการ </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ms_id = $_GET['ms_id'];
                                        $stmt = $conn->prepare("SELECT * FROM main_service  where ms_id = $ms_id");
                                        $stmt->execute();
                                        $result = $stmt->fetchAll();
                                        $num = 1;
                                        $mscharge = 0;
                                        foreach ($result as $row) {
                                            $mscharge = $row['ms_charge'];
                                        ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $num++ ?></th>
                                                <td><?= $row['service']; ?>
                                                    <input type="text" hidden name="car_type" value="<?php echo $row['car_type']; ?>">
                                                    <input hidden type="text" name="service" value="<?php echo $row['service']; ?>">
                                                </td>
                                                <td></td>
                                                <td class="text-center"><?= $row['ms_charge']; ?>
                                                    <input hidden type="text" name="charge" value="<?php echo $row['ms_charge']; ?>">
                                                </td>

                                            </tr>
                                        <?php }

                                        $stmt = $conn->prepare("SELECT * FROM cart_service natural join add_on_service where ms_id = $ms_id");
                                        $stmt->execute();
                                        $result = $stmt->fetchAll();
                                        $num = 2;
                                        foreach ($result as $row) {
                                        ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $num++ ?></th>
                                                <td><input hidden type="text" name="add_on_id" value="<?= $row['add_on_id']; ?>"></td>
                                                <td><?= $row['add_onservice']; ?>
                                                    <input hidden type="text" name="add_onservice" value="<?= $row['add_onservice']; ?>">
                                                </td>
                                                <td class="text-center"><?= $row['add_onservice_charge']; ?>
                                                    <input hidden type="text" name="add_onservice_charge" value="<?= $row['add_onservice_charge']; ?>">
                                                </td>

                                            </tr>
                                        <?php } ?>

                                        <?php
                                        $stmt = $conn->prepare("SELECT *,sum(add_onservice_charge)as total_services FROM cart_service natural join add_on_service  natural join main_service where cus_id = $cus_id ");
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        if ($result) {
                                            $total = $result['total_services'] + $mscharge;
                                        } else {
                                            $total = $mscharge;
                                        }
                                        ?>
                                        
                                        <tr>
                                            
                                            <td colspan="2"></td>
                                            <td class="text-right"><b>รวม</b></td>
                                            <td class="text-center">
                                                <input hidden type="text" name="total" value="<?php echo $total; ?>">
                                                <b><?php echo number_format($total, 2); ?></b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- /.table -->
                            </div>
                        </div>
                        <!--------------------------------------------------------------------------------------------------------------------------------------->
                        <div class="text-center">
                            <a class="btn btn-outline-primary btn-lg " href="u_cart_service2.php?cus_id=<?php echo $cus_id; ?>&ms_id=<?php echo $ms_id; ?>">เพิ่มบริการเสริม</a>
                            <button class="btn btn-success btn-lg text-light" name="submit_order" type="submit">บันทึกข้อมูล</button>
                            <a href="u_order_list_del2.php?cus_id=<?php echo $cus_id; ?>" class="btn btn-danger btn-lg" onclick="return confirm('ยืนยันการลบข้อมูล !!');">ยกเลิก</a>
                        </div>
                        <!--------------------------------------------------------------------------------------------------------------------------------------->
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
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