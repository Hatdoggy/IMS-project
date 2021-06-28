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

            <div class="col-9 ml-5 w-100">

           <div class="card w-100"  style="margin: 10px">
          <div class="card-header bg-dark text-light">
            <label class="font-weight-bold text-light">INVENTORY SUMMARY REPORT</label><br>
            <label class="font-weight-bold text-light"><?php echo "FROM ".$_SESSION["date1"]." to ".$_SESSION["date2"];?></label>
          </div>

          <div class="card-body">
            <table class="table">

              <?php $mydb = new db();
                    $result = $mydb->show_data("Product");
              ?>

              <thead>
                <tr>
                  <th scope="col">Product</th>
                  <th scope="col">CURRENT_AVAILABLE</th>
                  <th scope="col">SOLD</th>
                  <th scope="col">WASTE</th>
                </tr>
              </thead>
              <tbody>
                    <?php
                    $date1 = $_SESSION["date1"];
                    $date2 = $_SESSION["date2"];
                    while ($data = mysqli_fetch_assoc($result)){

                    $tempName = $data["name"];

                    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT SUM(qty) AS TOTAL, name FROM `logs` WHERE `date_fulfilled` = CURDATE() AND name='$tempName'";
                    $result2 = mysqli_query($aVar,$sql);
                    $data2 = mysqli_fetch_assoc($result2);

                    $sql = "SELECT SUM(qty) AS TOTAL, name FROM `logs` WHERE date_fulfilled between '$date1' AND '$date2' AND log_type='s' AND name='$tempName'";
                    $result3 = mysqli_query($aVar,$sql);
                    $data3 = mysqli_fetch_assoc($result3);

                    $sql = "SELECT SUM(qty) AS TOTAL, name FROM `logs` WHERE date_fulfilled between '$date1' AND '$date2' AND log_type='e' AND name='$tempName'";
                    $result4 = mysqli_query($aVar,$sql);
                    $data4 = mysqli_fetch_assoc($result4);

                    ?>
                    <tr>
                    <td> <?php echo $data["name"]; ?></td>
                    <td> <?php echo $data2["TOTAL"]; ?></td>
                    <td> <?php echo abs($data3["TOTAL"]); ?></td>
                    <td> <?php echo abs($data4["TOTAL"]); ?></td>
                    </tr>
                    <!--<button class="btn btn-warning">Delete</button>-->
                  <?php } ?>

              </tbody>
              </table>
          </div>
        </div>


  <script src='modal.js'></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  </body>
</html>
