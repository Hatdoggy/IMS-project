  <!doctype html>
<?php include "ProjectDBFile.php" //includes the php file to the index php file?>
<?php
ob_start();
$_SESSION['showdatactr'] = 0;
//Displays current information of entry when attempting to update existing entry.
if($id!=NULL){
  $record = mysqli_query ($db, "SELECT * FROM Product WHERE p_id = $id");
  $entryrow = $record->fetch_array();

  $id = $entryrow["p_id"];
  $sku = $entryrow["product_SKU"];
  $Prodname = $entryrow["name"];
  $location = $entryrow["location"];
  $reorderpoints = $entryrow["reorder_points"];
  $price = $entryrow["price"];
  $DOPrice = $entryrow["DOPrice"];
  $type = $entryrow["product_type"];
  $file = $entryrow["file"];

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
        <form method="POST" action="" class="form-inline text-light float-right ">
              <label for="year" class="mr-1 text-secondary">Enter year to view monthy sales:</label>
              <input type="text" name="year" placeholder="type year" class="form-control"></a>
              <button type="submit" name="submit" class="btn btn-info ml-1"> enter </button>
            </form>
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
                <a class="nav-link text-dark active" href="ProjectDOPage.php">Order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectReports.php">Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectLoginPage.php" name="LogOut">LogOut</a>
            </li>

          </ul>
        </nav>

            </div>

    <div class="col-9 ml-5 w-100">

           <div class="card" style="margin: 10px">
        <div class="card-header bg-dark">
          <span class="text-secondary">Update Product: </span> <?php echo "<h4 class='text-light'>".$Prodname."</h4>"?>

        </div>
        <div class="card-body">
          <form method="POST" action="" >
            
            <div class="form-group">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <label for="sku">product_sku</label>
              <input type="text" value="<?php echo $sku?>" name="sku" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="Prodname">Prodname</label>
              <input type="text" value="<?php echo $Prodname?>" name="Prodname" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="location">location</label>
              <input type="text" value="<?php echo $location?>" name="location" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="reorderpoints">reorderpoints</label>
              <input type="number" value="<?php echo $reorderpoints?>" name="reorderpoints" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="price">price</label>
              <input type="number" value="<?php echo $price?>" name="price" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="DOPrice">DOPrice</label>
              <input type="number" value="<?php echo $DOPrice?>" name="DOPrice" class="form-control logon-texts" placeholder =""  required>
            </div>
            <div class="form-group">
              <label for="Password">Food</label>
              <input type="radio" value="1" name="Ftype" class="FoodChoice" required>
              <label for="Password">Non-Food</label>
              <input type="radio" value="2" name="Ftype" class="FoodChoice" required>
            </div>

            <button type="submit" name="ProdChange" class="btn btn-success float-right login-button">Update</button>        
        

            <?php
              if(isset($_POST["ProdChange"])){
              $mydb = new db();
              $mydb->Produpdate();
              }
            ?>

          </form>
        </div>
      </div>

      <div class="card"  style="margin: 10px">
          <div class="card-header bg-dark text-light">
            Sales per Month
          </div>

          <div class="card-body">
            <table class="table">
              <thead>
              </thead>
              <tbody>

                    <?php
                    if(isset($_POST['submit'])){

                      $year = $_POST['year'];

              echo"<thead>
                <tr>
                  <th scope='col'>MONTH</th>
                  <th scope='col'>PRODUCT</th>
                  <th scope='col'>SOLD</th>
                  <th scope='col'>YEAR:($year)</th>
                </tr>
             </thead>";

                      $x = 1;
                      $month_name = "";
                      while($x!=13){

                        $month_name = date("F", mktime(0, 0, 0, $x, 10));
                        
                        $data = "SELECT do.`prodName` AS PRODUCT, SUM(do.`qty`) AS TOTAL, month(d.`date_fulfilled`) AS MONTH
                        FROM do d, do_line do WHERE d.`order_ref` = do.`order_ref` AND month(d.`date_fulfilled`)='$x' AND year(d.`date_fulfilled`)='$year' AND do.`prodName`='$Prodname' AND d.`customer_id`!='0' GROUP BY do.`prodName`";

                        $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
                        $result = mysqli_query($aVar,$data);
                        $data = mysqli_fetch_assoc($result);
                        
                        if($data){
                        echo "<tr>";
                        echo "<td>".$month_name."</td>";
                        echo "<td>".$Prodname."</td>";
                        echo "<td>"."<b>".$data['TOTAL']."</td>"."</b>";
                        echo "</tr>";
                        ++$x;
                      }else{
                        echo "<tr>";
                        echo "<td>".$month_name."</td>";
                        echo "<td>".$Prodname."</td>";
                        echo "<td>"."<b> No products sold during this month </b>"."</td>";
                        echo "</tr>";
                        ++$x;
                      }
                      }
                    }
                    ?>

              </tbody>
              </table>
          </div>
        </div>

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