<!doctype html>

<?php include "ProjectDBFile.php"?>
<?php $_SESSION['showdatactr'] = 0; ?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="ProjectCSSFile.css">
    <link rel="stylesheet" type="text/css" href="proj_css.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
 

<div class="container-fluid my-4" >
  <div class="row">
    <div class="col-7 d-flex align-items-center justify-content-center">
      <h1 class="font-weight-bold display-1">QUE </h1><br><br>
      <h4>INVENTORY SYSTEMS</h4>
    </div>
      <div class="col-4 m-4">
    <div class="w-100 top_login" >
      <div class="card">
        <div class="card-header bg-dark text-light">
          <h4 >Login</h4>
        </div>
        <div class="card-body">
        <form method = "post" action = "">
          <label for="Username" style="font-weight: bold">Username</label>
            <input type="text" value="username" name="username" class="form-control logon-texts" required>
            <br>
          <label for="Password" style="font-weight: bold">Password</label>
          <input type="password" value="password" name="password" class="form-control logon-texts" required>
            <br>
          <button type="submit" name="login" class="btn btn-outline-secondary float-right w-25 login-button">LOGIN</button>
        </form>
      </div>
      </div>
    </div>
</div>
    <?php 
        $mydb = new db();
        if(isset($_POST["login"])){
       $mydb->login_form($uname, $password);
      }
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>