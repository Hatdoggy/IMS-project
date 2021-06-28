<!doctype html>

<?php include "ProjectDBFile.php"?>

<?php
ob_start();
$_SESSION['showdatactr'] = 0;
//Displays current information of entry when attempting to update existing entry.
if(isset($_GET["updateCust"])){

  $id = $_GET["updateCust"];
  $update = true;
  $record = mysqli_query ($db, "SELECT * FROM CustomerDetails WHERE customer_id = $id");
  $entryrow = $record->fetch_array();

      $customer_id = $entryrow["customer_id"];
      $lastname = $entryrow["last_name"];
      $firstname = $entryrow["first_name"];
      $middleinitial = $entryrow["mi"];
      $address = $entryrow["address"];
}
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="proj_css.css">
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
                <a class="nav-link text-dark active" href="ProjectCustomerCRUD.php">Customer</a>
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
                <a class="nav-link text-dark" href="ProjectReports.php">Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectLoginPage.php" name="LogOut">LogOut</a>
            </li>

          </ul>

          <div class="card mw-100" style="margin: 10px">
        <div class="card-header bg-dark text-light ">
          Customer List Form
        </div>
        <div class="card-body">
        <form method="POST" action="">

            <div class="form-group">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
            </div>
            <div class="form-group">
              <label for="firstname">First Name</label>
              <input type="text" value="<?php echo $firstname?>" name="firstname" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="lastname">Last Name</label>
              <input type="text" value="<?php echo $lastname?>" name="lastname" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="middleinitial">Middle Initial</label>
              <input type="text" value="<?php echo $middleinitial?>" name="middleinitial" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" value="<?php echo $address?>" name="address" class="form-control logon-texts" placeholder =""  required>
            </div>

            <?php if($update==true):
                if (isset($_POST['update'])) {
                $update == false;
                header("location: ProjectCustomerCRUD.php");
                }
            ?>

            <button type="submit" name="change" class="btn btn-success float-right login-button">Update</button>
            <?php else: ?>
            <button type="submit" name="submit" class="btn btn-success float-right login-button">Submit</button>
            <?php endif; ?>

            <?php

            $mydb = new db();
            if(isset($_POST["submit"])){
            $mydb->AddCustomer($firstname, $lastname, $middleinitial, $address);
            header("location: ProjectCustomerCRUD.php");
            }
            ?>

            <?php
              if(isset($_POST["change"])){
              $mydb = new db();
              $mydb->updateCustomer();
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
            <label class="font-weight-bold text-light">Customer List</label>
          </div>
          <div class="card-body">
            <table class="table">

              <?php $mydb = new db();
                    $table = "CustomerDetails";
                    $result = $mydb->show_data($table);
              ?>

              <thead>
                <tr>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Middle Initial</th>
                  <th scope="col">Address</th>
                  <th scope="col-2 " class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                    <?php while ($data = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>

                    <td> <?php echo $data["first_name"];?></td>
                    <td> <?php echo $data["last_name"];?></td>
                    <td> <?php echo $data["mi"];?></td>
                    <td> <?php echo $data["address"];?></td>

                    <td class="text-center"><a href="ProjectCustomerCRUD.php?updateCust=<?php echo $data['customer_id']?>" class="btn btn-success">updateCust</a>
                    <a href="ProjectCustomerCRUD.php?deleteCust=<?php echo $data['customer_id']?>" class="btn btn-danger">deleteCust</a></td>
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
