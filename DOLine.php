<!doctype html>
<?php include "ProjectDBFile.php" //includes the php file to the index php file?>
<?php
$_SESSION['showdatactr'] = 9;
//Displays current information of entry when attempting to update existing entry.
if(isset($_GET["show"])){
  $_SESSION['dol_id'] = $_GET["show"];
  /*    $eta = $entryrow["eta"];
      $etd = $entryrow["etd"];
      $qty = $entryrow["qty"];
      $totalprice = $entryrow["totalprice"];
      $date_fulfilled = $entryrow["date_fulfilled"];
      $prod_SKU = $entryrow["product_SKU"];
  */
}

if(isset($_GET["update"])){

  $id = $_GET["update"];
  $update = true;
  $record = mysqli_query($db, "SELECT * FROM DO_line WHERE orderline_id = $id");
  $entryrow = $record->fetch_array();

      $prodName = $entryrow["prodName"];
      $quantity= $entryrow["qty"];
      $totalprice= $entryrow["totalprice"];

}

?>

<?php
  if(isset($_POST["change"])){
  $mydb = new db();
  $mydb->updateDOLine();
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

    </nav>


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
            <li class="nav-item active">
                <a class="nav-link text-dark" href="#"><?php echo "Order: ".$_SESSION['dol_id'] ?></a>
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
              Order-line Form
            </div>

            <div class="card-body">
        <form method="POST" action="">

              <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="prodName">Product Name</label>
                <input type="text" value="<?php echo $prodName ?>" name="name" class="form-control logon-texts" placeholder =""  required>
              </div>

              <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" value="<?php echo $quantity?>" name="quantity" class="form-control logon-texts" placeholder =""  required>
              </div>

              <?php if($update==true):
                  if (isset($_POST['update'])) {
                  $update == false;
                  header("location: ProjectDOPage.php");
                  }
              ?>

              <button type="submit" name="change" class="btn btn-success float-right login-button">Update</button>
              <?php else: ?>
                <?php 
                   $temp = $_SESSION['dol_id'];
                   $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                   $result = mysqli_query($aVar, "SELECT * FROM DO WHERE order_ref='$temp'");
                   $row = mysqli_fetch_array($result);

                  if($row["order_status"]=="not yet delivered"||$row["order_status"]=="for exit"){
                ?>
              <button type="submit" name="submit" class="btn btn-success float-right login-button">Add Product</button>
              <?php } ?>
              <?php endif; ?>

            </form>

            </div>
          </div>

        </nav>

</div>
<div class="col-9 ml-5 w-100">

           <div class="card w-100"  style="margin: 10px">
          <div class="card-header bg-dark text-light">
            <label class="font-weight-bold text-light">Order information</label>

          </div>

          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Order_Ref</th>
                  <th scope="col">Employee</th>
                  <th scope="col">Customer</th>
                  <th scope="col">Date Fulfilled</th>
                  <th scope="col">STATUS</th>
                  <th scope="col">Comment</th>
                </tr>
              </thead>
              <tbody>

                    <?php
                    $DOdisplay = $_SESSION['dol_id'];
                    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                    $sql = "SELECT d.order_ref, CONCAT(e.firstname,' ',e.lastname) as employee, CONCAT(c.first_name,' ',c.last_name) as Customer, d.emp_id, d.customer_id, d.order_status, d.date_fulfilled, d.comment FROM DO d, CustomerDetails c, EMPLOYEES e WHERE e.emp_id=d.emp_id AND d.customer_id=c.customer_id AND d.order_ref=$DOdisplay";

                    $result = mysqli_query($aVar,$sql);

                    while ($data = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                    <td> <?php echo $data["order_ref"];?></td>
                    <td> <?php echo $data["employee"];?></td>
                    <td> <?php echo $data["Customer"];?></td>
                    <td> <?php echo $data["date_fulfilled"];?></td>
                    <td> <?php echo $data["order_status"];?></td>
                    <td> <?php echo $data["comment"];?></td>
                    </tr>
                    <!--<button class="btn btn-warning">Delete</button>-->
                  <?php } ?>

              </tbody>
              </table>
          </div>
        </div>


         <div class="card w-100"  style="margin: 10px">
          <div class="card-header bg-dark text-light">
            <label class="font-weight-bold text-light">Order-Line List</label>
          </div>

          <div class="card-body">

            <?php

              $mydb = new db();
              if(isset($_POST["submit"])){
                $cresult =0;
                $cresult = $mydb->checkProd($_POST["name"]);
                if($cresult!=1){
                  $mydb->addDOL($id, $_POST["quantity"], $_POST["name"]);

                }else {

                  echo "<div class='alert alert-warning alert-dismissible fade show'>PRODUCT NAME NOT RECOGNIZED
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                        </div>";
                }

              }else if(isset($_POST["change"])){
                  $cresult = $mydb->checkProd($_POST["name"]);
                  if($cresult!=1){
                  $mydb->updateDOLine($id, $_POST["quantity"], $_POST["name"]);
                }else {
                  echo "<div class='alert alert-warning alert-dismissible fade show'>PRODUCT NAME NOT RECOGNIZED
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                        </div>";
                }
              }

              ?>

            <table class="table">

              <?php $mydb = new db();
                    $table = "DO_LINE";
                    $result = $mydb->show_data($table);
              ?>

              <thead>
                <tr>
                  <th scope="col">Order-Line_ID</th>
                  <th scope="col">Order_Ref</th>
                  <th scope="col">Product Name</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total Price</th>
                  <th scope="col-2">Action</th>

                </tr>
              </thead>
              <tbody>
                    <?php while ($data = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                    <td> <?php echo $data["orderline_id"];?></td>
                    <td> <?php echo $data["order_ref"];?></td>
                    <td> <?php echo $data["prodName"];?></td>
                    <td> <?php echo $data["qty"];?></td>
                    <td> <?php echo "₱ ".$data["totalprice"];?></td>

                    <?php

                      $result2 = "";
                      $getter = "";
                      $temp = $data["order_ref"];
                      $result2 = "SELECT order_status FROM DO WHERE order_ref = '$temp'";
                      $getter = mysqli_query($aVar,$result2);
                      $result2 = mysqli_fetch_assoc($getter);

                     if($result2["order_status"]=="not yet delivered"||$result2["order_status"]=="for exit") {?>
                    <td><a href="ProjectDBFile.php?deleteDOline=<?php echo $data['orderline_id']?>" class="btn btn-warning">Delete</a></td>
                    </tr>
                    <?php } ?>

                    </tr>
                    <!--<button class="btn btn-warning">Delete</button>-->
                  <?php } ?>

              </tbody>
              </table>
          </div>
        </div>
</div>

<!-- ========================================= -->

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
