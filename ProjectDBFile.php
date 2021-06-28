<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    $id = 0;
    $uname = "";
    $password = "";
    $emp_LL = "";
    $result = "";
    $row = "";
    $firstname = "";
    $lastname = "";
    $middleinitial = "";
    $rank = "";
    $update = "";
    $supplier_id = 0;
    $name = "";
    $email = "";
    $address = "";
  $SKU = "";
  $reorderPoints = "";
  $prodName = "";
  $location = "";
  $price = 0;
  $DOPrice = 0;
  $type = "";
  $_SESSION['clicker'] = 0;
  $customer_id = 0;
  $etd = "";
  $eta = "";
  $pmethod = "";
  $emp_id = "";
  $supp_id= "";
  $eta = "";
  $etd = "";
  $paymentmethod= "";
  $datef = "";
  $stats = "";
  $productSKU = "";
  $quantity= 0;
  $totalprice = 0;
  $priceGetter=0.00;
  $updateQTY=0;
  $cus_id = 0;
  $stats = "";
  $vat = 0;
  $comment ="";

class db {

  private $supported_format =["image/png","image/jpg","image/jpeg"];
    public $connection;

    public function __construct(){

        $this -> connection = mysqli_connect("localhost","root","","QUEINV_DB");

        if(mysqli_connect_error()){
            die("Failed to connect to the database!");
        }
        else{
        }

    }

function update(){

    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middleinitial = $_POST["mi"];
    $uname = $_POST["username"];
    $password = $_POST["password"];
    $rank = $_POST["rank"];
    $encrypt_password = md5($password);

    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
    $result = mysqli_query($aVar, "SELECT username, emp_id FROM Employees WHERE username='$uname'");
    $row = mysqli_fetch_array($result);
if($row==0 || $row['emp_id']==$id || $row['entryStatus']=="deleted"){
    if($rank==1){
        $rank = "RegUser";
    }else{
        $rank = "Admin";
    }

    $sql = "UPDATE Employees SET firstname = '$firstname', lastname='$lastname', middleinitial='$middleinitial', username='$uname', password='$encrypt_password', rank='$rank' WHERE emp_id = '$id'";
    $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
    header("location: ProjectEMPCRUD.php");

    if($query){
        echo "SUCCESS!";
    }else{
        echo "FAILED!";
    }
}else if($row["username"]==$uname){
    echo "Duplication Found. Username already exists";
}

}

function Produpdate(){

  $id = $_POST["id"];
  $sku = $_POST["sku"];
  $Prodname = $_POST["Prodname"];
  $location = $_POST["location"];
  $reorderpoints = $_POST["reorderpoints"];
  $price = $_POST["price"];
  $DOPrice = $_POST["DOPrice"];
  $type = $_POST["Ftype"];

    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
    $result = mysqli_query($aVar, "SELECT * FROM Product WHERE p_id='$id'");
    $row = mysqli_fetch_array($result);
if($row==0 || $row['p_id']==$id || $row['entryStatus']=="deleted"){
    if($type==1){
        $type = "food";
    }else{
        $type = "non-food";
    }

    $sql = "UPDATE Product SET product_SKU = '$sku', name='$Prodname', location='$location', reorder_points='$reorderpoints', price='$price',DOPrice='$DOPrice', product_type='$type' WHERE p_id = '$id'";
    $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
    header("location: ProjectLandingPage.php");


    if($query){
        echo "SUCCESS!";
    }else{
        echo "FAILED!";
    }
}else if($row["name"]==$name || $row["product_SKU"]==$sku){
    echo "Duplication Found. Name/SKU already exists";
}

}

function updateSupplier(){
    $supplier_id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
    $result = mysqli_query($aVar, "SELECT name, email, supplier_id FROM SUPPLIER WHERE email='$email'");
    $row = mysqli_fetch_array($result);
if($row==0 || ($supplier_id == $row['supplier_id'] ||$row['entryStatus']=="deleted")){
    $sql = "UPDATE SUPPLIER SET name = '$name', email = '$email', address='$address' WHERE supplier_id = '$supplier_id'";
    $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
    header("location: ProjectSupplierCRUD.php");

    if($query){
        echo "SUCCESS!";
    }else{
        echo "FAILED!";
    }
}else if($row["email"]==$email){
    echo "Duplication Found. Email already exists";
}

}

function updateCustomer(){
    $customer_id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middleinitial = $_POST['middleinitial'];
    $address = $_POST["address"];

    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
    $result = mysqli_query($aVar, "SELECT * FROM SUPPLIER WHERE first_name='$firstname' AND last_name='$last_name' AND mi='$middleinitial'");
    $row = mysqli_fetch_array($result);

if($row==0 || ($customer_id == $row['customer_id']) ||$row['entryStatus']=="deleted"){
    $sql = "UPDATE CustomerDetails SET first_name = '$firstname', last_name = '$lastname', mi = '$middleinitial', address='$address' WHERE customer_id = '$customer_id'";
    $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
    header("location: ProjectCustomerCRUD.php");

    if($query){
        echo "SUCCESS!";
    }else{
        echo "FAILED!";
    }
}else{
    echo "Duplication Found. Email already exists";
}

}


function login_form($uname, $password){

$_SESSION['name'] = $_POST["username"];
$_SESSION['pass'] = $_POST["password"];
$uname = $_SESSION['name'];
$password = $_SESSION['pass'];
$encrypt_password = md5($password);
$date = date('Y-m-d H:i:s');

// Connect to the database
$aVar = mysqli_connect("localhost","root","","QUEINV_DB");

$result = mysqli_query($aVar, "SELECT * FROM Employees WHERE username='$uname' AND password='$encrypt_password' AND entryStatus='ok'");

if($result){

}else{
    die(mysqli_error($aVar));
}

$row = mysqli_fetch_array($result);
if($row==0){
    echo "Sorry, your credentials are not valid, Please try again.";
}
else if($row["username"]==$uname && $row["password"]==$encrypt_password){
    header("location: ProjectLandingPage.php");
    echo "You are a validated user.";
    $_SESSION['CurRank'] = 0;
    $_SESSION['CurRank'] = $row["rank"];
    $temp_id = "";
    $temp_id = $row["emp_id"];
    $_SESSION['idget'] = 0;
    $_SESSION['idget'] = $row["emp_id"];
    $sql = "UPDATE Employees SET last_login='$date' WHERE emp_id = '$temp_id'";
    $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
}
}

function AddEmployee($firstname, $lastname, $middleinitial, $rank, $username, $password){

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$middleinitial = $_POST["mi"];
$rank = $_POST["rank"];
$uname = $_POST["username"];
$password = $_POST["password"];
$encrypt_password=md5($password);

$aVar = mysqli_connect("localhost","root","","QUEINV_DB");

$result = mysqli_query($aVar, "SELECT username, password FROM Employees WHERE username='$uname' AND entryStatus='ok'");

if($result){

}else{
    die(mysqli_error($aVar));
}

$row = mysqli_fetch_array($result);

if($row==0){
        if($rank == 1){
        $sql = "INSERT INTO Employees (firstname, lastname, middleinitial, rank, username, password, last_login)
        VALUES ('$firstname', '$lastname', '$middleinitial', 'RegUser', '$uname', '$encrypt_password', 0);";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        mysqli_query($this->connection,"CREATE USER '$username'@'localhost' IDENTIFIED BY '$password'");
        mysqli_query($this->connection,"GRANT SELECT, INSERT, UPDATE ON QUEINV_DB.SUPPLIER TO '$username'@'localhost'");
        mysqli_query($this->connection,"GRANT SELECT, INSERT, UPDATE ON QUEINV_DB.CustomerDetails TO '$username'@'localhost'");
        mysqli_query($this->connection,"GRANT SELECT, INSERT, UPDATE ON QUEINV_DB.Product TO '$username'@'localhost'");
        mysqli_query($this->connection,"GRANT SELECT, INSERT, UPDATE ON QUEINV_DB.PO TO '$username'@'localhost'");
        mysqli_query($this->connection,"GRANT SELECT, INSERT, UPDATE ON QUEINV_DB.OrderDetails TO '$username'@'localhost'");
        mysqli_query($this->connection,"GRANT SELECT, INSERT, UPDATE ON QUEINV_DB.FOOD_CATALOGUE TO '$username'@'localhost'");
        mysqli_query($this->connection,"GRANT SELECT, INSERT, UPDATE ON QUEINV_DB.warehouse TO '$username'@'localhost'");

    }else{
        $sql = "INSERT INTO Employees (firstname, lastname, middleinitial, rank, username, password, last_login)
        VALUES ('$firstname', '$lastname', '$middleinitial', 'Admin', '$uname', '$encrypt_password', 0);";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        "CREATE USER '$username'@'localhost' IDENTIFIED BY '$password'";
        "GRANT ALL PRIVILEGES ON QUEINV_DB.* TO '$username'@'localhost'";
    }
}
else if($row["username"]==$uname){
    echo "Duplication Found. Username already exists";
}

}

function AddSupplier($name, $email, $address){
$name = $_POST['name'];
$email = $_POST["email"];
$address = $_POST["address"];

$aVar = mysqli_connect("localhost","root","","QUEINV_DB");

$result = mysqli_query($aVar, "SELECT email FROM supplier WHERE email='$email' AND entryStatus='ok'");

if($result){

}else{
    die(mysqli_error($aVar));
}

$row = mysqli_fetch_array($result);

if($row==0){
        $sql = "INSERT INTO SUPPLIER (name, email, address)
        VALUES ('$name', '$email', '$address');";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
}
else if($row["email"]==$email){
    echo "Duplication Found. email already registered";
}

}

function AddCustomer($firstname, $lastname, $middleinitial, $address){
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$middleinitial = $_POST['middleinitial'];
$address = $_POST["address"];

$aVar = mysqli_connect("localhost","root","","QUEINV_DB");

$result = mysqli_query($aVar, "SELECT * FROM CustomerDetails WHERE first_name='$firstname' AND last_name='$lastname' AND mi='$middleinitial' AND entryStatus='ok'");

if($result){

}else{
    die(mysqli_error($aVar));
}

$row = mysqli_fetch_array($result);

if($row==0){
        $sql = "INSERT INTO CustomerDetails (first_name, last_name, mi, address)
        VALUES ('$firstname', '$lastname', '$middleinitial', '$address');";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
}
else{
    echo "Duplication Found. email already registered";
}

}

function dropdown($table){
    $sql = "SELECT * FROM $table WHERE entryStatus='ok'";
    $result = mysqli_query($this->connection,$sql);
    if($result){
        return $result;
    }
}

function show_data($table){
        $x = $_SESSION['showdatactr'];

        if($x==0){
        $sql = "SELECT * FROM $table WHERE entryStatus='ok'";
        $result = mysqli_query($this->connection,$sql);
        if($result){
            return $result;
        }
    }else if($x==1){
        $sql = "SELECT * FROM Product WHERE product_type='food' AND entryStatus='ok'";
        $result = mysqli_query($this->connection,$sql);
        if($result){
            return $result;
        }
    }else if($x==2){
        $sql = "SELECT * FROM Product WHERE product_type='non-food' AND entryStatus='ok'";
        $result = mysqli_query($this->connection,$sql);
        if($result){
            return $result;
        }
    }else if($x==3){
        $sql = "SELECT * FROM Product WHERE product_type='food' AND entryStatus='ok' HAVING product_qty <= reorder_points";
        $result = mysqli_query($this->connection,$sql);
        if($result){
            return $result;
        }
    }else if($x==4){
        $sql = "SELECT * FROM Product WHERE product_type='non-food' AND entryStatus='ok' HAVING product_qty <= reorder_points";
        $result = mysqli_query($this->connection,$sql);
        if($result){
            return $result;
        }
    }else if($x==5){
        $pol_id = "";
        $pol_id = $_SESSION['pol_id'];
         $sql = "SELECT * FROM PO_LINE WHERE purchaseorder_ref='$pol_id'";
         $result = mysqli_query($this->connection,$sql);
         if($result){
             return $result;
         }
    }else if($x==6){
        $sql = "SELECT * FROM PO WHERE entryStatus='ok' AND purchaseorder_status='pending'";
        $result = mysqli_query($this->connection,$sql);
        if($result){
            return $result;
        }
    }else if($x==7){
        $sql = "SELECT * FROM PO WHERE entryStatus='ok' AND purchaseorder_status='complete'";
        $result = mysqli_query($this->connection,$sql);
        if($result){
            return $result;
         }
    }else if($x==8){
        $sql = "SELECT * FROM PO WHERE entryStatus='ok' AND purchaseorder_status='cancelled'";
        $result = mysqli_query($this->connection,$sql);
        if($result){
            return $result;
        }
    }else if ($x==9){
        $dol_id = "";
        $dol_id = $_SESSION['dol_id'];
         $sql = "SELECT * FROM DO_LINE WHERE order_ref='$dol_id'";
         $result = mysqli_query($this->connection,$sql);
         if($result){
             return $result;
    }
}
}
function AddProduct($file,$SKU, $reorderPoints, $prodName, $location,$price,$DOPrice,$type){

$SKU = $_POST["SKU"];
$reorderPoints = $_POST["reorderPoints"];
$prodName = $_POST["prodName"];
$location = $_POST["location"];
$price = $_POST["price"];
$DOPrice = $_POST["DOPrice"];
$type = $_POST["type"];


$aVar = mysqli_connect("localhost","root","","QUEINV_DB");

$result = mysqli_query($aVar, "SELECT name,product_SKU FROM product WHERE entryStatus='ok' AND name='$prodName' OR product_SKU='$SKU'");

if($result){

}else{
    die(mysqli_error($aVar));
}

$row = mysqli_fetch_array($result);

if($row==0){
        echo "SUCCESS!";
        $sql = "INSERT INTO product (product_SKU,reorder_points,location,name,price,DOPrice,product_type,file)
    VALUES ('$SKU','$reorderPoints','$location','$prodName','$price','$DOPrice','$type','$file');";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        header("location: ProjectLandingPage.php");

}
else{
    echo "Duplication Found / Cannot reuse past or current SKU";
}

}

function deleteProd($delSKU){

        $sql = "UPDATE product SET entryStatus='deleted' WHERE name = '$delSKU'";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

    }

function uploadFile($file){

      if(is_array($file)){ //Checks if file is an array

        if(in_array($file["type"],$this->supported_format)){//checks if file type is supported

          move_uploaded_file($file["tmp_name"], "images/".$file["name"]);
          /*
            move_uploaded_file -> has two parameters ("file name of uploaded file","location of the file(foldername."$file["name"]")")
          */
          echo "File has been uploaded successfully";
        }
        else{

          die("File format is not supported!");

        }

      }
      else{

        die("File is invalid");//uploaded file is not array

      }


    }

//CHANGED THIS
function updatePO(){
  $ref_id = $_POST["id"];
  $supp_id = $_POST["supplier_id"];
  $eta = $_POST["eta"];
  $etd = $_POST["etd"];
  $paymentmethod = $_POST["paymentM"];
  $stats = $_POST["stats"];
  $date = date('Y-m-d H:i:s');
  $date2 = date('Y-m-d');

  if($stats==2||$stats==3){
  $sql = "UPDATE PO SET supplier_id = '$supp_id', eta = '$eta', etd ='$etd',
  paymentmethod = '$paymentmethod', date_fulfilled = '$date', purchaseorder_status = '$stats' WHERE purchaseorder_ref = $ref_id";
  $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

    if($stats==2){

      $name="";
      $qty=0;


      $sql = "SELECT po.`prodName` AS NAME, SUM(po.`qty`) AS TOTAL,SUM(po.`qty`) AS lineqty FROM PO p, PO_LINE po WHERE po.`purchaseorder_ref` = p.`purchaseorder_ref` AND p.`purchaseorder_ref`=$ref_id GROUP BY po.`prodName`";
      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

      while($data = mysqli_fetch_assoc($query)){
        $result[]=$data;
      }

      $x=0;
      while($result["$x"]['NAME']!=NULL){
        $name = $result["$x"]['NAME'];
        $qty = $result["$x"]['TOTAL'];
        $lineqty = $result["$x"]['lineqty'];

        $sql = "INSERT INTO LOGS (log_type, name, qty, date_fulfilled)
                VALUES ('r', '$name', '$lineqty', '$date2')";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

        $sql = "SELECT * FROM Product WHERE name= '$name'";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        $data = mysqli_fetch_assoc($query);
        $qty = $qty + $data['product_qty'];

        $sql = "UPDATE Product SET product_qty = $qty WHERE name= '$name'";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        //
        $x++;
        //
      }
    }

  }else{
  $sql = "UPDATE PO SET supplier_id = '$supp_id', eta = '$eta', etd ='$etd',
  paymentmethod = '$paymentmethod', purchaseorder_status = '$stats' WHERE purchaseorder_ref = $ref_id";
  $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
  }

header("location: ProjectPOPage.php");
}
//CHANGED THIS END


//CHANGED THIS
function addPOL($PO_ref, $quantity, $productSKU){
      $pol_id = 0;
      $pol_id = $_SESSION['pol_id'];
      $quantity = $_POST["quantity"];
      $prodName = $_POST["name"];
      
      $priceGetter = "SELECT * FROM PO WHERE purchaseorder_ref='$pol_id'";
      $result = mysqli_query($this->connection,$priceGetter);
      $priceGetter = mysqli_fetch_assoc($result);

      if($priceGetter['purchaseorder_status']==='cancelled'||$priceGetter['purchaseorder_status']==='pending'){
        echo "<b>PO is seen as cancelled or pending, product quantity won't update</b>";

      $priceGetter = "SELECT * FROM Product WHERE name='$prodName'";
      $result = mysqli_query($this->connection,$priceGetter);
      $priceGetter = mysqli_fetch_assoc($result);

      $result = $priceGetter['price'] * $quantity;

      $sql = "INSERT INTO PO_LINE(purchaseorder_ref, qty, prodName, totalprice)
      VALUES ('$pol_id', '$quantity', '$prodName', '$result')";
      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

      $priceGetter = "SELECT SUM(`totalprice`) AS TOTAL FROM PO_Line WHERE purchaseorder_ref = $pol_id";
      $result = mysqli_query($this->connection,$priceGetter);
      $priceGetter = mysqli_fetch_assoc($result);
      $result = $priceGetter['TOTAL'];

      $sql = "UPDATE PO SET po_totalprice = '$result' WHERE purchaseorder_ref = $pol_id";
      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

      }else{

     if($priceGetter){

      $priceGetter = "SELECT * FROM Product WHERE name='$prodName'";
      $result = mysqli_query($this->connection,$priceGetter);
      $priceGetter = mysqli_fetch_assoc($result);

      $result = $priceGetter['price'] * $quantity;

      $sql = "INSERT INTO PO_LINE(purchaseorder_ref, qty, prodName, totalprice)
      VALUES ('$pol_id', '$quantity', '$prodName', '$result')";
      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

      $priceGetter = "SELECT SUM(`totalprice`) AS TOTAL FROM PO_Line WHERE purchaseorder_ref = $pol_id";
      $result = mysqli_query($this->connection,$priceGetter);
      $priceGetter = mysqli_fetch_assoc($result);
      $result = $priceGetter['TOTAL'];

      $sql = "UPDATE PO SET po_totalprice = '$result' WHERE purchaseorder_ref = $pol_id";
      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

      $priceGetter = "SELECT * FROM Product WHERE name='$prodName'";
      $result = mysqli_query($this->connection,$priceGetter);
      $priceGetter = mysqli_fetch_assoc($result);
      $result = $priceGetter['product_qty'] + $quantity;

      $sql = "UPDATE Product SET product_qty = '$result' WHERE name = '$prodName'";
      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
    }else{

    }
  }
}
//CHANGED THIS END


//CHANGED THIS
function updatePOLine(){
  $pol_id = 0;
  $pol_id = $_POST["id"];
  $prodName = $_POST["name"];
  $quantity = $_POST["quantity"];

      $priceGetter = "SELECT * FROM PO_LINE WHERE POline_id='$pol_id'";
      $result = mysqli_query($this->connection,$priceGetter);
      $priceGetter = mysqli_fetch_assoc($result);
      $updateQTY = $priceGetter['qty'];

      $priceGetter = "SELECT * FROM Product WHERE name='$prodName'";
      $result = mysqli_query($this->connection,$priceGetter);
      $priceGetter = mysqli_fetch_assoc($result);

      if($priceGetter){

      $result = $priceGetter['price'] * $quantity;

      $sql = "UPDATE PO_LINE SET prodName='$prodName', qty = '$quantity', totalprice = '$result' WHERE POline_id = $pol_id";

      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

      $pol_id = $_SESSION['pol_id'];

      $priceGetter = "SELECT SUM(totalprice) AS TOTAL FROM PO_Line WHERE purchaseorder_ref = $pol_id";
      $result = mysqli_query($this->connection,$priceGetter);
      $priceGetter = mysqli_fetch_assoc($result);
      $result = $priceGetter['TOTAL'];

      $sql = "UPDATE PO SET po_totalprice = '$result' WHERE purchaseorder_ref = $pol_id";
      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
      header("location: POLine.php");
    }else{

    }

}
//CHANGED THIS END

//CHANGED THIS
 function addPurchaseOrder($supp_id, $eta, $etd, $paymentmethod){
      $supp_id = $_POST["supplier_id"];
      $eta = $_POST["eta"];
      $etd = $_POST["etd"];
      $paymentmethod = $_POST["paymentM"];
      $temp_id = $_SESSION['idget'];
      $date = date('Y-m-d H:i:s');

      $sql = "INSERT INTO PO (emp_id, supplier_id, eta, etd, paymentmethod, date_fulfilled, purchaseorder_status)
      VALUES ('$temp_id', '$supp_id', '$eta', '$etd', '$paymentmethod', '$date', 'pending')";

      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
}
//CHANGED THIS END


function addDO($cus_id, $stats){
    $cus_id = $_POST["cus_id"];
    $stats = $_POST["stats"];
    $temp_id = $_SESSION['idget'];
    $comment = $_POST["comment"];
    $date = date('Y-m-d H:i:s');
    if($cus_id==0&&$stats==1){
      ECHO "<br>CANNOT USE STUB";
    }else{
    if($stats==1){
    $sql = "INSERT INTO DO (emp_id, customer_id, order_status, comment)
    VALUES ('$temp_id', '$cus_id', 'not yet delivered', '$comment')";
    $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
    $sql = "UPDATE CustomerDetails SET last_transacted='$date' WHERE customer_id = $cus_id";
    }else{
    $sql = "INSERT INTO DO (emp_id, customer_id, order_status, comment) VALUES ('$temp_id', '$cus_id', 'for exit', '$comment')";
    }

    $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
  }
}

function addDOL($PO_ref, $quantity, $prodName){
        $dol_id = 0;
        $dol_id = $_SESSION['dol_id'];
        $quantity = $_POST["quantity"];
        $prodName = $_POST["name"];
        $result2 = 0;

        $priceGetter = "SELECT * FROM Product WHERE name='$prodName'";
        $result = mysqli_query($this->connection,$priceGetter);
        $priceGetter = mysqli_fetch_assoc($result);
        $result = $priceGetter['product_qty'];

        $priceGetter="SELECT SUM(dol.`qty`) AS TOTAL FROM DO d, DO_LINE dol WHERE dol.`order_ref` = d.`order_ref` AND dol.`prodName`='$prodName' AND d.`entryStatus`='ok' AND (d.`order_status`='not yet delivered' OR d.`order_status`='for exit')";
        $result2 = mysqli_query($this->connection,$priceGetter);

        if($result2){
          $priceGetter = mysqli_fetch_assoc($result2);
          $result2 = $priceGetter['TOTAL'] + $quantity;
        }else{
          $result2=$quantity;
        }


        if($result>=$result2){

        $result = "SELECT * FROM Product WHERE name='$prodName'";
        $priceGetter = mysqli_query($this->connection,$result);
        $result = mysqli_fetch_assoc($priceGetter);
        $priceGetter = $result['DOPrice'] * $result2;

        $sql = "INSERT INTO DO_LINE(order_ref, qty, totalprice, prodName)
        VALUES ('$dol_id', '$quantity', '$priceGetter', '$prodName')";
        $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

        //$priceGetter = "SELECT SUM(`totalprice`) AS TOTAL FROM DO_Line WHERE order_ref = $dol_id";
        //$result = mysqli_query($this->connection,$priceGetter);
        //$priceGetter = mysqli_fetch_assoc($result);
        //$result = $priceGetter['TOTAL'];



        //$priceGetter = "SELECT * FROM Product WHERE name='$prodName'";
        //$result = mysqli_query($this->connection,$priceGetter);
        //$priceGetter = mysqli_fetch_assoc($result);
        //$sold= $priceGetter['sold_qty']+$quantity;
        //$result = $priceGetter['product_qty'] - $quantity;
        //$sql = "UPDATE Product SET product_qty = '$result',sold_qty = '$sold' WHERE name = '$prodName'";
        //$query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
    }else{
        echo "<b>Insufficient Stocks in Inventory</b>";
    }

}

function updateDOL(){
    $id = $_POST['id'];
    $status = $_POST['stats'];
    $cus_id = $_POST['cus_id'];
    $comment = $_POST['comment'];
    $date = date('Y-m-d H:i:s');
    $date2 = date('Y-m-d');

    if($status==1||$status==3){
    $sql = "UPDATE DO SET customer_id='$cus_id', date_fulfilled='0000-00-00', comment='$comment' WHERE order_ref=$id";
    $result = mysqli_query($this->connection,$sql);
    }else{
      if($status==2){
        $sql = "UPDATE DO SET customer_id='$cus_id', order_status='sold', date_fulfilled='$date', comment='$comment' WHERE order_ref=$id";
        $result = mysqli_query($this->connection,$sql);
      }else if($status==4){
        $sql = "UPDATE DO SET customer_id='$cus_id', order_status='exited', date_fulfilled='$date', comment='$comment' WHERE order_ref=$id";
        $result = mysqli_query($this->connection,$sql);
      }
       $sql = "SELECT do.`prodName` AS NAME, SUM(do.`qty`) AS TOTAL, SUM(do.`qty`) AS lineqty FROM DO d, DO_LINE do WHERE do.`order_ref` = d.`order_ref` AND d.`order_ref`='$id' GROUP BY do.`prodName`";
      $query = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

      while($data = mysqli_fetch_assoc($query)){
        $name = $data['NAME'];
        $qty = $data['TOTAL'];
        $lineqty = $data['lineqty'];

        $sql = "SELECT * FROM Product WHERE name= '$name'";
        $result = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        $result2 = mysqli_fetch_assoc($result);
        $qty = $result2['product_qty'] - $qty;

        $sql = "UPDATE Product SET product_qty = $qty WHERE name= '$name'";
        $result = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

        if($status==2){
        $qty = $data['TOTAL'];
        $qty = $result2['sold_qty'] + $qty;
        $sql = "UPDATE Product SET sold_qty = $qty WHERE name= '$name'";
        $result = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        //
        $lineqty= 0 - $lineqty;
        $sql = "INSERT INTO LOGS (log_type, name, qty, date_fulfilled)
                VALUES ('s', '$name', '$lineqty', '$date2')";
        $result = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        //
        }else{
        $qty = $data['TOTAL'];
        $qty = $result2['waste_qty'] + $qty;
        $sql = "UPDATE Product SET waste_qty = $qty WHERE name= '$name'";
        $result = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        //
        $lineqty= 0 - $lineqty;
        $sql = "INSERT INTO LOGS (log_type, name, qty, date_fulfilled)
                VALUES ('e', '$name', '$lineqty', '$date2')";
        $result = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
        //
        }
      }

      }
    
    }
  function checkProd($prodName){

      $sql = "SELECT name FROM Product where name = '$prodName' ";
      $result = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));

      if(mysqli_num_rows($result) == 0){
        return 1;
      }else {
        return 2;
      }
    }
}

$db = new mysqli("localhost","root","","QUEINV_DB") or die(myqli_error($db));

    if(isset($_GET["delete"])){

    $id = $_GET["delete"];
    $sql = "UPDATE Employees SET entryStatus='deleted' WHERE emp_id = $id";
    $db->query($sql) or die($db->error());
        header("location: ProjectEMPCRUD.php");
}


if(isset($_GET["deleteSupp"])){

    $supplier_id = $_GET["deleteSupp"];
    $sql = "UPDATE SUPPLIER SET entryStatus='deleted' WHERE supplier_id = $supplier_id";
    $db->query($sql) or die($db->error());
        header("location: ProjectSupplierCRUD.php");
}

if(isset($_GET["deleteCust"])){

    $customer_id = $_GET["deleteCust"];
    $sql = "UPDATE CustomerDetails SET entryStatus='deleted' WHERE customer_id = $customer_id";
    $db->query($sql) or die($db->error());
        header("location: ProjectCustomerCRUD.php");
}

//CHANGED THIS END
if(isset($_GET["deleteline"])){
    $delvar1 = 0;
    $delvar2 = 0;
    $pol_id = $_GET["deleteline"];

    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");

    $priceGetter = "SELECT * FROM PO_Line WHERE POline_id = '$pol_id'";
    $result = mysqli_query($aVar,$priceGetter);
    $priceGetter = mysqli_fetch_assoc($result);
    $delvar1 = $priceGetter['totalprice'];
    $prodName = $priceGetter['prodName'];
    $updateQTY = $priceGetter['qty'];

    $pol_id = $_SESSION['pol_id'];

    $priceGetter = "SELECT po_totalprice FROM PO WHERE purchaseorder_ref = '$pol_id'";
    $result = mysqli_query($aVar,$priceGetter);
    $priceGetter = mysqli_fetch_assoc($result);
    $delvar2 = $priceGetter['po_totalprice'];

    $result =  $delvar2 - $delvar1;

    $sql = "UPDATE PO SET po_totalprice = '$result' WHERE purchaseorder_ref = '$pol_id'";
    $query = mysqli_query($aVar,$sql) or die(mysqli_error($aVar));

    $pol_id = $_GET["deleteline"];

    $sql = "DELETE FROM PO_LINE WHERE poline_id = $pol_id";
    $query = mysqli_query($aVar,$sql) or die(mysqli_error($aVar));

    header("location: POLine.php");
}

if(isset($_GET["deleteDOline"])){
    $dol_id = $_GET["deleteDOline"];
    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
    $sql = "DELETE FROM DO_LINE WHERE orderline_id = '$dol_id'";
    $query = mysqli_query($aVar,$sql) or die(mysqli_error($aVar));

    header("location: DOLine.php");
}
//CHANGED THIS END

if(isset($_GET["deletePO"])){
$pol_id = $_GET["deletePO"];
$aVar = mysqli_connect("localhost","root","","QUEINV_DB");
$sql = "UPDATE PO SET entryStatus='deleted' WHERE purchaseorder_ref = '$pol_id'";
$query = mysqli_query($aVar,$sql) or die(mysqli_error($aVar));

header("location: ProjectPOPage.php");
}

if(isset($_GET['updateProd'])){
    $id = $_GET["updateProd"];
 }

if(isset($_GET["deleteDO"])){
    $pol_id = $_GET["deleteDO"];
    $aVar = mysqli_connect("localhost","root","","QUEINV_DB");
    $sql = "UPDATE DO SET entryStatus='deleted' WHERE order_ref = '$pol_id'";
    $query = mysqli_query($aVar,$sql) or die(mysqli_error($aVar));

    header("location: ProjectDOPage.php");
    }
/*

SELECT SUM(qty) AS TOTAL, name FROM `logs` WHERE `date_fulfilled` = CURDATE() GROUP BY name

SELECT SUM(qty) AS TOTAL, name FROM `logs` WHERE month(`date_fulfilled`) = month(CURDATE()) AND year(`date_fulfilled`) <= year(CURDATE()) GROUP BY name

SELECT SUM(qty) AS TOTAL, name FROM `logs` WHERE year(`date_fulfilled`) <= year(CURDATE()) GROUP BY name




SELECT SUM(qty) AS TOTAL, name FROM `logs` WHERE date_fulfilled >= $date AND date_fulfilled <= $date2 GROUP BY name
SELECT SUM(qty) AS TOTAL, name FROM `logs` WHERE `date_fulfilled` = $date2 GROUP BY name

*/
