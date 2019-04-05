<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
//require_once "config.php";
include "connectionka.php";
include "configka.php";

$link = mysqli_connect("localhost","root","");
mysqli_select_db($link,"madmax");
 

?>

<?php

?>

                                        <!-- INNEN KEZDŐDNEK AZ ÉLET NAGY DOLGAI  --> 
                                        <!DOCTYPE html>
<html lang="en">
<head>
  <title>madmax pc webshop</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>

</head>
<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>Hello <?php echo htmlspecialchars($_SESSION["username"]);?></h4>
      <ul class="nav nav-pills nav-stacked">
      <li><a href="reset-password.php">Jelszó megváltoztatása</a></li>
        <li><a href="view.php">Regisztrált felhasználók</a></li>
        <li class="active"><a href="termekfelvetel.php">Termékek</a></li>
        <li><a href="szamlazasi.php">Számlázási adatok</a></li>
        <li><a href="logged.php">Vissza az oldalra</a></li>
        <li><a href="logout.php">Kijelentkezés</a></li>  
      </ul><br>

    </div>



    <div class="col-sm-9">
   
// termék hozzáadása
<script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
        <style type="text/css">


            .form-container {
                margin-left: 80px;
            }

            .form-container .messages {
                margin-bottom: 15px;
            }

            .form-container input[type="text"],
            .form-container input[type="number"] {
                display: block;
                margin-bottom: 15px;
                width: 150px;
            }

            .form-container input[type="file"] {
                margin-bottom: 15px;
            }

            .form-container label {
                display: inline-block;
                float: left;
                width: 100px;
            }

            .form-container button {
                display: block;
                padding: 5px 10px;
                background-color: rgb(34, 0, 226);
                
                color: #blue;
                border: none;
            }

            .form-container .link-to-product-details {
                margin-top: 20px;
                display: inline-block;
            }
        </style>

    </head>
    <body>

        <div class="form-container">
            <h2>Termék felvétel</h2>

            <div class="messages">

            </div>

            <div class="grid_10">
                <div class="box round first">
                    <div class="block">

                    <form name="form1" action="" method="post" enctype="multipart/form-data">
                        <table border="1">
                            <tr>
                                <td>Termék név</td>
                                <td><input type="text" name="pnm"></td>
            </tr>
            <tr>
                                <td>Termék ár</td>
                                <td><input type="text" name="pprice"></td>
            </tr>
            <tr>
                                <td>Termék mennyiség</td>
                                <td><input type="text" name="pqty"></td>
            </tr>
            <tr>
                                <td>Termék kép</td>
                                <td><input type="file" name="pimage"></td>
            </tr>
            <tr>
                                <td>Termék cikkszám</td>
                                <td><input type="text" name="code"></td>
            </tr>
            <tr>
                                <td>Termék leírás</td>
                                <td><select name="pcategory">
                                    <option value="laptopok">Laptopok</option>
                                <option value="kiegeszitok">Kiegészítők</option>
            </select> </td>
                                <td colspan="2" align="center"><input type="submit" name="submit1" value="upload"></td>
                            </tr>

                            <tr>
                                <td>Product category</td>
                                <td><textarea cols="15" rows="10" name="pdesc"></textarea> </td>
                                <?php 
                                $sql = " SELECT * FROM products2 ";
$result = mysqli_query($mysqli_select_db, $sql) or die ("Bad query: $sql");

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_array($result)){
        echo"<a href='details.php?id={$row['id']}'>{$row['product_name']}</a><br>\n";
    }

}else{
    echo"<h2>nothing to display</h2>";
}

?>
                            </tr>
            </table>
            </form>

<?php 
if(isset($_POST["submit1"]))
{
    $v1=rand(1111,9999);
    $v2=rand(1111,9999);

    $v3=$v1.$v2;
    $v3=md5($v3);
$fnm=$_FILES["pimage"]["name"];
$dst="product_image/".$v3.$fnm;
$dst1="product_image/".$v3.$fnm;

move_uploaded_file($_FILES["pimage"]["tmp_name"],$dst);

mysqli_query($link,"insert into products2 values('','$_POST[pnm]',$_POST[pprice],$_POST[pqty],'$dst1','$_POST[pcategory]','$_POST[pdesc]','$_POST[code]')");

}
?>


        </div>

  </div>    

 
  </div>
</div>



</body>
</html>



<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
 
</body>
</html>-->

