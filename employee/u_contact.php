<?php
$menu = "u_contact";
include("../header_u.php");
?>


<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1><i class="nav-icon fas fa-id-card p-2"></i>ติดต่อ</h1>
  </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<section class="content">

  <!-- Stat card -->
  <div class="card">
    <div class="card-header card-navy card-outline bg-navy">
      <h5>รายชื่อพนักงาน</h5>
    </div>


    <!-- Stat card-body -->
    <div class="card-body bg-light ">

      <!-- Stat card -->
      <div class="card">
        <div class="card-body ">
          <div class="col-md-12">

            <!-- Stat table-->
            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
              <thead>
                <tr role="row" class="h6 text-center">
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;">ลำดับ</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 15%;">รูปประจำตัว</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">ข้อมูลส่วนตัว</th>
                  <th tabindex="0" rowspan="1" colspan="1">ตำแหน่ง</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">เบอร์โทรศัพท์</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">อีเมล์</th>
                </tr>
              </thead>

              <tbody class="h6">
                <?php
                $user_id = $_SESSION['employee_login'];
                $select_stmt = $conn->prepare("SELECT* FROM user WHERE user_status != 'Admin' and user_id != $user_id");
                $select_stmt->execute();
                $result = $select_stmt->fetchAll();
                $num = 0;
                foreach ($result as $row) {
                  $num++;
                ?>
                  <tr>
                    <td class="text-center"><?= $num ?></td>
                    <td class="text-center">
                      <img src="../pic_profile/<?= $row['img_profile']; ?>" width="100px" height="100px" class="img-circle">
                    </td>
                    <td>
                      <input hidden value="<?= $row['user_id']; ?>">
                    
                        <p><b>ชื่อ-นามสกุล : </b>
                          <?= $row['firstname'] . ' ' . $row['lastname']; ?>
                        </p>
                        <p><b>เพศ : </b><?php if ($row['gender'] == 'female') {
                                          echo "ผู้หญิง";
                                        } else {
                                          echo "ผู้ชาย";
                                        } ?>
                        </p>
                        <p><b>ที่อยู่ : </b><?= $row['address']; ?>
                        </p>
                    </td>
                    <td class="text-center"><?php if ($row['user_status'] == 'Manager') {
                                              echo "<b>ผู้จัดการ</b>";
                                            } else {
                                              echo "พนักงาน";
                                            }

                                            ?>
                    </td>
                    <td class="text-center"><?= $row['tel']; ?></td>
                    <td class="text-center"><?= $row['email']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <!-- /.table-->

          </div>
        </div>
      </div>
      <!-- /.card -->


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