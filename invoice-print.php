<?php
require_once 'config/db.php';

if (isset($_GET['order_id'])) {
  $select_stmt = $conn->prepare("SELECT * FROM order_main where order_id=?");
  $select_stmt->execute([$_GET['order_id']]);
  $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
}


$stmt = $conn->prepare("SELECT * FROM order_main natural join customer natural join main_service where status = 'successfully' ");
$stmt->execute();
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
  $stmt = $conn->prepare("SELECT *, DATE_FORMAT(date,'%d-%m-%Y') as Date1 FROM order_main natural join customer  where order_id = $order_id ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  ?>
  <!-- ข้อมูลใบเสร็จ -->
  <div class="container ">
    <div class="card m-2">
      <!--- start card-header --->
      <div class="card-header bg-white">
        <div class="row">
          <div class="col-5">
            <div class="col-sm m-2">
              <img src="assets\dist\img\logoCarCare.png" width="100" height="45">
            </div>
            <div><strong>Car Care คาร์แคร์ </strong></div>
            <div>
              <strong>ที่อยู่ :</strong> <span>69 สาทร ซอย 4 กรุงเทพมหานคร 10120</span>
            </div>
            <div>
              <strong>เบอร์โทร :</strong>
              <span>089-665-9986 </span>
            </div>
            <div>
              <strong>เลขประจำตัวผู้เสียภาษี :</strong>
              <span>1234567890999 </span>
            </div>
          </div>

          <div class="col">

            <div class="text-center m-2">
              <div class="h5"><b>ใบเสร็จรับเงิน</b></div>
              <div>Receipt</div>
            </div>
          </div>

          <div class="col">
            <div class="float-right">
              <div><b><span class="badge badge-light">ไม่ใช่ใบกำกับภาษี</span></b>
              </div>
              <?php
              $order_id = $_GET['order_id'];
              $stmt = $conn->prepare("SELECT *,replace(replace(replace(replace(CURRENT_TIMESTAMP(),'/',''),'-',''),' ',''),':','')  as bill FROM order_main   where order_id = $order_id ");
              
              $stmt->execute();
              $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
              ?>

              <div><b>เลขที่ใบเสร็จ: </b><span><?php echo $result2['bill']; ?></span>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!--- /.card-header --->

      <div class="card-body">
        <!--- ข้อมูลร้าน - ลูกค้า --->
        <div class="row mb-4">
          <div class="col-sm-6">
            <div>
              <strong>ลูกค้า:</strong>
              <span><?php echo $result['cus_fname'] . ' ' . $result['cus_lname']; ?></span>
            </div>
            <div>
              <strong>รถ:</strong>
              <span><?php echo $result['car_type']; ?></span>
              <strong>ยี่ห้อ:</strong>
              <span><?php echo $result['car_brand']; ?></span>
              <strong>รุ่น:</strong>
              <span><?php echo $result['car_series']; ?></span>
            </div>
            <div>
              <strong>เลขทะเบียน:</strong>
              <span><?php echo $result['car_id']; ?></span>
            </div>


          </div>
          <div class="col-sm">

            <div class="float-right">
              <strong> วันที่</strong>
              <span><?php echo $result['Date1']; ?></span>
            </div>
          </div>
          <div class="col-sm-6">

          </div>
        </div>
        <!--- /.ข้อมูลร้าน - ลูกค้า --->
        <!----ตารางการบริการ---->
        <div class="table">
          <table class="table  table-bordered ">
            <thead>
              <tr>
                <th scope="col" class="text-center" style="width: 5%;">ลำดับ</th>
                <th scope="col" class="text-center" style="width: 25%;">บริการเริ่มต้น</th>
                <th scope="col" class="text-center">บริการเสริม</th>
                <th scope="col" class="text-center" style="width: 25%;">ค่าบริการ</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center">1</td>
                <td><?php echo $result['service']; ?></td>
                <td></td>
                <td class="text-center"><?php echo $result['charge']; ?></td>
              </tr>
              <?php
              $stmt = $conn->prepare("SELECT * FROM order_add_on  where order_id = $order_id");
              $stmt->execute();
              $result2 = $stmt->fetchAll();
              $num = 2;
              foreach ($result2 as $row) {
              ?>
                <tr>
                  <td class="text-center"><?= $num++ ?></td>
                  <td></td>
                  <td><?= $row['add_service']; ?></td>
                  <td class="text-center"><?= $row['add_charge']; ?></td>
                </tr>
              <?php } ?>
              <tr>
                <td colspan="3">
                  <strong class="float-right">รวม</strong>
                </td>
                <td class="text-center">



                  <strong><?php echo $result['total']; ?></strong>

                </td>
              </tr>


            </tbody>
          </table>
        </div>
        <!----ตารางการบริการ---->

        <div class="row">
          <!--start row -->
          <div class="col-4">

            <strong>ลักษณะการชำระเงิน</strong>
            <table class="table table-sm ">

              <tbody class="table ">
                <tr>
                  <td>
                    <strong>
                      <?php
                      if ($result['payment'] == 'Cash') {
                        echo 'เงินสด';
                      }
                      if ($result['payment'] == 'Transfer-Money') {
                        echo 'เงินโอน';
                      }
                      if ($result['payment'] == 'Credit-Card') {
                        echo "บัตรเครดิต";
                      }

                      ?>
                  </td>
                  <td>
                    <strong><?php echo $result['total']; ?></strong>
                  </td>
                  <td class="text-right">
                    <strong>บาท</strong>
                  </td>
                </tr>


              </tbody>
            </table>

          </div>





        </div>

        <div class="row">
          <div class="col-6 "></div>
          <div class="col text-center p-5">
            <p><strong>ลงชื่อ</strong>...............................................................</p>
            <p class="text-center">( &nbsp; <?php echo $result['admin']; ?> &nbsp; )</p>
            <strong>เจ้าหน้าที่รับเงิน</strong>
          </div>
        </div>
      </div>



    </div>
  </div>
  <!--/. ข้อมูลใบเสร็จ -->

  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script>
    window.addEventListener("load", window.print());
  </script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>