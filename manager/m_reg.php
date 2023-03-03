<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/dist/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&display=swap" rel="stylesheet">

  <title>ลงทะเบียน</title>
  <style>
    body {
      background: #6a11cb;

      /* Chrome 10-25, Safari 5.1-6 */
      background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

      /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
      font-family: 'Bai Jamjuree', sans-serif;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>

</head>

<body>

  <section class="vh-100 gradient-custom">
    <div class="container  h-100">
      <div class="row d-flex justify-content-center align-items-top h-100">
        <div class="col-12 col-md-8 ">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 ">

              <div class="mb-md-8 mt-md-6 ">
                <form action="m_register_db.php" method="post" enctype="multipart/form-data">
                  <h2 class="fw-bold mb-2 text-uppercase text-center">ลงทะเบียน</h2>
                  <p class="text-white-50 mb-4 text-center">พนักงาน ร้านคาร์แคร์</p>
                  <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success">
                      <h4>
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                      </h4>
                    </div>
                  <?php endif ?>

                  <?php if (isset($_SESSION['warning'])) : ?>
                    <div class="alert alert-warning">
                      <h4>
                        <?php
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                        ?>
                      </h4>
                    </div>
                  <?php endif ?>
                  <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger">
                      <h4>
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                      </h4>
                    </div>
                  <?php endif ?>
                  <!---form-group--->
                  <input hidden type="text" name="user_status" value="Employee" class="form-control text-center" required>
                    
                  <!---/.form-group--->

                  <!---form-group--->
                  <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group mb-3">
                      <input type="text" name="username" class="form-control" required>
                    </div>
                  </div>
                  <!---/.form-group--->

                  <!---ROW--->
                  <div class="row">
                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <label>รหัสผ่าน</label>
                        <input type="password" name="password" class="form-control" required>
                        <small id="passwordHelp" class="form-text text-muted">*รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัว</small>
                      </div>
                    </div>

                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <label>ยืนยันรหัสผ่านอีกครั้ง</label>
                        <input type="password" name="c_password" class="form-control" required>
                      </div>
                    </div>
                  </div>
                  <!---/.ROW--->


                  <!---ROW--->
                  <div class="row">
                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <label class="form-label" for="firstname">ชื่อ</label>
                        <input type="text" name="firstname" class="form-control form-control-md" required>
                      </div>
                    </div>

                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <label class="form-label" for="lastname">นามสุกล</label>
                        <input type="text" name="lastname" class="form-control form-control-md" required>
                      </div>
                    </div>
                  </div>
                  <!---/.ROW--->

                  <!---ROW--->
                  <div class="row">
                    <div class="col-md-6 mb-4 d-flex align-items-center">
                      <div class="form-outline datepicker w-100">
                        <label for="address" class="form-labe">ที่อยู่ปัจจุบัน</label>
                        <textarea type="text" name="address" class="form-control form-control-md" required></textarea>
                      </div>

                    </div>
                    <div class="col-md-6 mb-4">

                      <h6 class="mb-2 pb-1 ">เพศ: </h6>
                      <!---form-group--->
                      <div class="form-group">
                        <select class="form-control" name="gender" >
                          <option value="" selected="selected">-- เลือก --</option>
                          <option value="female">หญิง</option>
                          <option value="male">ชาย</option>
                        </select>
                      </div>
                      <!---/.form-group--->
                    </div>
                  </div>
                  <!---/.ROW--->

                  <!---ROW--->
                  <div class="row">
                    <div class="col-md-6 mb-4 pb-2">
                      <div class="form-outline">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" name="email" class="form-control form-control-md" required>
                      </div>

                    </div>

                    <div class="col-md-6 mb-4 pb-2">
                      <div class="form-outline">
                        <label class="form-label" for="tel">เบอร์โทรศัพท์มือถือ</label>
                        <input type="number" name="tel" class="form-control form-control-md" required>
                      </div>
                    </div>
                  </div>
                  <!---/.ROW--->

                  <!---form-group--->
                  <div class="form-group">
                    <label for="imgProfile">กรุณาเลือกรูปประจำตัว</label>
                    <input type="file" class="form-control-file" name="img_profile" required accept="image/jpeg, image/png, image/jpg">
                    <small class="form-text text-danger ">*รูปภาพต้องเป็นไฟล์ JPG, JPEG, PNG </small>
                  </div>
                  <!--- /.form-group--->


                  <hr class="bg-secondary ">
                  <div class="text-center">
                    <!---ROW--->
                    <div class="row">
                      <div class="col-md-6 ">
                        <button class="btn btn-primary btn-lg btn-block " type="submit" name="btn_reg" value="register">ตกลง</button>
                      </div>

                      <div class="col-md-6 ">
                        <a class="btn btn-outline-secondary btn-lg  btn-block" href="m_member.php">ย้อนกลับ

                        </a>
                      </div>
                    </div>
                    <!---/.ROW--->
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>









  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>