<?php
require_once 'config/db.php';

if (isset($_GET['order_id'])) {
  $select_stmt = $conn->prepare("SELECT * FROM order_main where order_id=?");
  $select_stmt->execute([$_GET['order_id']]);
  $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
}


$stmt = $conn->prepare("SELECT * FROM order_main natural join customer natural join main_service where status = 'successfully' ");
$stmt->execute();
//$result = $stmt->fetchAll();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invoice Print</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css?v=3.2.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script nonce="4775add6-3964-44f3-ae64-ee67dfe11900">
    (function(w, d) {
      ! function(a, e, t, r) {
        a.zarazData = a.zarazData || {};
        a.zarazData.executed = [];
        a.zaraz = {
          deferred: [],
          listeners: []
        };
        a.zaraz.q = [];
        a.zaraz._f = function(e) {
          return function() {
            var t = Array.prototype.slice.call(arguments);
            a.zaraz.q.push({
              m: e,
              a: t
            })
          }
        };
        for (const e of ["track", "set", "debug"]) a.zaraz[e] = a.zaraz._f(e);
        a.zaraz.init = () => {
          var t = e.getElementsByTagName(r)[0],
            z = e.createElement(r),
            n = e.getElementsByTagName("title")[0];
          n && (a.zarazData.t = e.getElementsByTagName("title")[0].text);
          a.zarazData.x = Math.random();
          a.zarazData.w = a.screen.width;
          a.zarazData.h = a.screen.height;
          a.zarazData.j = a.innerHeight;
          a.zarazData.e = a.innerWidth;
          a.zarazData.l = a.location.href;
          a.zarazData.r = e.referrer;
          a.zarazData.k = a.screen.colorDepth;
          a.zarazData.n = e.characterSet;
          a.zarazData.o = (new Date).getTimezoneOffset();
          a.zarazData.q = [];
          for (; a.zaraz.q.length;) {
            const e = a.zaraz.q.shift();
            a.zarazData.q.push(e)
          }
          z.defer = !0;
          for (const e of [localStorage, sessionStorage]) Object.keys(e || {}).filter((a => a.startsWith("_zaraz_"))).forEach((t => {
            try {
              a.zarazData["z_" + t.slice(7)] = JSON.parse(e.getItem(t))
            } catch {
              a.zarazData["z_" + t.slice(7)] = e.getItem(t)
            }
          }));
          z.referrerPolicy = "origin";
          z.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(a.zarazData)));
          t.parentNode.insertBefore(z, t)
        };
        ["complete", "interactive"].includes(e.readyState) ? zaraz.init() : a.addEventListener("DOMContentLoaded", zaraz.init)
      }(w, d, 0, "script");
    })(window, document);
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Bai Jamjuree', sans-serif;
    }
  </style>
</head>

<body>
  <?php
  $order_id = $_GET['order_id'];
  $stmt = $conn->prepare("SELECT * FROM order_main natural join customer natural join main_service where order_id = $order_id ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  ?>


  <!-- container -->
  <div class="container">
    <div class="card m-2">
      <!--- start card-header --->
      <div class="card-header ">
        <div class="row">
          <div class="col-sm">
            <img src="assets\dist\img\logoCarCare.png" width="100" height="45">
          </div>
          <div class="col-sm text-center h2 text-danger">
            <strong>ใบรับรถ</strong>
          </div>
          <div class="col-sm">
            <span class="float-right m-2"> วันที่-เวลา
              <strong><?php echo $result['date']; ?></strong></span>
          </div>
        </div>
      </div>
      <!--- /.card-header --->

      <div class="card-body">
        <!--- ข้อมูลร้าน - ลูกค้า --->
        <div class="row mb-4">
          <div class="col-sm-6">
            <div><strong>Car Care คาร์แคร์</strong></div>
            <div>
              <span>69 สาทร ซอย 4 กรุงเทพมหานคร 10120</span>
            </div>
            <div>
              <strong>โทร.</strong>
              <span>089-665-9986 </span>
            </div>
          </div>

          <div class="col-sm-6 h3">
            <div>
              <strong>เลขทะเบียน:</strong>
              <span><?php echo $result['car_id']; ?></span>
            </div>
          </div>
        </div>
        <hr>
        <br>
        <!--- /.ข้อมูลร้าน - ลูกค้า --->

        <div class="row m-4">
          <div class="col-8">
            <div><small class="text-danger "><u>เงื่อนไขและข้อปฏิบัติ</u></small></div>
            <div><small>1. กรุณานำมาแสดงเพื่อเป็นหลักฐานในการรับรถ</small></div>
            <div><small>2. หากทำบัตรหายต้องนำหลักฐานมาแสดงต่อเจ้าหน้าที่</small></div>
            <p><small>&nbsp;&nbsp; มิฉะนั้นจะไม่ให้นำรถออกภายนอกร้านและจะต้องเสียค่าปรับ 300 บาท</small></p>
          </div>
          <div class="col-4 text-center">
            <p><strong>ลงชื่อ</strong>...............................................................</p>
            <p>( &nbsp; <?php echo $result['admin']; ?> &nbsp; )</p>
            <div>พนักงานรับรถ</div>
          </div>
        </div>

      </div>

    </div>
  </div>
  <!--/. container -->

  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script>
    window.addEventListener("load", window.print());
  </script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>