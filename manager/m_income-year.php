<?php
$menu = "m_income-month";
include("../header_m.php");
$stmt = $conn->prepare("SELECT SUM(total) as total_income,
DATE_FORMAT(date,'%Y') as Date1 
from order_main 
where status='successfully' 
and DATE_FORMAT(date,'%Y') group by Date1 order by Date1 ASC;");
$stmt->execute();
$result1 = $stmt->fetchAll();

$total_income = array();
foreach ($result1 as $rs) {
  $Date1[] = "\"".$rs['Date1']."\"";
  $total_income[] = "\"" . $rs['total_income'] . "\"";
}

$Date1 = implode(",", $Date1);
$total_income = implode(",", $total_income);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h1><i class="nav-icon fas fa-chart-line p-2"></i>รายได้รายปี</h1>
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
            <h4 class="card-header bg-info">
              กราฟแสดงรายได้รายปี
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
            <h4 class="card-header bg-info">
              ตารางแสดงรายได้รายปี
            </h4>

            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead >
                  <tr class="text-center">
                    <th scope="col" style="width: 5%;">ลำดับ</th>
                    <th scope="col" style="width: 40%;">ปี</th>
                    <th scope="col">รายได้ต่อปี</th>
                  </tr>
                </thead>

                <tbody>
                  <?php

                 $stmt2 = $conn->prepare("SELECT SUM(total) as total_income,
                  DATE_FORMAT(date,'%Y') as Date1 
                  from order_main 
                  where status='successfully' 
                  and DATE_FORMAT(date,'%Y') 
                  group by Date1 order by Date1 ASC;");

                 $stmt2->execute();
                 $result2 = $stmt2->fetchAll();
                 $num = 1;
                  foreach ($result2 as $row2) {
                   
                  ?>
                    <tr>
                      <th scope="row" class="text-center"><?= $num++; ?></th>
                      <td class="text-center"><?= $row2['Date1']; ?></td>
                      <td><?= number_format($row2['total_income'], 2); ?></td>
                    </tr>
                  <?php 
                @$amount_total += $row2['total_income'];
                } ?>
                  <tr>
                    <th scope="row"><?= $num++; ?></th>
                    <td class="text-center"><b>รวมรายได้ทั้งหมด</b></td>
                    <td><b><?= number_format($amount_total, 2); ?></b></td>
                  </tr>
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
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php echo $Date1; ?>] , //ปี
        datasets: [{
          label: 'รายงานรายได้ แยกตามปี (บาท)',
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