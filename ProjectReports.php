<!doctype html>

<?php include "ProjectDBFile.php"?>

<?php
ob_start();
if($_SESSION['clicker']==0){
  $_SESSION['showdatactr']=0;
}else{
  $_SESSION['clicker']==0;
}
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="modal.js">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="proj_css.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Hello, world!</title>

  </head>
  <body>




<nav class="navbar navbar-light bg-dark text-light justify-content-between shadow p-3">
        <a class="navbar-brand text-light font-weight-bold m-0 " href="">QUEsystem</a>

    </nav>
<a href="" class="border-white btn btn-success" data-toggle="modal" data-target="#generatereport">GENERATE INVENTORY SUMMARY REPORT</a>

    <div class="container-fluid ">
        <div class="row my-4">

            <div class="col-2 ml-2 h-100 p-4 " >

              <nav id="sidebar" class="sb-stick my-4">
                <div class="sidebar-header">

                </div>


                <ul class="navbar-nav ml-auto p-4 this">
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectLandingPage.php">Main <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectSupplierCRUD.php">Supplier</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectCustomerCRUD.php">Customer</a>
            </li>
            <?php
            if($_SESSION["CurRank"]=="admin"){
            echo "<li class='nav-item'>";
                echo "<a class='nav-link text-dark' href='ProjectEMPCRUD.php'>Employee</a>";
            echo "</li>";
            }else if($_SESSION["CurRank"]=="RegUser"){
            echo "<li class='nav-item'>";
                echo "<a class='nav-link text-dark' href='#'>Employee</a>";
            echo "</li>";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectPOPage.php">Purchase Stocks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectDOPage.php">Order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark active" href="ProjectReports.php">Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectLoginPage.php" name="LogOut">LogOut</a>
            </li>

          </ul>
        </nav>

    </nav>
            </div>

    <?php
      $mydb = new db();
      $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
      $prod = mysqli_query($aVar, "SELECT COUNT(*) FROM product");
      $supp = mysqli_query($aVar, "SELECT COUNT(*) FROM supplier");
      $emp = mysqli_query($aVar, "SELECT COUNT(*) FROM employees");
      $cust = mysqli_query($aVar, "SELECT COUNT(*) FROM customerdetails");
      $po = mysqli_query($aVar, "SELECT COUNT(*) FROM po");
      $do = mysqli_query($aVar, "SELECT COUNT(*) FROM do");

      $pro = mysqli_fetch_array($prod);
      $sup = mysqli_fetch_array($supp);
      $em = mysqli_fetch_array($emp);
      $cus = mysqli_fetch_array($cust);
      $purch = mysqli_fetch_array($po);
      $del = mysqli_fetch_array($do);
    ?>

        <div class="col-9 ml-5 w-100">
            <div class="row my-4">

                  <div class="col-4 ">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">
                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                               <i class="fa fa-archive " style='font-size:60px;color:#343a40 '></i>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark float-right p-4">
                              <h2 class="text-center"><?php echo $pro[0];?></h2>
                               <p>Products</p>
                            </div>
                        </div>
                        </div>
                    </div>

                  </div>

                   <div class="col-4 ">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">
                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                               <i class="fas fa fa-truck" style='font-size:60px;color:#343a40 '></i>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $sup[0];?></h2>
                               <p>Suppliers</p>
                            </div>
                        </div>
                        </div>
                    </div>

                  </div>

                  <div class="col-4 ">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">
                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                               <i class="fa fa-user-o pl-2" style='font-size:60px;color:#343a40 '></i>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $em[0];?></h2>
                               <p>Employees</p>
                            </div>
                        </div>
                        </div>
                    </div>

                  </div>


                  <div class="col-4 ">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">
                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                               <i class="fa fa-user-circle-o" style='font-size:60px;color:#343a40 '></i>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $cus[0];?></h2>
                               <p>Customers</p>
                            </div>
                        </div>
                        </div>
                    </div>

                  </div>

                   <div class="col-4 ">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">
                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                               <i class="fa fa-tags" style='font-size:60px;color:#343a40 '></i>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $purch[0];?></h2>
                               <p>Purchase Orders</p>
                            </div>
                        </div>
                        </div>
                    </div>

                  </div>

                  <div class="col-4 ">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">
                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                               <i class="fa fa-sticky-note-o" style='font-size:60px;color:#343a40 '></i>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $del[0];?></h2>
                               <p>Delivery Orders</p>
                            </div>
                        </div>
                        </div>
                    </div>

                  </div>




                <div class="col-6">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">

                        <div class="card-header bg-dark">
                          <label class="font-weight-bold text-light">Highest Selling Product ALL TIME</label>
                        </div>

                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                            <?php

                              $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

                              $result = mysqli_query($aVar, "SELECT SUM(dol.`qty`) AS TOTAL, dol.`prodName` AS 'Product Name' FROM DO_LINE dol, DO d WHERE dol.`order_ref`=d.`order_ref` AND d.`order_status` = 'sold'GROUP BY dol.`prodName` ORDER BY TOTAL DESC LIMIT 1");

                              $row = mysqli_fetch_array($result);
                              if($row){
                                echo "<h1>".$row['Product Name']."</h1>";


                            ?>
                              <p>Product Name</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $row['TOTAL'];}?></h2>
                               <p>Quantity</p>
                            </div>
                        </div>

                        </div>
                    </div>

                </div>

                <div class="col-6">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">

                        <div class="card-header bg-dark">
                          <label class="font-weight-bold text-light">Highest Selling Product this YEAR</label>
                        </div>

                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                        <?php
                            $date = date("Y");
                            $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

                            $result = mysqli_query($aVar, "SELECT SUM(dol.`qty`) AS TOTAL, dol.`prodName` AS 'Product Name' FROM DO_LINE dol, DO d WHERE dol.`order_ref`=d.`order_ref` AND d.`order_status` = 'sold' AND year(d.`date_fulfilled`)='$date' AND d.`customer_id`!='0' GROUP BY dol.`prodName` ORDER BY TOTAL DESC LIMIT 1");

                            $row = mysqli_fetch_array($result);
                            if($row){
                            echo "<h1>".$row['Product Name']."</h1>";

                        ?>
                            <p>Product Name</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $row['TOTAL'];
                              }?>

                              </h2>
                               <p>Delivery Orders</p>
                            </div>
                        </div>

                        </div>
                    </div>

                </div>

                  <div class="col-6">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">

                        <div class="card-header bg-dark">
                          <label class="font-weight-bold text-light">Highest Selling Product this MONTH</label>
                        </div>

                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                            <?php

                              $date = date("m");
                              $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

                              $result = mysqli_query($aVar, "SELECT SUM(dol.`qty`) AS TOTAL, dol.`prodName` AS 'Product Name' FROM DO_LINE dol, DO d WHERE dol.`order_ref`=d.`order_ref` AND d.`order_status` = 'sold' AND month(d.`date_fulfilled`)='$date' AND d.`customer_id`!='0' GROUP BY dol.`prodName` ORDER BY TOTAL DESC LIMIT 1");

                              $row = mysqli_fetch_array($result);
                              if($row){
                                echo "<h1>".$row['Product Name']."</h1>";


                            ?>
                              <p>Product Name</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $row['TOTAL'];}?></h2>
                               <p>Quantity</p>
                            </div>
                        </div>

                        </div>
                    </div>

                </div>

                <div class="col-6">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">

                        <div class="card-header bg-dark">
                          <label class="font-weight-bold text-light"> Lowest Selling Product ALL TIME</label>
                        </div>

                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                        <?php
                            $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

                            $result = mysqli_query($aVar, "SELECT SUM(dol.`qty`) AS TOTAL, dol.`prodName` AS 'Product Name' FROM DO_LINE dol, DO d WHERE dol.`order_ref`=d.`order_ref` AND d.`order_status` = 'sold' AND d.`customer_id`!='0' GROUP BY dol.`prodName` ORDER BY TOTAL ASC LIMIT 1");

                            $row = mysqli_fetch_array($result);
                            if($row){
                            echo "<h1>".$row['Product Name']."</h1>";

                        ?>
                            <p>Product Name</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $row['TOTAL'];
                              }?>

                              </h2>
                               <p>Delivery Orders</p>
                            </div>
                        </div>

                        </div>
                    </div>

                </div>

                <div class="col-6">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">

                        <div class="card-header bg-dark">
                          <label class="font-weight-bold text-light"> Lowest Selling Product this YEAR </label>
                        </div>

                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                            <?php

                              $date = date("Y");
                              $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

                              $result = mysqli_query($aVar, "SELECT SUM(dol.`qty`) AS TOTAL, dol.`prodName` AS 'Product Name' FROM DO_LINE dol, DO d WHERE dol.`order_ref`=d.`order_ref` AND d.`order_status` = 'sold' AND year(d.`date_fulfilled`)='$date' AND d.`customer_id`!='0' GROUP BY dol.`prodName` ORDER BY TOTAL ASC LIMIT 1");

                              $row = mysqli_fetch_array($result);
                              if($row){
                                echo "<h1>".$row['Product Name']."</h1>";


                            ?>
                              <p>Product Name</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $row['TOTAL'];}?></h2>
                               <p>Quantity</p>
                            </div>
                        </div>

                        </div>
                    </div>

                </div>

                <div class="col-6">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">

                        <div class="card-header bg-dark">
                          <label class="font-weight-bold text-light">Lowest Selling Product this MONTH</label>
                        </div>

                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                        <?php

                            $date = date("m");
                            $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

                            $result = mysqli_query($aVar, "SELECT SUM(dol.`qty`) AS TOTAL, dol.`prodName` AS 'Product Name' FROM DO_LINE dol, DO d WHERE dol.`order_ref`=d.`order_ref` AND d.`order_status` = 'sold' AND month(d.`date_fulfilled`)='$date' AND d.`customer_id`!='0' GROUP BY dol.`prodName` ORDER BY TOTAL ASC LIMIT 1");

                            $row = mysqli_fetch_array($result);
                            if($row){
                            echo "<h1>".$row['Product Name']."</h1>";

                        ?>
                            <p>Product Name</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $row['TOTAL'];
                              }?>

                              </h2>
                               <p>Delivery Orders</p>
                            </div>
                        </div>

                        </div>
                    </div>

                </div>

                                <div class="col-6">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">

                        <div class="card-header bg-dark">
                          <label class="font-weight-bold text-light"> Most Active Customer ALL TIME </label>
                        </div>

                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                            <?php

                              $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

                              $result = mysqli_query($aVar, "SELECT COUNT(*) as Number_of_transactions ,
                              CONCAT(c.`first_name`,' ',c.`last_name`) as Customer_Name FROM do d, customerdetails c WHERE c.`customer_id`=d.`customer_id` AND d.`customer_id`!='0' GROUP BY d.`customer_id` ORDER BY Number_of_transactions DESC LIMIT 5");

                              $row = mysqli_fetch_array($result);
                              if($row){
                                echo "<h1>".$row['Customer_Name']."</h1>";


                            ?>
                              <p>Customer Name</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $row['Number_of_transactions'];}?></h2>
                               <p>Transactions</p>
                            </div>
                        </div>

                        </div>
                    </div>

                </div>

                <div class="col-6">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">

                        <div class="card-header bg-dark">
                          <label class="font-weight-bold text-light"> Most Active Customer this YEAR </label>
                        </div>

                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                        <?php

                            $date = date("Y");
                            $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

                            $result = mysqli_query($aVar, "SELECT COUNT(*) as Number_of_transactions ,
                            CONCAT(c.`first_name`,' ',c.`last_name`) as Customer_Name FROM do d,
                            customerdetails c WHERE c.`customer_id`=d.`customer_id` AND YEAR(date_fulfilled)='$date' AND d.`customer_id`!='0' GROUP BY d.`customer_id` ORDER BY Number_of_transactions DESC LIMIT 5");

                            $row = mysqli_fetch_array($result);
                            if($row){
                            echo "<h1>".$row['Customer_Name']."</h1>";

                        ?>
                            <p>Customer Name</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $row['Number_of_transactions'];
                              }?>

                              </h2>
                               <p>Transactions</p>
                            </div>
                        </div>

                        </div>
                    </div>

                </div>

                                <div class="col-6">

                    <div class="card  mb-3 bg-transparent" style="max-width: 540px;">

                        <div class="card-header bg-dark">
                          <label class="font-weight-bold text-light"> Most Active Customer this MONTH </label>
                        </div>

                        <div class="row no-gutters">

                        <div class="col-md-4">
                            <div class="card-body text-dark bg-transparent float-left p-4">
                        <?php

                            $date = date("m");
                            $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

                            $result = mysqli_query($aVar, "SELECT COUNT(*) as Number_of_transactions ,
                            CONCAT(c.`first_name`,' ',c.`last_name`) as Customer_Name FROM do d,
                            customerdetails c WHERE c.`customer_id`=d.`customer_id` AND month(date_fulfilled)='$date' AND d.`customer_id`!='0' GROUP BY d.`customer_id` ORDER BY Number_of_transactions DESC LIMIT 5");

                            $row = mysqli_fetch_array($result);
                            if($row){
                            echo "<h1>".$row['Customer_Name']."</h1>";

                        ?>
                            <p>Customer Name</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body text-dark bg-transparent float-right p-4">
                              <h2 class="text-center"><?php echo $row['Number_of_transactions'];
                              }?>

                              </h2>
                               <p>Transactions</p>
                            </div>
                        </div>

                        </div>
                    </div>

                </div>

              </div>
        </div>

</div>
</div>

<div class="modal fade" id="generatereport" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="exampleModalLongTitle">GENERATE REPORT</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method = "post" action = "" enctype="multipart/form-data">

          <label for="date1" class="col-form-label">First date interval</label>
          <input type="date" placeholder="date1" name="date1" class="form-control logon-texts" required>
          <br>
          <label for="date2">Second date interval</label>
          <input type="date" placeholder="date2" name="date2" class="form-control logon-texts" required>
          <br>
        <button type="submit" name="generate" class="btn btn-success float-right">SUBMIT</button>
      </form>
      </div>
    </div>
  </div>
</div>

        <?php 
          if(isset($_POST["generate"])){
            $_SESSION["date1"] = $_POST["date1"];
            $_SESSION["date2"] = $_POST["date2"];
              if($date1 > $date2){
                 //Write the invalid echo here, since date 1 is bigger than date 2
              }else{
                 header("location: inventoryreport.php");
              }
          }
        ?>

  <script src='modal.js'></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  </body>
</html>
