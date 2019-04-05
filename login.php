<?php
// Include config file
require_once "config.php";
//require_once "loginform.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$email = $email_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
	}
	// validate email 

	if(empty(trim($_POST["email"]))){
		$email_err = "Please enter an email.";
	} elseif(strlen(trim($_POST["email"])) < 6){
		$email_err = "Legalabb 6 karakternek kene lennie az emailnek";
	}else{
		$email = trim($_POST["email"]);
	}
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_username, $param_password, $param_email);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: loginform.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html> 
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>madmax pc webshop</title>
		<!-- atw advert header off -->
		<script type="text/javascript">
			if(top.location != location)
			{
			top.location.href = document.location.href ;
			}
		</script>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +36 30 454 2444</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> adamkollar96@gmail.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 5435 Budapest Glen Park</a></li>
					</ul>
					<ul class="header-links pull-right">
					<li><a href="loginform.php"><i class="fa fa-user-secret"></i> Bejelentkezés</a></li>
					<li><a href="login.php"><i class="fa fa-user-o"></i> Regisztráció</a></li>
					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="index.php" class="logo">
									<img src="./img/buszon3.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form>
									<select class="input-select">
										<option value="0">Kategóriák</option>
										<option value="1">Laptopok</option>
										<option value="1">Kiegészítők</option>
									</select>
									<input class="input" placeholder="Mit keresel?">
									<button class="search-btn">Keresés</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
									<a href="#">
										<i class="fa fa-heart-o"></i>
										<span>Kívánságlista</span>
										<div class="qty">999</div>
									</a>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Kosaram</span>
										<div class="qty">999</div>
									</a>
									<div class="cart-dropdown">
										<div class="cart-list">
											<div class="product-widget">
												<div class="product-img">
													<img src="./img/predator.jpg" alt="">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="#">Termék név</a></h3>
													<h4 class="product-price"><span class="qty">1x</span>Ft980.00</h4>
												</div>
												<button class="delete"><i class="fa fa-close"></i></button>
											</div>

											<div class="product-widget">
												<div class="product-img">
													<img src="./img/razer01.png" alt="">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="#">Termék név</a></h3>
													<h4 class="product-price"><span class="qty">3x</span>Ft980.00</h4>
												</div>
												<button class="delete"><i class="fa fa-close"></i></button>
											</div>
										</div>
										<div class="cart-summary">
											<small>999 Termék a kosárban</small>
											<h5>Fizetendő összeg: 9999</h5>
										</div>
										<div class="cart-btns">
											<a href="#">Kosár megtekintése</a>
											<a href="#">Fizetés  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								</div>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->


		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">

				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->

		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header">Saját profil</h3>
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li class="active">Bejelentkezés / Regisztráció</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->
		
		


		
		<!-- SECTION -->
		<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="col-md-7">
							<!-- Billing Details -->
							<div class="billing-details">
								<div class="section-title">
									<h3 class="title">Regisztráció</h3>
								</div>
								<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
										<input class="input" type="text" name="username" placeholder="Felhasználónév" value="<?php echo $username; ?>">
										<span class="help-block"><?php echo $username_err; ?></span>
									</div>
									<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
											<input class="input" type="password" name="password" placeholder="Jelszó" value="<?php echo $password; ?>">
											<span class="help-block"><?php echo $password_err; ?></span>
									</div>
									<div class="form-group <?php (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
											<input class="input" type="password" name="confirm_password" placeholder="Jelszó" value="<?php echo $confirm_password; ?>">
											<span class="help-block"><?php echo $confirm_password_err; ?></span>
									</div>
								<div class="form-group">
									<input class="input" type="text" name="first-name" placeholder="Keresztnév">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="last-name" placeholder="Vezetéknév">
								</div>
								<div class="form-group <?php (!empty($email_err)) ? 'has-error' : ''; ?>">
									<input class="input" type="email" name="email" placeholder="Email" required>
									<span class="help-block"><?php echo $email_err; ?></span>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="address" placeholder="Cím">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="city" placeholder="Város">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="country" placeholder="Ország">
								</div>
								<div class="form-group">
									<input class="input" type="number" name="zip-code" placeholder="IrányÍtószám">
								</div>
								<div class="form-group">
									<input class="input" type="tel" name="tel" placeholder="Telefonszám">
								</div>
								<input type="submit" class="btn primary-btn" value="Regisztráció">
								</form>
							</div>
						</div>
	
						<!-- login Details -->
						<div class="col-md-5 login-details">


						</div>
					</div>
				</div>
			</div>
			-->
		<!-- NEWSLETTER -->
		<div id="newsletter" class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12">
							<div class="newsletter">
								<p>Iratkozz fel hírlevelünkre</p>
								<form>
									<input class="input" type="email" placeholder="Add meg az email címed">
									<button class="newsletter-btn"><i class="fa fa-envelope"></i> Feliratkozás</button>
								</form>
								<ul class="newsletter-follow">
									<li>
										<a href="http://www.facebook.com"><i class="fa fa-facebook"></i></a>
									</li>
									<li>
										<a href="http://www.instagram.com"><i class="fa fa-instagram"></i></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /NEWSLETTER -->

		<!-- FOOTER -->
		<footer id="footer">
				<!-- top footer -->
				<div class="section">
					<!-- container -->
					<div class="container">
						<!-- row -->
						<div class="row">
							<div class="col-md-3 col-xs-6">
								<div class="footer">
									<h3 class="footer-title">Rólunk</h3>
									<p>Fooooter szöveg jön ideeeeeeeeeeee</p>
									<ul class="footer-links">
										<li><a href="#"><i class="fa fa-map-marker"></i>5435 Budapest Glen Park</a></li>
										<li><a href="#"><i class="fa fa-phone"></i>+36 30 254 4453</a></li>
										<li><a href="#"><i class="fa fa-envelope-o"></i>adamkollar96@gmail.com</a></li>
									</ul>
								</div>
							</div>
	
							<div class="col-md-3 col-xs-6">
								<div class="footer">
									<h3 class="footer-title">Kategóriák</h3>
									<ul class="footer-links">
										<li><a href="#">Top ajánlatok</a></li>
										<li><a href="#">Laptopok</a></li>
										<li><a href="#">Okostelefonok</a></li>
										<li><a href="#">Kamerák</a></li>
										<li><a href="#">Kiegészítők</a></li>
									</ul>
								</div>
							</div>
	
							<div class="clearfix visible-xs"></div>
	
							<div class="col-md-3 col-xs-6">
								<div class="footer">
									<h3 class="footer-title">Információk</h3>
									<ul class="footer-links">
										<li><a href="#">Rólunk</a></li>
										<li><a href="#">Kapcsolat</a></li>
										<li><a href="#">Adatvédelmi Információk</a></li>
										<li><a href="#">Rendelések és visszaküldés</a></li>
										<li><a href="#">Valami</a></li>
									</ul>
								</div>
							</div>
	
							<div class="col-md-3 col-xs-6">
								<div class="footer">
									<h3 class="footer-title">Vezérlőpult</h3>
									<ul class="footer-links">
										<li><a href="#">Saját profilom</a></li>
										<li><a href="#">Kosár tartalma</a></li>
										<li><a href="#">Kívánságlista</a></li>
										<li><a href="#">Rendelés követése</a></li>
										<li><a href="#">Segítség</a></li>
									</ul>
								</div>
							</div>
						</div>
						<!-- /row -->
					</div>
					<!-- /container -->
				</div>
				<!-- /top footer -->
	
				<!-- bottom footer -->
				<div id="bottom-footer" class="section">
					<div class="container">
						<!-- row 
						<div class="row">
							<div class="col-md-12 text-center">
								<ul class="footer-payments">
									<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
									<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
									<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								</ul>
	
							</div>
						</div>-->
							<!-- /row -->
					</div>
					<!-- /container -->
				</div>
				<!-- /bottom footer -->
		
			</footer>
			<!-- /FOOTER -->
	
			<!-- jQuery Plugins -->
			<script src="js/jquery.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="js/slick.min.js"></script>
			<script src="js/nouislider.min.js"></script>
			<script src="js/jquery.zoom.min.js"></script>
			<script src="js/main.js"></script>
	
		</body>
	</html>

	<!--       _
       .__(.)< (MEOW)
        \___)   
 ~~~~~~~~~~~~~~~~~~-->