<?php
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

    <!-- Stat card -->
    <div class="card">
        <div class="h4 card-header card-navy card-outline bg-navy">ข้อมูลลูกค้า/รถ</div>
        <!-- Stat card-body -->
        <div class="card-body bg-light ">
            <div class="container">

                <div class="card">
                    <form action="" method="post">
                        <div class="h5 card-header font-weight-bold text-center bg-primary">ข้อมูลลูกค้า/รถ</div>
                        <div class="card-body ">

                            <!-- Stat table-->
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row" class="h6 text-center">
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 22%;">ข้อมูลลูกค้า/รถ</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 12%;">เลขทะเบียน</th>
                                        <th tabindex="0" rowspan="1" colspan="1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text">
                                            <div><b>ชื่อ-นามสกุล :</b> วิราพร ยาประดิษฐ์</div>
                                            <div><b>เบอร์โทรศัพท์ :</b> 089-999-9999</div>
                                            <div><b>ประเภทรถ :</b> รถยนต์</div>
                                            <div><b>ยี่ห้อ :</b> mazda</div>
                                            <div><b>รุ่น :</b> mazda 3</div>
                                        </td>
                                        <td class="text-center">
                                            ฟง 6635
                                        </td>
                                        <td class="text-center">
                                            <!--------------------------------------------------------------------------------------------------------------------------------------->
                                            <div class="text-center">
                                                <a class="btn btn-success btn-md " type="submit" href="u_customer.php?cus_id=<?= $row['cus_id']; ?>&ms_id=<?= $row['ms_id']; ?>">สรุปรายการ</a>
                                                <a class="btn btn-primary btn-md " type="submit" href="u_customer11.php?cus_id=<?= $row['cus_id']; ?>&ms_id=<?= $row['ms_id']; ?>">เลือกบริการเสริม</a>
                                            </div>
                                            <!--------------------------------------------------------------------------------------------------------------------------------------->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- /. table-->
                        </div>
                    </form>
                </div>
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