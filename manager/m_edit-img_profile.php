<?php
$menu = "m_edit-img_profile";
include("../header_m.php");
if (isset($_REQUEST['user_id'])) {
  try {
    $user_id = $_REQUEST['user_id'];
    $select_stmt = $conn->prepare("SELECT * FROM admins WHERE user_id = $user_id");
    $select_stmt->execute();
    $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
    extract($result);
  } catch (PDOException $e) {
    $e->getMessage();
  }
}
if (isset($_REQUEST['btn_update'])) {
  try {

    $image_file = $_FILES["img_profile"]["name"];
    $type = $_FILES['img_profile']['type'];
    $size = $_FILES['img_profile']['size'];
    $temp = $_FILES['img_profile']['tmp_name'];


    $folder = "../pic_profile/" . $image_file;
    $dir = "../pic_profile/"; // set uplaod folder folder for upadte time previos file remove and new file upload for next use

    if ($image_file) {
      if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png") {
        if ($size < 5000000) { // check file size 5MB
          unlink($dir . $result['img_profile']); // unlink functoin remove previos file
          move_uploaded_file($temp, '../pic_profile/' . $image_file); // move upload file temperory dir to your upload folder
        } else {
          $errorMsg = "ไฟล์ของคุณมีขนาดใหญ่ โปรดอัปโหลดขนาด 5MB";
        }
      } else {
        $errorMsg = "โปรดอัปโหลดรูปแบบ JPG, JPEG, PNG";
      }
    } else {
      $image_file = $result['img_profile']; // if you not select new image than previos image same it is it.
    }

    if (!isset($errorMsg)) {
      $update_stmt = $conn->prepare("UPDATE user SET  img_profile = :file_up WHERE user_id = $user_id");
      $update_stmt->bindParam(':file_up', $image_file);

      if ($update_stmt->execute()) {
        $updateMsg = "File update successfully...";
?>
        <script>
          window.location = "m_edit-img_profile.php";
        </script>
<?php }
    }
  } catch (PDOException $e) {
    $e->getMessage();
  }
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluname">
    <h1><i class="nav-icon fas fa-user-edit p-2"></i>เปลี่ยนรูปประจำตัว</h1>
  </div>
</section>
<!-- /.container-fluname -->

<!-- Main content -->
<section class="content">

  <!-- Stat card -->
  <div class="card">
    <div class="card-header card-navy card-outline bg-navy">
      <h5>เปลี่ยนรูปประจำตัว</h5>
    </div>
    <div class="card-body bg-light">

      <!-- Stat card form -->
      <div class="card h5">
        <div class="card-body">

          <form name="profile-form" class="form" action="" method="post" enctype="multipart/form-data">
            <div class="text-center ">
              <label class="form-label m-2 h1 ">รูปประจำตัว</label>
              <div><img src="../pic_profile/<?php echo $result['img_profile'] ?>" width="205px" height="200px" class="img-circle elevation-2 m-2"></div>
              <br>
              <input type="file" name="img_profile" accept="image/jpeg, image/png, image/jpg" required>
            </div>
            <hr>
            <div class="text-center ">
              <input type="submit" name="btn_update" class="btn btn-success btn-lg " value="เปลี่ยนรูปประจำตัว">
            </div>
          </form>
          <!---/.form--->

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