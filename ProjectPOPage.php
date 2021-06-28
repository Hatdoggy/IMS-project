<!doctype html>

<?php include "ProjectDBFile.php"?>

<?php
if($_SESSION['clicker']==0){
  $_SESSION['showdatactr']=0;
}else{
  $_SESSION['clicker']==0;
}
?>

<?php
//Displays current information of entry when attempting to update existing entry.\
$dcount =0;
$up =0;
$up1 = 0;
if(isset($_GET["update"])){

  $up = 1;
  $up1 = 1;
  $id = $_GET["update"];
  $update = true;
  $record = mysqli_query ($db, "SELECT * FROM PO WHERE purchaseorder_ref = $id");
  $entryrow = $record->fetch_array();

      $supp_id= $entryrow["supplier_id"];
      $eta = $entryrow["eta"];
      $etd = $entryrow["etd"];
      $paymentmethod= $entryrow["paymentmethod"];
      $datef = $entryrow["date_fulfilled"];
      $stats = $entryrow["purchaseorder_status"];

}
?>
<?php
  if(isset($_POST["change"])){

  $date1 = $_POST["eta"];
  $date2 = $_POST["etd"];
  if ($date2 > $date1) {
     $dcount++;
  }else{
    $mydb = new db();
    $mydb->updatePO();
    $dcount=0;

  }

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
                  <option value="8">Cancelled</option>
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
                <a class="nav-link text-dark active" href="ProjectPOPage.php">Purchase Stocks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectDOPage.php">Order</a>
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
            <?php echo "$up"; ?>
            PO Form
          </div>
          <div class="card-body">
                        <form method="POST" action="">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <div class="form-group">
                <label for="supplier_id">Supplier ID</label>
                <select name="supplier_id" class="form-control" required>

                  <?php
                    $mydb = new db();
                    $table = "SUPPLIER";
                    $result = $mydb->dropdown($table);
                  ?>


                  <?php if ($up==0): ?>
                    <?php
                      while ($data = mysqli_fetch_assoc($result)){
                    ?>
                          echo <option value= <?php echo $data["supplier_id"];?>> <?php echo $data["name"];?> </option>";
                      <?php } ?>
                  <?php else: ?>
                          <?php
                            $up = 0;
                            $mydb = new db();
                            $sql = mysqli_query ($db, "SELECT name FROM Supplier where supplier_id = '$supp_id' ");
                            $res= mysqli_fetch_row($sql);
                           ?>
                          echo <option value= <?php echo $supp_id;?>> <?php echo $res["0"];?> </option>"

                          <?php
                          $mydb = new db();
                          $sql = mysqli_query ($db,"SELECT * FROM $table WHERE entryStatus='ok' AND supplier_id != '$supp_id'");
                          while ($data = mysqli_fetch_assoc($sql)){
                          ?>
                              echo <option value= <?php echo $data["supplier_id"];?>> <?php echo $data["name"];?> </option>";
                          <?php } ?> ?>

                  <?php endif; ?>


                </select>
              </div>

              <div class="form-group">
                <label for="ETA">ETA</label>
                <input type="date" value="<?php echo $eta?>" name="eta" class="form-control logon-texts" required>
              </div>

              <div class="form-group">
              <label for="ETD">ETD</label>
              <input type="date" value="<?php echo $etd?>" name="etd" class="form-control logon-texts" required>
              </div>

              <div class="form-group">
              <label for="Paymentmethod">Payment Method</label>
              <select name="paymentM" class="form-control" required>
              <?php if ($up1==0): ?>


                  <option value="cash">cash</option>
                  <option value="credit">credit</option>
                  <option value="none">none</option>
                </select>
              <?php else: ?>

                  <?php $up1 = 0; ?>

                  <option value="<?php echo $paymentmethod;?>"><?php echo $paymentmethod;?></option>
                  <?php if ($paymentmethod === 'cash'): ?>
                    <option value="credit">credit</option>
                    <option value="none">none</option>
                  <?php endif; ?>
                  <?php if ($paymentmethod === 'credit'): ?>
                    <option value="cash">cash</option>
                    <option value="none">none</option>
                  <?php endif; ?>
                  <?php if ($paymentmethod === 'none'): ?>
                    <option value="cash">cash</option>
                    <option value="credit">credit</option>
                  <?php endif; ?>



              <?php endif; ?>
            </select>


              </div>

              <div class="form-group">
                <?php if($update==true) { ?>

                <label for="Status">Complete</label>
                <input type="radio" value="2" name="stats" class="privChoice" required>
                  <br>

                <label for="Status">Cancelled</label>
                <input type="radio" value="3" name="stats" class="privChoice" required>
                  <br>

                <?php } ?>
              </div>

              <?php if($update==true):
                  if (isset($_POST['update'])) {
                  $update == false;
                  header("location: ProjectPOPage.php");
                  }

              ?>

              <button type="submit" name="change" class="btn btn-success float-right login-button">Update</button>
                  <?php else: ?>
              <button type="submit" name="submit" class="btn btn-success float-right login-button">Submit</button>
                  <?php endif; ?>


              <?php
              $mydb = new db();
              if(isset($_POST["submit"])){
                $date1 = $_POST["eta"];
                $date2 = $_POST["etd"];
                if ($date2 > $date1) {
                  $dcount++;
                }else {
                  $mydb->addPurchaseOrder($_POST["supplier_id"], $_POST["eta"], $_POST["etd"], $_POST["paymentM"]);
                  $dcount = 0;
                }

              }
              ?>

              <?php
                if ($dcount != 1) {
                  $dcount = 0;
                }else {
                }
               ?>



            </form>
          </div>
        </div>

        </nav>

</div>

<div class="col-9 ml-5 w-100">

            <div class="card w-100"  style="margin: 10px">
          <div class="card-header bg-dark ">

              <label class="font-weight-bold text-light">PO-Receiving List</label>
            </div>

          <div class="card-body">

              <?php
                if ($dcount != 1) {
                  $dcount = 0;
                }else {

                  echo "<div class='alert alert-warning alert-dismissible fade show'>INVALID ETA/ETD PLEASE TRY AGAIN
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                        </div>";
                }
              ?>

            <table class="table">

              <?php $mydb = new db();
                    if($_SESSION["showdatactr"]==0){
                    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT p.purchaseorder_ref, CONCAT(e.firstname,' ',e.lastname) as employee, s.name as supplier, p.eta, p.etd, p.po_totalprice, p.date_fulfilled, p.paymentmethod, p.purchaseorder_status  FROM PO p, SUPPLIER s, EMPLOYEES e WHERE e.emp_id=p.emp_id AND s.supplier_id=p.supplier_id AND p.entryStatus='ok'";
                    $result = mysqli_query($aVar,$sql);
                    }else if($_SESSION["showdatactr"]==6){
                    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT p.purchaseorder_ref, CONCAT(e.firstname,' ',e.lastname) as employee, s.name as supplier, p.eta, p.etd, p.po_totalprice, p.date_fulfilled, p.paymentmethod, p.purchaseorder_status  FROM PO p, SUPPLIER s, EMPLOYEES e WHERE e.emp_id=p.emp_id AND s.supplier_id=p.supplier_id AND p.entryStatus='ok' AND p.purchaseorder_status='pending'";
                    $result = mysqli_query($aVar,$sql);
                    }else if($_SESSION["showdatactr"]==7){
                    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT p.purchaseorder_ref, CONCAT(e.firstname,' ',e.lastname) as employee, s.name as supplier, p.eta, p.etd, p.po_totalprice, p.date_fulfilled, p.paymentmethod, p.purchaseorder_status  FROM PO p, SUPPLIER s, EMPLOYEES e WHERE e.emp_id=p.emp_id AND s.supplier_id=p.supplier_id AND p.entryStatus='ok' AND p.purchaseorder_status='complete'";
                    $result = mysqli_query($aVar,$sql);
                    }else if($_SESSION["showdatactr"]==8){
                    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT p.purchaseorder_ref, CONCAT(e.firstname,' ',e.lastname) as employee, s.name as supplier, p.eta, p.etd, p.po_totalprice, p.date_fulfilled, p.paymentmethod, p.purchaseorder_status  FROM PO p, SUPPLIER s, EMPLOYEES e WHERE e.emp_id=p.emp_id AND s.supplier_id=p.supplier_id AND p.entryStatus='ok' AND p.purchaseorder_status='cancelled'";
                    $result = mysqli_query($aVar,$sql);
                    }
              ?>

              <thead>
                <tr>
                  <th scope="col">PO_REF</th>
                  <th scope="col">Employee</th>
                  <th scope="col">Supplier</th>
                  <th scope="col" class="text-center">ETA</th>
                  <th scope="col" class="text-center">ETD</th>
                  <th scope="col">PaymentMethod</th>
                  <th scope="col">Total Price</th>
                  <th scope="col">Date Fulfilled</th>
                  <th scope="col">STATUS</th>
                  <th scope="col-2" class="text-center">Action</th>
                </tr>
              </thead>

              <tbody>
                    <?php while ($data = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                    <td> <?php echo $data["purchaseorder_ref"];?></td>
                    <td> <?php echo $data["employee"];?></td>
                    <td> <?php echo $data["supplier"];?></td>
                    <td> <?php echo $data["eta"];?></td>
                    <td> <?php echo $data["etd"];?></td>
                    <td> <?php echo $data["paymentmethod"];?></td>
                    <td> <?php echo "₱ ".$data["po_totalprice"];?></td>
                    <td> <?php echo $data["date_fulfilled"];?></td>
                    <td> <?php echo $data["purchaseorder_status"];?></td>

                    <td class="text-center "><a href="POLine.php?show=<?php echo $data['purchaseorder_ref']?>" class="btn btn-warning my-1">View</a>
                    <?php if($data["purchaseorder_status"]!="complete"&&$data["purchaseorder_status"]!="cancelled"){ ?>
                    <a href="ProjectPOPage.php?update=<?php echo $data['purchaseorder_ref']?>" class="btn btn-success">Update</a>
                    <a href="ProjectPOPage.php?deletePO=<?php echo $data['purchaseorder_ref']?>" class="btn btn-danger my-1">Delete</a></td>
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
