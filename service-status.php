<?php
session_start();
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&display=swap" rel="stylesheet">

    <title>service-status</title>
    <style>
        body {
            /*background-color: #74c4e7;
            background: linear-gradient(90deg, #c4f2ff, #c1f6fc, #c1faf6, #c5fcee, #ccfee5, #d8ffdc, #e6ffd3, #f6ffcc);       
            background: linear-gradient(to right, #b5ead7, #ffdac1); */
            background-color: #252525;

            font-family: 'Bai Jamjuree', sans-serif;
            font-size: 16px;

        }

        .main {
            padding: 5px;
            margin-top: 100px;
        }

        @media screen and (max-width:800px) {
            iframe {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div id="navbar-example2" class="navbar navbar-light bg-light ">
        <div class="container">
            <a class="navbar-brand" href="#"> <img src="assets\dist\img\logoCarCare.png" width="100" height="45" class="d-inline-block "> &nbsp; Car Care คาร์แคร์</a>

            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="#">บริการ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#status">สถานะรถที่รับบริการ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">ติดต่อ</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container">

        <div class="transbox text-light p-4 mb-2">
            <div data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                <div class=" text-center ">
                    <h2 id="#">Car Care คาร์แคร์</h2>
                    <p>ยินดีให้บริการลูกค้าทุกท่าน และขอบคุณลูกค้าทุกท่านที่เลือกให้เราดูแล</p>

                </div>
            </div>


            <?php
            $stmt = $conn->prepare("SELECT * FROM main_service ");
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
            ?>

                <a>
                    <button class="btn btn-info btn-md m-2" type="button" data-toggle="collapse" data-target="#collapseExample<?= $row['ms_id']; ?>" aria-expanded="false" aria-controls="collapseExample">
                        <?= $row['car_type']; ?>
                    </button>
                </a>

                <div class="collapse p-2" id="collapseExample<?= $row['ms_id']; ?>">
                    <div class="card card-body">
                        <table class="table table-sm ">
                            <thead>
                                <tr>
                                    <th scope="col">บริการเริ่มต้น</th>
                                    <th  class="text-right" scope="col">ค่าบริการ</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $row['service']; ?></td>
                                    <td class="text-right"><?= $row['ms_charge']; ?></td>
                                    <td>บาท</td>
                                </tr>
                            </tbody>


                            <thead>
                                <tr>
                                    <th scope="col">บริการเสริม</th>
                                    <th  class="text-right" scope="col">ค่าบริการ</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <?php
                            $ms_id = $row['ms_id'];
                            $stmt = $conn->prepare("SELECT * FROM add_on_service where ms_id = $ms_id ");
                            $stmt->execute();
                            $result2 = $stmt->fetchAll();
                            foreach ($result2 as $row2) {
                            ?>
                                <tbody>
                                    <tr>
                                        <td><?= $row2['add_onservice']; ?></td>
                                        <td class="text-right"><?= $row2['add_onservice_charge']; ?></td>
                                        <td>บาท</td>
                                    </tr>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>

            <?php } ?>
        </div>




        <div class="container p-4">
            <div class="row">

                <div class="col-md-6 col-12">
                    <!-- start service status-->

                    <h5 id="status" class="p-3 mb-2  text-white text-center bg-primary">
                        สถานะรถที่รับบริการ</h5>


                    <!-- table-->
                    <table class="table text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>เลขทะเบียนรถ</th>
                                <th>สถานะการรับบริการ</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark bg-light">
                            <?php

                            $stmt = $conn->prepare("SELECT * FROM order_main natural join customer where status != 'successfully' ");
                            $stmt->execute();
                            $result = $stmt->fetchAll();

                            foreach ($result as $row) {
                            ?>
                                <td><?= $row['car_id']; ?></td>
                                <td>
                                    <?php
                                    if ($row['status'] == 'wait') {
                                        echo '<span class="badge badge-danger" >
                                                รอคิว </span>';
                                    }
                                    if ($row['status'] == 'wash') {
                                        echo '<span class="badge badge-warning " >
                                                กำลังดำเนินการ </span>';
                                    }
                                    if ($row['status'] == 'waitPayment') {
                                        echo '<span class="badge badge-success " >
                                                เสร็จแล้ว/รอชำระเงิน </span>';
                                    }
                                    ?>

                                </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.table -->

                </div>


                <div id="contact" class="col-md-6 col-12 ">

                    <!---start contact--->
                    <div class="container  ">
                        <h5 class="p-3 mb-2  text-white text-center bg-secondary">
                            ที่อยู่ - ติดต่อเจ้าหน้าที่</h5>

                        <div class="bg-light  text-center ">
                            <div class="p-2 ">
                                <div>
                                    <b>โทร. </b> 089-665-9986
                                </div>
                                <p><b>วันเปิดทำการ </b>: ทุกวันจันทร์-ศุกร์ <b>เวลา </b>: 09.00 - 20.00 น.</p>
                            </div>

                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4883.585108276575!2d100.53715045159575!3d13.71214797789154!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29f35d9bdff0d%3A0x8ec79fdd80befa7a!2sRajamangala%20University%20of%20Technology%20Krungthep!5e0!3m2!1sen!2sth!4v1667569605989!5m2!1sen!2sth" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        </div>
                    </div>
                    <!---/. contact--->
                </div>
            </div>
        </div>


        <footer class="footer text-center ">
            <small class="text-muted "> &copy; 2022 Project Car Care SupapakC.WirapornY</small>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>

</html>