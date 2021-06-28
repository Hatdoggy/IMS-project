  <!doctype html>
<?php include "ProjectDBFile.php" //includes the php file to the index php file?>
<?php
ob_start();
$_SESSION['showdatactr'] = 0;
//Displays current information of entry when attempting to update existing entry.
if(isset($_GET["update"])){

  $id = $_GET["update"];
  $update = true;
  $record = mysqli_query ($db, "SELECT * FROM Employees WHERE emp_id = $id");
  $entryrow = $record->fetch_array();

      $firstname = $entryrow["firstname"];
      $lastname = $entryrow["lastname"];
      $middleinitial = $entryrow["middleinitial"];
      $uname = $entryrow["username"];
      $password = $entryrow["password"];
      $emp_LL = $entryrow["last_login"];
}
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="proj_css.css">
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
                echo "<a class='nav-link text-dark active' href='ProjectEMPCRUD.php'>Employee</a>";
            echo "</li>";
            }else if($_SESSION["CurRank"]=="RegUser"){
            echo "<li class='nav-item'>";
                echo "<a class='nav-link text-dark active' href='#'>Employee</a>";
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
        <div class="card-header bg-dark text-light">
          Employee Form
        </div>
        <div class="card-body">
          <form method="POST" action="">
            
            <div class="form-group">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
              <label for="Username">Username</label>
              <input type="text" value="<?php echo $uname?>" name="username" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="Username">Password</label>
              <input type="password" value="<?php echo $password?>" name="password" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="Username">First Name</label>
              <input type="text" value="<?php echo $firstname?>" name="firstname" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="Username">Last Name</label>
              <input type="text" value="<?php echo $lastname?>" name="lastname" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="Username">Middle Initial</label>
              <input type="text" value="<?php echo $middleinitial?>" name="mi" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="Password">Regular Access</label>
              <input type="radio" value="1" name="rank" class="privChoice" required>
              <label for="Password">Admin</label>
              <input type="radio" value="2" name="rank" class="privChoice" required>
            </div>

            <?php if($update==true):
                if (isset($_POST['update'])) {
                $update == false;
                header("location: ProjectEMPCrud.php");
                }
            ?>

            <button type="submit" name="change" class="btn btn-success float-right login-button">Update</button>
            <?php else: ?>
            <button type="submit" name="submit" class="btn btn-success float-right login-button">Submit</button>
            <?php endif; ?>

            <?php 
            
            $mydb = new db();
            if(isset($_POST["submit"])){
            $mydb->AddEmployee($_POST["firstname"], $_POST["lastname"], $_POST["mi"], $_POST["username"], $_POST["password"],$_POST["rank"]);
            header("location: ProjectEMPCrud.php");
            }
            ?>

            <?php
              if(isset($_POST["change"])){
              $mydb = new db();
              $mydb->update();
              }
            ?>

          </form>
        </div>
      </div>
      
        </nav>
          
    </nav>
            </div>

    <div class="col-9 ml-5 w-100">

            <div class="card w-100"  style="margin: 10px">
          <div class="card-header bg-dark">
            <label class="font-weight-bold text-light">Employee List</label>
          </div>
          <div class="card-body">
            <table class="table">

              <?php $mydb = new db();
                    $table = "Employees";
                    $result = $mydb->show_data($table); 
              ?>

              <thead>
                <tr>
                  <th scope="col">First name</th>
                  <th scope="col">Last name</th>
                  <th scope="col">Middle Initial</th>
                  <th scope="col">Rank</th>
                  <th scope="col-2" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                    <?php while ($data = mysqli_fetch_assoc($result)){
                    ?> 
                    <tr>

                    <td> <?php echo $data["firstname"];?></td>
                    <td> <?php echo $data["lastname"];?></td>
                    <td> <?php echo $data["middleinitial"];?></td>
                    <td> <?php echo $data["rank"];?></td>

                    <td class="text-center"><a href="ProjectEMPCrud.php?update=<?php echo $data['emp_id']?>" class="btn btn-success">Update</a>
                    <a href="ProjectEMPCRUD.php?delete=<?php echo $data['emp_id']?>" class="btn btn-danger">Delete</a></td>
                    </tr>
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