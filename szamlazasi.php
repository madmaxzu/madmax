<?php 
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Include config file
require_once "config.php";
//require_once "loginform.php";
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}*/
// Define variables and initialize with empty values
$keresztnev = $vezeteknev = $cim = $varos = $orszag = $irsz = $telefon = "";
$keresztnev_err = $vezeteknev_err = $cim_err = $varos_err = $orszag_err = $irsz_err = $telefon_err = "";
 
/*$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$email = $email_err = "";*/

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
   // sdfd // Validate username
    if(empty(trim($_POST["keresztnev"]))){
        $keresztnev_err = "Please enter a username.";
    } else{
        // Prepare a select statement
       // $sql = "SELECT id FROM users WHERE keresztnev = ?";
     //  $sql = " UPDATE users SET (vezeteknev = '$vezeteknev', keresztnev = '$keresztnev', cim ='$cim', varos = '$varos', orszag = '$orszag', irsz = '$irsz', telefon ='$telefon' WHERE id = 15);";
      $sql = "UPDATE users SET vezeteknev = ?, keresztnev = ?, cim = ?, varos = ?, orszag = ?, irsz = ?, telefon = ? WHERE id = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
         
            $param_vezeteknev = trim($_POST["vezeteknev"]);
            $param_keresztnev = trim($_POST["keresztnev"]);
            $param_cim = trim($_POST["cim"]);
            $param_varos = trim($_POST["varos"]);
            $param_orszag = trim($_POST["orszag"]);
            $param_irsz = trim($_POST["irsz"]);
            $param_telefon = trim($_POST["telefon"]);
            $param_id = $_SESSION["id"];

            $stmt->bind_param("sssssisi",$param_vezeteknev, $param_keresztnev, $param_cim, $param_varos, $param_orszag, $param_irsz, $param_telefon,$param_id);
            

            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $keresztnev_err = "This username is already taken.";
                } else{
                    $keresztnev = trim($_POST["keresztnev"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
      //  $stmt->close();
    }
    
    // Validate password

    
    // Validate confirm password

	// validate email 


    
    	// validate keresztnev

	if(empty(trim($_POST["keresztnev"]))){
		$keresztnev_err = "Please enter an keresztnev.";
	} elseif(strlen(trim($_POST["keresztnev"])) < 6){
		$keresztnev_err = "Legalabb 6 karakternek kene lennie a keresztnevnek";
	}else{
		$keresztnev = trim($_POST["keresztnev"]);
    }
    
        	// validate vezeteknev

	if(empty(trim($_POST["vezeteknev"]))){
		$vezeteknev_err = "Please enter an vezeteknev.";
	} elseif(strlen(trim($_POST["vezeteknev"])) < 6){
		$vezeteknev_err = "Legalabb 6 karakternek kene lennie a vezeteknev";
	}else{
		$vezeteknev = trim($_POST["vezeteknev"]);
    }
            	// validate cim

	if(empty(trim($_POST["cim"]))){
		$cim_err = "Please enter an cim.";
	} elseif(strlen(trim($_POST["cim"])) < 6){
		$cim_err = "Legalabb 6 karakternek kene lennie a cim";
	}else{
		$cim = trim($_POST["cim"]);
    }
    
                	// validate varos

	if(empty(trim($_POST["varos"]))){
		$varos_err = "Please enter an varos.";
	} elseif(strlen(trim($_POST["varos"])) < 6){
		$varos_err = "Legalabb 6 karakternek kene lennie a varos";
	}else{
		$varos = trim($_POST["varos"]);
    }
    
                    	// validate orszag

	if(empty(trim($_POST["orszag"]))){
		$orszag_err = "Please enter an orszag.";
	} elseif(strlen(trim($_POST["orszag"])) < 6){
		$orszag_err = "Legalabb 6 karakternek kene lennie a orszag";
	}else{
		$orszag = trim($_POST["orszag"]);
    }
                        	// validate irsz

	if(empty(trim($_POST["irsz"]))){
		$irsz_err = "Please enter an irsz.";
	} elseif(strlen(trim($_POST["irsz"])) > 4){
		$irsz_err = "Legalabb 4 karakternek kene lennie a irsz";
	}else{
		$irsz = trim($_POST["irsz"]);
    }
    
                            	// validate telefon

	if(empty(trim($_POST["telefon"]))){
		$telefon_err = "Please enter an irsz.";
	} elseif(strlen(trim($_POST["telefon"])) < 6){
		$telefon_err = "Legalabb 6 karakternek kell lennie";
	}else{
		$telefon = trim($_POST["telefon"]);
    }
    // Check input errors before inserting in database
    if(empty($vezeteknev_err) && empty($keresztnev_err) && empty($cim_err) && empty($varos_err) && empty($orszag_err) && empty($irsz_err) && empty($telefon_err)){
        
        // Prepare an insert statement
      // $sql = "UPDATE users (vezeteknev, keresztnev, cim, varos, orszag, irsz, telefon) VALUES (?, ?, ?, ?, ?, ?, ?)";ű
      //  $sql = "UPDATE users SET vezeteknev, keresztnev, cim, varos, orszag, irsz, telefon = (?, ?, ?, ?, ?, ?, ?) WHERE id = ?";
       // $sql = "UPDATE users SET password = ? WHERE id = ?";
     //  $sql = " INSERT INTO users (vezeteknev, keresztnev, cim, varos, orszag, irsz, telefon) VALUES ($vezeteknev, $keresztnev, $cim, $varos, $orszag, $irsz, $telefon)";

      //  if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
       // $stmt->bind_param("sssssisi", $param_id, $param_vezeteknev, $param_keresztnev, $param_cim, $param_varos, $param_orszag, $param_irsz, $param_telefon);
            // Set parameters
           // $param_username = $username;
          //  $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
           //  $param_id = $_SESSION["id"];
           // $param_vezeteknev = $vezeteknev;
           // $param_keresztnev = $keresztnev;
           // $param_cim = $cim;
           // $param_varos = $varos;
           // $param_orszag = $orszag;
//$param_irsz = $irsz;
//$param_telefon = $telefon;
            // Attempt to execute the prepared statement
          /*  if($stmt->execute()){
                // Redirect to login page
                header("location: loginform.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }*/
       // }
         
        // Close statement
      //  $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
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
        <li><a href="termekfelvetel.php">Termékek</a></li>
        <li class="active"><a href="szamlazasi.php">Számlázási adatok</a></li>
        <li><a href="logged.php">Vissza az oldalra</a></li>
        <li><a href="logout.php">Kijelentkezés</a></li>  
    </ul><br>

    </div>

    <div class="col-sm-3">
    <h2>Szállítási adatok</h2>
      <p>Itt megadhatod a szállítási adataid.</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
          <div class="form-group <?php echo (!empty($vezeteknev_err)) ? 'has-error' : ''; ?>">
              <label>Vezetéknév</label>
              <input type="text" name="vezeteknev" class="form-control" value="<?php echo $vezeteknev; ?>"required>
              <span class="help-block"><?php echo $vezeteknev_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($keresztnev_err)) ? 'has-error' : ''; ?>">
              <label>Keresztnév</label>
              <input type="text" name="keresztnev" class="form-control" value="<?php echo $keresztnev; ?>"required>
              <span class="help-block"><?php echo $vezeteknev_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($cim_err)) ? 'has-error' : ''; ?>">
              <label>Cím</label>
              <input type="text" name="cim" class="form-control" value="<?php echo $cim; ?>" required>
              <span class="help-block"><?php echo $cim_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($varos_err)) ? 'has-error' : ''; ?>">
              <label>Város</label>
              <input type="text" name="varos" class="form-control" value="<?php echo $varos; ?>" required>
              <span class="help-block"><?php echo $varos_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($orszag_err)) ? 'has-error' : ''; ?>">
              <label>Ország</label>
              <input type="text" name="orszag" class="form-control" value="<?php echo $orszag; ?>" required>
              <span class="help-block"><?php echo $orszag_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($irsz_err)) ? 'has-error' : ''; ?>" >
              <label>Irányítószám</label>
              <input type="text" name="irsz" class="form-control" value="<?php echo $irsz; ?>"required>
              <span class="help-block"><?php echo $irsz_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($telefon_err)) ? 'has-error' : ''; ?>">
              <label>Telefonszám</label>
              <input type="text" name="telefon" class="form-control" value="<?php echo $telefon; ?>" required>
              <span class="help-block"><?php echo $telefon_err; ?></span>
          </div>

          <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Submit">
              <a class="btn btn-link" href="szamlazasi.php">Cancel</a>
          </div>
      </form>
  </div>    
  <?php 
print_r($_POST);
?>

  </div>
</div>

<footer class="container-fluid">
  <p>Footer Text</p>
</footer>

</body>
</html>



