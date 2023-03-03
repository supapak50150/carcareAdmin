<script type="text/javascript">
    var phpvar = "<?php echo $_GET['ms_id']; ?>";
</script>
<?php
$menu = "m_add-onService";
include("../header_m.php");

if (isset($_GET['ms_id'])) {
    $select_stmt = $conn->prepare("SELECT * FROM main_service where ms_id=?");
    $select_stmt->execute([$_GET['ms_id']]);
    $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1><i class="nav-icon fas fa-list-alt p-2"></i>ข้อมูลบริการเสริม</h1>
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
            <p class="h5 ">ข้อมูลการบริการเสริม.. <?php echo $result['car_type']; ?></p>
        </div>

        <!-- Stat card-body -->
        <div class="card-body">
            <!-- Stat card 02 -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <a class="btn btn-dark btn-lg " href="m_serve.php"><i class="fas fa-arrow-left"></i> ย้อนกลับ</a>
                        </div>
                        <div class="col-6">
                            <a class="h3"><strong>บริการเสริม.. <?php echo $result['car_type']; ?></strong></a>
                        </div>
                    </div>
                    <hr>
                    <!-- Stat table-->

                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row" class="h6 text-center">
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;">ลำดับ</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">ประเภทรถ</th>
                                <th tabindex="0" rowspan="1" colspan="1">บริการเสริม</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width: 15%;">ค่าบริการ</th>

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