<?php
$menu = "m_income-month";
include("../header_m.php");

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1><i class="nav-icon fas fa-chart-line p-2"></i>รายได้รายวัน</h1>
  </div>
</section>
<!-- /.container-fluid -->

<!-- Main content -->
<section class="content">

  <!-- Stat card -->
  <div class="card">
    <div class="card-header card-navy card-outline bg-navy">

      <div class="row">
        <div class="col-lg ">
          <a class="btn btn-primary" href="m_income.php">รายการทั้งหมด</a>
          <a class="btn btn-warning" href="m_income-day.php">รายวัน</a>
          <a class="btn btn-success" href="m_income-month.php">รายเดือน</a>
          <a class="btn btn-info" href="m_income-year.php">รายปี</a>
        </div>
      </div>

    </div>



    <!-- Stat card-body -->
    <div class="card-body">

      <div class="row ">
        <div class="col col-lg-6 col-10">
          <!-- card -->
          <div class="card text-center">
            <h4 class="card-header bg-warning">
              กราฟแสดงรายได้รายวัน
            </h4>
            <!-- กราฟ -->
            <div class="card-body ">
              <canvas id="myChart" width="50" height="40"></canvas>
            </div>
            <!-- กราฟ -->
          </div>
          <!--/. card -->
        </div>
        <!-- col -->
        <div class="col col-lg-6 col-10">


          <!-- card -->
          <div class="card text-center">
            <h4 class="card-header bg-warning">
              ตารางแสดงรายได้รายวัน
            </h4>

            <div class="card-body">
              <form action="">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">เลือกวันที่ :</span>
                  </div>
                  <input type="date" name="day" value="<?php if (isset($_GET['day'])) {
                                                          echo $_GET['day'];
                                                        } ?>" required data-date-format="dd-mm-Y" class="form-control ">

                  <span class="input-group-text">ถึง</span>

                  <input type="date" name="day2" value="<?php if (isset($_GET['day2'])) {
                                                          echo $_GET['day2'];
                                                        } ?>" required data-date-format="dd-mm-Y" class="form-control ">
                  <button type="submit" class="btn btn-primary btn-sm  ">ค้นหาข้อมูล</button>
                  <a href="m_income-day.php" class="btn btn-outline-secondary ">เคลียร์ข้อมูล</a>
                </div>
              </form>
              <hr>
              <?php
              //ถ้ามีการส่ง $_GET 
              if (isset($_GET['day']) && isset($_GET['day2'])) {
                $stmt2 = $conn->prepare("SELECT Sum(total)as total_day,
                DATE_FORMAT(date,'%Y-%m-%d') as Date1 
                FROM order_main   
                WHERE status='successfully' and DATE_FORMAT(date,'%Y-%m-%d') BETWEEN ? AND ? 
                group by Date1 order by Date1 ASC");
                $stmt2->execute(array($_GET['day'], $_GET['day2']));
                $result2 = $stmt2->fetchAll();
                $total = array();
                if ($stmt2->rowCount() > 0) {
              ?>
                  <!-- Stat table-->
                  <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row" class="h6 text-center">
                        <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;">ลำดับ</th>
                        <th tabindex="0" rowspan="1" colspan="1" style="width: 15%;">ประจำวันที่</th>
                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">รายได้</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $total = 0;
                      $num = 1;
                      foreach ($result2 as $row) {
                        $Date1[] = "\"" . date('d-m-Y', strtotime($row['Date1'])) . "\"";
                        $total_income[] = "\"" . $row['total_day'] . "\"";
                        $total += $row['total_day'];
                      ?>
                        <tr>
                          <th scope="row" class="text-center"><?= $num++; ?></th>
                          <td class="text-center"><?= date('d-m-Y', strtotime($row['Date1'])); ?></td>
                          <td class="text-center"><?= number_format($row['total_day'], 2); ?></td>

                        </tr>
                        </tr>
                      <?php
                        @$amount_total += $row['total_day'];
                      }
                      $Date1 = implode(",", $Date1);
                      $total_income = implode(",", $total_income);
                      ?>
                      <tr>
                        <th><?= $num++; ?></th>
                        <td class="text-center"><strong>รวมรายได้ทั้งหมด</strong></td>
                        <td class="text-center"><strong><?= number_format($amount_total, 2); ?></strong></td>

                      </tr>
                  <?php
                } else {
                  echo 'ไม่พบข้อมูล';
                }
              }

                  ?>
                    </tbody>
                  </table>
                  <!-- /.table-->
            </div>
          </div>
          <!--/. card -->


        </div>
        <!--/. col -->


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
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php echo $Date1; ?>], //วัน
        datasets: [{
          label: 'รายงานรายได้ ระหว่างวันที่ (บาท)',
          data: [<?php echo $total_income; ?>], //ใส่ตรงนี้ 
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255,0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255,0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255,1)',
            'rgba(255, 159, 64, 1)',

          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  });
</script>
</body>

</html>