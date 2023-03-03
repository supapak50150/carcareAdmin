<div class="row">
  <div class="col-lg ">
  <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `order_main` WHERE status = 'wait' ");
            $count_cart_items->execute();
            $total_cart_items = $count_cart_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `order_main` WHERE status = 'wash' ");
            $count_cart_items->execute();
            $total_cart_items2 = $count_cart_items->rowCount();

            
            $count_cart_items = $conn->prepare("SELECT * FROM `order_main` WHERE status = 'waitPayment' ");
            $count_cart_items->execute();
            $total_cart_items3 = $count_cart_items->rowCount();
         ?>
    <a type="button" class="btn btn-danger" href="m_carQueue.php">รอคิว
      <span class="badge badge-light"><?= $total_cart_items; ?></span>
    </a>
    <a type="button" class="btn btn-warning" href="m_carWashing.php">กำลังดำเนินการ
      <span class="badge badge-light"><?= $total_cart_items2; ?></span>
    </a>
    <a type="button" class="btn btn-success" href="m_carFinishWash.php">เสร็จแล้ว
      <span class="badge badge-light"><?= $total_cart_items3; ?></span>
    </a>
    <a type="button" class="btn btn-primary" href="m_carAllOrders.php">รับรถ</a>
    <a class="btn btn-outline-secondary" href="../service-status.php">ไปยังเว็บไซต์</a>
  </div>