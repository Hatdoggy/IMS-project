<!doctype html>

<?php include "ProjectDBFile.php"?>
<?php
ob_start();
$_SESSION['showdatactr']=0;
$up = 0;

        $mydb = new db();
        if(isset($_POST["add"])){
        $mydb->addDOline($_POST['dref'],$_POST['qty'],$_POST['tprice'],$_POST['prodSKU']);

        }

        if(isset($_GET["updateDO"])){
          $up = 1;
          $id = $_GET["updateDO"];
          $update = true;
          $record = mysqli_query ($db, "SELECT * FROM do WHERE order_ref = $id");
          $entryrow = $record->fetch_array();

          $cus_id = $entryrow["customer_id"];
          $datef = $entryrow["date_fulfilled"];
          $comment = $entryrow["comment"];
          $orderStatus = $entryrow["order_status"];
}
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="proj_css.css">
    <link rel="stylesheet" type="text/css" href="modal.js">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>

  </head>
  <body>

   <nav class="navbar navbar-light bg-dark text-light justify-content-between shadow p-3">
        <a class="navbar-brand text-light font-weight-bold m-0 " href="">QUEsystem</a>
            <form method = "post" action = "" class="form-inline float-right my-2 ">
            <div class="form-row ">
                <select name="fchoice" class="form-control mr-2" required style="width: 60%">
                  <option value="0">All</option>
                  <option value="6">Pending</option>
                  <option value="7">Completed</option>
                </select>
                <button type="submit" name="filter" class=" btn btn-outline-light"> FILTER </button>
            </div>
          </form>
    </nav>

   <?php
   if(isset($_POST["filter"])){
    $_SESSION['showdatactr'] = $_POST["fchoice"];
    $_SESSION['clicker']=1;
   }
   ?>

<div class="container-fluid ">
        <div class="row my-4">

            <div class="col-2 ml-2 h-100 p-4 " >

              <nav id="sidebar" class="sb-stick my-4">


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
                <a class="nav-link text-dark active" href="ProjectDOPage.php">Order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectReports.php">Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectLoginPage.php" name="LogOut">LogOut</a>
            </li>

          </ul>

          <div class="card mw-100" style="margin: 10px">
        <div class="card-header bg-dark text-light">
          Order Form
        </div>
        <div class="card-body">
            <form method="POST" action="">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <div class="form-group">
                <label for="supplier_id">Customer ID</label>
                <select name="cus_id" class="form-control" required>

                  <?php $mydb = new db();
                    $table = "customerdetails";
                    $result = $mydb->dropdown($table);
                  ?>

                 <?php if ($up==0): ?>
                   <?php
                     while ($data = mysqli_fetch_assoc($result)){
                   ?>
                      echo <option value= <?php echo $data["customer_id"];?>> <?php echo $data["first_name"];?> <?php echo $data["last_name"];?> </option>";
                   <?php } ?>
                 <?php else: ?>
                         <?php
                           $up = 0;
                           $mydb = new db();
                           $sql = mysqli_query ($db, "SELECT CONCAT(first_name,' ',last_name) as name FROM CustomerDetails where customer_id = '$cus_id' ");
                           $res= mysqli_fetch_row($sql);
                          ?>
                         echo <option value= <?php echo $cus_id;?>> <?php echo $res["0"];?> </option>"

                         <?php
                         $mydb = new db();
                         $sql = mysqli_query ($db,"SELECT * FROM $table WHERE entryStatus='ok' AND customer_id != '$cus_id'");
                         while ($data = mysqli_fetch_assoc($sql)){
                         ?>
                             echo <option value= <?php echo $data["customer_id"];?>> <?php echo $data["first_name"];?> <?php echo $data["last_name"];?> </option>";
                         <?php } ?> ?>

                 <?php endif; ?>

                </select>
              </div>

              <?php
              if($update==false){
              echo"<div class='form-group'>
                <label for='Status'>Order</label>
                <input type='radio' value='1' name='stats' class='privChoice' required>
                  <br>
                <label for='Status'>Others</label>
                <input type='radio' value='2' name='stats' class='privChoice' required>
                  <br>
              </div>";
              }else if($update==true){
                if($orderStatus=="not yet delivered"){
                  echo"<div class='form-group'>
                <label for='Status'>Not yet delivered</label>
                <input type='radio' value='1' name='stats' class='privChoice' required>
                  <br>
                <label for='Status'>delivered</label>
                <input type='radio' value='2' name='stats' class='privChoice' required>
                  <br>
              </div>";
                }else if($orderStatus=="for exit"){
                  echo"<div class='form-group'>
                <label for='Status'>For exit</label>
                <input type='radio' value='3' name='stats' class='privChoice' required>
                  <br>
                <label for='Status'>exited</label>
                <input type='radio' value='4' name='stats' class='privChoice' required>
                  <br>
              </div>";
            }
              }
              ?>

              <div class="form-group">
              <label for="comment">Comment</label>
              <input type="text" value="<?php echo $comment?>" name="comment" placeholder="description" class="form-control logon-texts" required>
              </div>

              <?php if($update==true):
                  if (isset($_POST['change'])) {
                  $update == false;
                  header("location: ProjectDOPage.php");
                  }
              ?>

              <button type="submit" name="change" class="btn btn-success float-right login-button">update</button>
              <?php else: ?>
              <button type="submit" name="submit" class="btn btn-success float-right login-button">Submit</button>
              <?php endif; ?>

              <?php
              $mydb = new db();
              if(isset($_POST["submit"])){
              $mydb->addDO($_POST["cus_id"], $_POST["stats"]);
              }

              if(isset($_POST["change"])){
              $mydb->updateDOL($_POST["cus_id"], $_POST["stats"]);
              }
              ?>

            </form>
        </div>
      </div>

      </nav>
      </div>

    <div class="col-9 ml-5 w-100">

            <div class="card w-100"  style="margin: 10px">
          <div class="card-header bg-dark">
            <label class="font-weight-bold text-light">Order List</label>
          </div>
          <div class="card-body">
            <table class="table">

              <?php $mydb = new db();
                    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT d.order_ref, CONCAT(e.firstname,' ',e.lastname) as employee, CONCAT(c.first_name,' ' ,c.last_name) as customer, d.date_fulfilled, d.order_status  FROM DO d, CUSTOMERDETAILS c, EMPLOYEES e WHERE e.emp_id=d.emp_id AND c.customer_id=d.customer_id AND d.entryStatus='ok'";
                    $result = mysqli_query($aVar,$sql);

              ?>

              <?php $mydb = new db();
                    if($_SESSION["showdatactr"]==0){
                   $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT d.order_ref, CONCAT(e.firstname,' ',e.lastname) as employee, CONCAT(c.first_name,' ' ,c.last_name) as customer, d.date_fulfilled, d.order_status  FROM DO d, CUSTOMERDETAILS c, EMPLOYEES e WHERE e.emp_id=d.emp_id AND c.customer_id=d.customer_id AND d.entryStatus='ok'";
                    $result = mysqli_query($aVar,$sql);
                    }else if($_SESSION["showdatactr"]==6){
                    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT d.order_ref, CONCAT(e.firstname,' ',e.lastname) as employee, CONCAT(c.first_name,' ' ,c.last_name) as customer, d.date_fulfilled, d.order_status  FROM DO d, CUSTOMERDETAILS c, EMPLOYEES e WHERE e.emp_id=d.emp_id AND c.customer_id=d.customer_id AND d.entryStatus='ok' AND (d.order_status='not yet delivered'||d.order_status='for exit')";
                    $result = mysqli_query($aVar,$sql);
                    }else if($_SESSION["showdatactr"]==7){
                    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT d.order_ref, CONCAT(e.firstname,' ',e.lastname) as employee, CONCAT(c.first_name,' ' ,c.last_name) as customer, d.date_fulfilled, d.order_status  FROM DO d, CUSTOMERDETAILS c, EMPLOYEES e WHERE e.emp_id=d.emp_id AND c.customer_id=d.customer_id AND d.entryStatus='ok' AND (d.order_status='sold'||d.order_status='exited')";
                    $result = mysqli_query($aVar,$sql);
                    }
              ?>

              <thead>
                <tr>
                  <th scope="col">Order_Ref</th>
                  <th scope="col">Employee</th>
                  <th scope="col">Customer</th>
                  <th scope="col">STATUS</th>
                  <th scope="col">Date Fulfilled</th>
                  <th scope="col-2" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                    <?php while ($data = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                    <td> <?php echo $data["order_ref"];?></td>
                    <td> <?php echo $data["employee"];?></td>
                    <td> <?php echo $data["customer"];?></td>
                    <td> <?php echo $data["order_status"];?></td>
                    <td> <?php echo $data["date_fulfilled"];?></td>

                    <td class="text-center"><a href="DOLine.php?show=<?php echo $data['order_ref']?>" class="btn btn-warning">View</a>

                    <?php if($data["order_status"]=="not yet delivered"||$data["order_status"]=="for exit") { ?>
                    <a href="ProjectDOPage.php?updateDO=<?php echo $data['order_ref']?>" class="btn btn-success">Update</a>

                    <a href="ProjectLandingPage.php?deleteDO=<?php echo $data['order_ref']?>" class="btn btn-danger my-1">Delete</a></td>
                    <?php } ?>
                    </tr>
                    <!--<button class="btn btn-warning">Delete</button>-->
                  <?php } ?>

              </tbody>
              </table>
          </div>
        </div>



</div>
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
