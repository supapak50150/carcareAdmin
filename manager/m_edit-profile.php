<?php
$menu = "m_edit-profile";
include("../header_m.php");

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluname">
    <h1><i class="nav-icon fas fa-user-edit p-2"></i>แก้ไข้บัญชีผู้ใช้</h1>
  </div>
</section>
<!-- /.container-fluname -->

<!-- Main content -->
<section class="content">

  <!-- Stat card -->
  <div class="card">
    <div class="card-header card-navy card-outline bg-navy">
      <h5>ข้อมูลส่วนบุคคล</h5>
    </div>
    <div class="card-body bg-light">

      <!-- Stat card form -->
      <div class="card h5">
        <div class="card-body">
          <?php
          if (isset($_SESSION['manager_login'])) {
            $user_id = $_SESSION['manager_login'];
            $select_stmt = $conn->prepare("SELECT * FROM user WHERE user_id = $user_id");
            $select_stmt->execute();
            $result = $select_stmt->fetch(PDO::FETCH_ASSOC);

          ?>
            <form name="profile-form" class="form" action="m_edit-profile_db.php" method="post">

              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-inline">
                    <label class="form-label m-2">ตำแหน่ง</label>
                    <input type="text" name="user_status" value="<?php if ($result['user_status'] == 'Manager') {
                                              echo "ผู้จัดการ";
                                            } else {
                                              echo "พนักงาน";
                                            }

                                            ?>" readonly class="form-control form-control-md text-center m-2">
                  </div>
                  <div class="form-inline">
                    <label class="form-label m-2">Username</label>
                    <input type="text" name="username" value="<?= $result['username']; ?>" readonly class="form-control form-control-md text-center m-2">
                  </div>
                </div>

                <div class="col-md-6 mb-4">
                  <div class="form-group row">
                    <label for="username" class="m-2">เวลาลงทะเบียน</label>
                    <div>
                      <input type="text" name="datetime" value="<?= $result['created']; ?>" readonly class="form-control form-control-md text-center">
                    </div>
                  </div>
                </div>
              </div>


              <div class="form-inline">
                <label class="form-label m-2 ">ชื่อ - นามสกุล</label>
                <input type="text" name="firstname" value="<?php echo $result['firstname'] ?>" class="form-control form-control-md m-2 text-center" required>
                <input type="text" name="lastname" value="<?php echo $result['lastname'] ?>" class="form-control form-control-md text-center" required>
              </div>
              <div class="form-inline">
                <label class="form-label m-2 ">อีเมล์</label>
                <input type="email" name="email" readonly value="<?php echo $result['email'] ?>" class="form-control form-control-md m-2 text-center" required>
                &nbsp;
                <label class="form-label m-2">เบอร์โทรศัพท์</label>
                <input type="number" name="tel" value="<?php echo $result['tel'] ?>" class="form-control form-control-md m-2 text-center" required>
              </div>
              <div class="form-inline">
                <label class="form-label m-2 ">ที่อยู่ปัจจุบัน</label>
                <textarea type="text" name="address" class="form-control form-control-md m-2" required><?php echo $result['address'] ?></textarea>
              </div>

              <hr>
              <input type="hidden" name="user_id" value="<?php echo  $user_id; ?>">
              <input type="submit" name="id" class="btn btn-success btn-lg " value="บันทึกข้อมูล">
              <button type="reset" class="btn btn-danger btn-lg">ยกเลิก</button>

            </form>
            <!---/.form--->
          <?php } ?>
        </div>
      </div>
      <!-- Stat card form -->

    </div> <!-- /.card-body -->

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
      "autoWnameth": false,
    });
  });
</script>
</body>

</html>