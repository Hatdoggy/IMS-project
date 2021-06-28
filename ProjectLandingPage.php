<!doctype html>

<?php include "ProjectDBFile.php"?>

<?php 
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
                <a class="nav-link text-dark active" href="ProjectLandingPage.php">Main <span class="sr-only">(current)</span></a>
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
                <a class="nav-link text-dark" href="ProjectReports.php">Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="ProjectLoginPage.php" name="LogOut">LogOut</a>
            </li>

          </ul>
        </nav>

    </nav>
            </div>

        <div class="col-9 ml-5 w-100">
            
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
              <h4>List of Products</h4>
              <div class="ml-auto" id="navbarNav">

              <div class="mr-5 px-2 btn-toolbar">
                <a href="" class="border-white btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">add</a>
                <a href="" class="border-white btn btn-danger" data-toggle="modal" data-target="#deleteModalCenter">delete</a>

              <form method = "post" class="form-inline px-2" action = "">
                <div class="btn-goup">
                  <select name="fchoice" class="form-control" required>
                    <option value="0">All</option>
                    <option value="1">Food</option>
                    <option value="2">Non-Food</option>
                    <option value="3">Needs Restocking (FOOD)</option>
                    <option value="4">Needs Restocking (NON-FOOD)</option>
                  </select>
                  <button class="btn filter-button" type="submit" name="filter"> FILTER </button>
                </div>
              </form>
              </div>
              </div>

            </nav>

            <?php 
   if(isset($_POST["filter"])){
    $_SESSION['showdatactr'] = $_POST["fchoice"];
    $_SESSION['clicker']=1;
   }
   ?>
    
    
    <div class="prod-list">
      <?php
        $mydb = new db();
        $table = "product";
          if(isset($_POST["add"])&&isset($_FILES["uploadFile"])){
            
            $file = $_FILES["uploadFile"]["name"];

            $mydb->uploadFile($_FILES['uploadFile']); 
            
            $mydb->AddProduct($file,$SKU, $reorderPoints, $prodName, $location,$price,$DOPrice,$type);
            header("location: ProjectLandingPage.php");
          }
          if(isset($_POST["delProd"])){

            $mydb->deleteProd($_POST["delSKU"]);
            //$result = $mydb->show_data($table); 
          }
      ?>

      <?php $mydb = new db();
          $result = $mydb->show_data("product"); 
        ?>
      <?php while ($data = mysqli_fetch_assoc($result)) {
        ?> 
        <?php

        if($data["product_qty"]<=$data["reorder_points"]){
        echo "<span class='card m-4 p-4 less ' >";
        }else{
        echo "<span class='card m-4 p-4 greater'>";
        }
        ?>
        <tr>
        <td> <?php 
                  
                  echo "<img class='card-img-top w-80' src='images/".$data['file']." 'alt='Card image cap' style='height: 200px;' >";
                  echo "<div class='card-body'>";
                  echo "<div class='card-text'>";
         ?></td>
        <td><a  class="text-dark" href="product_info.php?updateProd=<?php echo $data['p_id']?>"><?php echo "Product Name: <span class='font-weight-bold'>".$data["name"]; echo "</span><br>";?></a></td>
        <td> <?php echo "<br>Currently Available: ".$data["product_qty"]; echo "<br>"?></td>
        <td> <?php echo "No. of Sold:".$data["sold_qty"]; echo "<br>"?></td>
        <td> <?php echo "Waste Quantity:".$data["waste_qty"];
                    echo "</div>";
                    echo "</div>";
        ?></td>
        </tr>
      </span>
   <?php } ?>


        </div>

</div>
</div>

  

  <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="exampleModalLongTitle">Add Product</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        
        <form method = "post" action = "" enctype="multipart/form-data">

          <label for="Username" class="col-form-label">Product SKU</label>
          <input type="text" placeholder="SKU" name="SKU" class="form-control logon-texts" required>
          <br>

          <label for="Reorder Point">Reorder Points</label>
          <input type="number" placeholder="reorderPoints" name="reorderPoints" class="form-control logon-texts" required>
          <br>
          <label for="Product Name">Product Name</label>
          <input type="text" placeholder="prodName" name="prodName" class="form-control logon-texts" required>
          <br>
          <label for="Location">Location</label>
          <input type="text" placeholder="location" name="location" class="form-control logon-texts" required>
          <br>
          <label for="Price">Supplier Selling Price</label>
          <input type="number" placeholder="price" name="price" class="form-control logon-texts" required>
          <br>
          <label for="DOPrice">Company Selling Price</label>
          <input type="number" placeholder="DOPrice" name="DOPrice" class="form-control logon-texts" required>
          <br>
          <label for="Type">Type</label>
          <input type="file" name="uploadFile" class="form-control-file" id="exampleFormControlFile1">
          <br>
          <label for="Type">Type</label>
          <select name="type" class="form-control" required>
            <option value="food">Food</option>
            <option value="non-food">Non-Food</option>
          </select>
          <br>
      
        <button type="submit" name="add" class="btn btn-success float-right">Add</button>

        
      </form>
      
      </div>
    </div>
  </div>
</div>
  
  <!-- DELETE MODAL -->

  <div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title text-dark" id="exampleModalLongTitle">Delete Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form method = "post" action = "">

          <label for="Username" class="col-form-label">Product SKU</label>
          <input type="text" placeholder="delSKU" name="delSKU" class="form-control logon-texts" required>
          <br>
        <button type="submit" name="delProd" class="btn btn-danger float-right">Delete</button>

        
      </form>
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