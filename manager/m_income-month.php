<?php
$menu = "m_income-month";
include("../header_m.php");

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1><i class="nav-icon fas fa-chart-line p-2"></i>รายได้รายเดือน</h1>
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
            <h4 class="card-header bg-success">
              กราฟแสดงรายได้รายเดือน
            </h4>
            <!-- กราฟ -->
            <div class="card-body ">
              <canvas id="myChart" width="50" height="40"></canvas>
            </div>
            <!-- กราฟ -->
          </div>
        </div>
        <!-- card -->
        <div class="col col-lg-6 col-10">
          <!-- card -->
          <div class="card text-center">
            <h4 class="card-header bg-success">
              ตารางแสดงรายได้รายเดือน
            </h4>

            <div class="card-body">
              <form action="">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">เลือกปี :</span>
                  </div>
                  <?php
                  $year_start  = 2022;
                  $year_end = date('Y');
                  $user_selected_year = date('Y');

                  echo '<select id="year" name="year" class="form-control">' . "\n";
                  for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                    $selected = ($user_selected_year == $i_year ? ' selected' : '');
                    echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                  }
                  echo '</select>' . "\n";
                  ?>

                  <button type="submit" class="btn btn-primary btn-sm  ">ค้นหาข้อมูล</button>
                  <a href="m_income-month.php" class="btn btn-outline-secondary ">เคลียร์ข้อมูล</a>
                </div>
              </form>
              <hr>
              <?php
              if (isset($_GET['year'])) {
                $yearly = $_GET['year'];

                $stmt2 = $conn->prepare("SELECT Sum(total)as total_months,
                    DATE_FORMAT(date,'%m-%Y') as Date1 
                    from order_main
                    where status='successfully' and DATE_FORMAT(date,'%Y') LIKE '%$yearly%' 
                    group by Date1 order by Date1 ASC;");
                $stmt2->execute();
                $result2 = $stmt2->fetchAll();
                $total_income = array(); ?>

                <p class="text-center"><strong><u>ข้อมูลปี <?php echo $yearly; ?></u></strong></p>
                
                <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead>
                    <tr class="text-center">
                      <th scope="col" style="width: 5%;">ลำดับ</th>
                      <th scope="col" style="width: 40%;">เดือน</th>
                      <th scope="col">รายได้ต่อเดือน</th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    if ($stmt->rowCount() > 0) {
                      $num = 1;
                      $total_months = 0;
                      foreach ($result2 as $row2) {
                        $Date1[] = "\"" . $row2['Date1'] . "\"";
                        $total_income[] = "\"" . $row2['total_months'] . "\"";
                        $total_months += $row2['total_months'];
                    ?>
                        <tr>
                          <th scope="row" class="text-center"><?= $num++; ?></th>
                          <td class="text-center"><?= $row2['Date1']; ?></td>
                          <td><?= number_format($row2['total_months'], 2); ?></td>
                        </tr>
                      <?php
                        @$amount_total += $row2['total_months'];
                      }
                      ?>
                      <tr>
                        <th scope="row"><?= $num++; ?></th>
                        <td class="text-center"><b>รวมรายได้ทั้งหมด</b></td>
                        <td><b><?php if (@$amount_total != null) {
                                  echo number_format($amount_total, 2);
                                } else {
                                  echo '<u>ไม่พบข้อมูลปี' . ' ' . $yearly. '! </u>';
                                }
                                ?></b></td>
                      </tr>
                  <?php }
                  }  ?>
                  </tbody>
                </table>

            </div>
          </div>
          <!-- card -->
        </div>


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
    <?php
    $Date1 = implode(",", $Date1);
    $total_income = implode(",", $total_income);
    ?>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php echo $Date1; ?>], //เดือน
        datasets: [{
          label: 'รายงานรายได้ แยกตามเดือน (บาท)',
          data: [<?php echo $total_income; ?>],
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