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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>service-status</title>
    <style>
        body {
            /*background-color: #74c4e7;
            background: linear-gradient(90deg, #c4f2ff, #c1f6fc, #c1faf6, #c5fcee, #ccfee5, #d8ffdc, #e6ffd3, #f6ffcc);
           
            background: linear-gradient(to right, #b5ead7, #ffdac1); */
            font-family: 'Noto Sans Thai', sans-serif;
        }
        @media screen and (max-width:800px) {
            iframe {
                width: 100%;
            }
        }
    </style>
</head>

<body style="background:#afd7f6;">

    <nav class="navbar navbar-dark bg-dark">
        <!-- Navbar content -->
        <ul class="nav nav-pills card-header-pills">
            <li class="nav-item h4">
                <a class="navbar-brand" href="#"> <img src="assets/dist/img/Logo-car-wash.png" width="45" height="45" class="d-inline-block text-light "> &nbsp; Car Care คาร์แคร์</a>
            </li>
        </ul>
    </nav>

    <div class="card text-center">
        <div class="card-body">
            <h1 class="display-4">Car Care คาร์แคร์</h1>
            <p class="card-text">ยินดีให้บริการลูกค้าทุกท่าน และขอบคุณลูกค้าทุกท่านที่เลือกให้เราดูแล</p>
        </div> <!-- /. welcome -->
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="card text-center m-2 ">

                    <!-- start advertise -->
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="assets\images\History-of-the-car-wash-1280x720.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="assets\images\Locate-a-Hand-Car-Wash-Near-You.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="assets\images\The-Easiest-Way-To-Find-A-Car-Wash-Near-You.jpg" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                    <!-- /.advertise -->

                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card text-center m-2 ">
                    <div class="card-body text-lg ">
                        <!-- start service status-->
                        
                            <h1 class="p-3 mb-2  text-white text-center" style="background:#efa364;">
                                สถานะรถที่รับบริการ</h1>

                            
                                    <!-- table-->
                                    <table class="table text-center">
                                        <thead class="table text-light h3" style="background:#4f80cf;">
                                            <tr>
                                                <th>เลขทะเบียนรถ</th>
                                                <th>สถานะการรับบริการ</th>
                                            </tr>
                                        </thead>
                                        <tbody class="h3">
                                            <tr>
                                                <td>1234</td>
                                                <td>
                                                    <div class="badge badge-success text-wrap " style="width: 8rem; height: 2rem ;">
                                                        เสร็จแล้ว
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1234</td>
                                                <td>
                                                    <div class="badge badge-warning text-wrap  " style="width: 8rem; height: 2rem ;">
                                                        กำลังล้าง
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1234</td>
                                                <td>
                                                    <div class="badge badge-danger text-wrap " style="width: 8rem; height: 2rem ;">
                                                        รอคิว
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                              
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card text-center m-2 ">
                    <div class="card-body text-lg ">
                        <!---start contact--->
                        <div class="container">
                            <h4 class="p-3 mb-2  text-white text-center" style="background:#37c871;">
                                ที่อยู่ - ติดต่อเจ้าหน้าที่</h4>
                        </div>
                        <div class="container text-center">

                            <a><img src="assets/dist/img/customer-service.png" width="30" height="30" class="d-inline-block align-center">
                                <b>โทร. </b> 088-999-7777 <b>หรือโทร. </b> 066-888-9999
                            </a>
                            <p><b>วันเปิดทำการ </b>: ทุกวันจันทร์-ศุกร์ <b>เวลา </b>: 09.00 - 20.00 น.</p>
                            <hr>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4883.585108276575!2d100.53715045159575!3d13.71214797789154!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29f35d9bdff0d%3A0x8ec79fdd80befa7a!2sRajamangala%20University%20of%20Technology%20Krungthep!5e0!3m2!1sen!2sth!4v1667569605989!5m2!1sen!2sth" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        </div>
                        <!---/. contact--->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer text-center ">
        <small class="text-muted "> &copy; 2022 Project Car Care SupaWira</small>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>

</html>