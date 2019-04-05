<?php
//include_once 'config.php';
require("dbcontroller.php");
$db_handle = new DBController();
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: loginform.php");
    exit;
}

$id = $_SESSION["id"];
//print_r($_SESSION);
//ittvolt

$connect = mysqli_connect("localhost", "root", "", "madmax");

$query = "SELECT `vezeteknev`, `keresztnev`, `cim`, `varos`, `orszag`,`irsz`, `telefon` FROM `users` WHERE `id` = $id LIMIT 1";

$result = mysqli_query($connect, $query);


if(mysqli_num_rows($result) > 0)
{
	while ($row = mysqli_fetch_array($result))
	{
		//print_r($row);
		$lname = $row['vezeteknev'];
		$fname = $row['keresztnev'];
		$cim = $row['cim'];
		$varos = $row['varos'];
		$orszag = $row['orszag'];
		$irsz = $row['irsz'];
		$telefon = $row['telefon'];
	}  
}

// if the id not exist
// show a message and clear inputs
else {
		echo "Undifined ID";
				$lname = "";
				$fname = "";
				$cim = "";
				$varos = "";
				$orszag = "";
				$irsz = "";
				$telefon = "";
}


mysqli_free_result($result);
mysqli_close($connect);


if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        case "add":
            if(!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM products2 WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"]=>array('product_name'=>$productByCode[0]["product_name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'product_price'=>$productByCode[0]["product_price"], 'product_image'=>$productByCode[0]["product_image"]));
                
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                                if($productByCode[0]["code"] == $k) {
                                    if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
        break;
        case "remove":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["code"] == $k)
                            unset($_SESSION["cart_item"][$k]);				
                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
            }
        break;
        case "empty":
            unset($_SESSION["cart_item"]);
        break;	
    }
    }
    ?>

<?php
if(isset($_SESSION["cart_item"])) {
    $total_quantity = 0;
    $total_price = 0;	
    foreach ($_SESSION["cart_item"] as $item) {
        $item_price = $item["quantity"]*$item["product_price"];
		$total_quantity += $item["quantity"];
		$total_price += ($item["product_price"]*$item["quantity"]);
	}
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}

	$product_array = $db_handle->runQuery("SELECT * FROM products2 ORDER BY id ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
			//itt nincs semmi
		}
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
						<li><a href="#"><i class="fa fa-poo"></i>Bejelentkezve mint: <?php echo htmlspecialchars($_SESSION["id"]); ?></a></li>
					</ul>
					<ul class="header-links pull-right">
						<li><a href="reset-password.php"><i class="fa fa-edit"></i> Jelszó megváltoztatása</a></li>
						<li><a href="logout.php"><i class="fa fa-power-off"></i> Kijelentkezés</a></li>
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
								<a href="logged.php" class="logo">
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
											<a href="cart.php">Kosár megtekintése</a>
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
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li class="active"><a href="index.php">Kezdőlap</a></li>
						<li><a href="sales.php">Akciók</a></li>
						<li><a href="categories.php">Kategóriák</a></li>
						<li><a href="laptops.php">Laptopok</a></li>
						<li><a href="smartphones.php">Okostelefonok</a></li>
						<li><a href="cameras.php">Kamerák</a></li>
						<li><a href="store.php">Accessories</a></li>
					</ul>
					<!-- /NAV -->
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
						<h3 class="breadcrumb-header">Checkout</h3>
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li class="active">Checkout</li>
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

					<div class="col-md-7">
						<!-- Billing Details -->
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Szállítási adataid</h3>
							</div>
							<div class="form-group">
							</div>
							<div class="form-group">
								<a>Vezetéknév</a><br>
								<a><?php echo $lname; ?></a>
							</div>
							<div class="form-group">
							<a>Keresztnév</a><br>
								<a><?php echo $fname; ?></a>							</div>
							<div class="form-group">
							<a>Cím</a><br>
								<a><?php echo $cim; ?></a>							</div>
							<div class="form-group">
							<a>Város</a><br>
								<a><?php echo $varos; ?></a>							</div>
							<div class="form-group">
							<a>Ország</a><br>
								<a><?php echo $orszag; ?></a>							</div>
							<div class="form-group">
							<a>Irányítószám</a><br>
								<a><?php echo $irsz; ?></a>							</div>
							<div class="form-group">
							<a>Telefonszám</a><br>
								<a><?php echo $telefon; ?></a>							</div>
							<div class="form-group">
								<div class="input-checkbox">


								</div>
							</div>
						</div>
						<!-- /Billing Details -->

						<!-- Shiping Details -->
						<div class="shiping-details">

							<div class="input-checkbox">
								<input type="checkbox" id="shiping-address">


							</div>
						</div>
						<!-- /Shiping Details -->

						<!-- Order notes -->
						<div class="order-notes">
						<a href="szamlazasi.php" class="primary-btn order-submit">Módosítás</a>
						</div>
						<!-- /Order notes -->
					</div>

					<!-- Order Details -->
					<div class="col-md-5 order-details">
						<div class="section-title text-center">
							<h3 class="title">A rendelésed</h3>
						</div>
						<div class="order-summary">
							<div class="order-col">
								<div><strong>PRODUCT</strong></div>
								<div><strong>Fizetendő</strong></div>
                            </div>
                            
                            		
<?php	
// print_r($item);	
foreach ($_SESSION["cart_item"] as $item){
    $item_price = $item["quantity"]*$item["product_price"];
    ?>


							<div class="order-products">
								<div class="order-col">
									<div><?php echo $item["quantity"]; ?>x <?php echo $item["product_name"]; ?></div>
									<div><?php echo "$ ".$item["product_price"]; ?></div>
                                </div>
<?php } ?>
								<div class="order-col">
									<div>2x Product Name Goes Here</div>
									<div>$980.00</div>
								</div>
							</div>
							<div class="order-col">
								<div>Shiping</div>
								<div><strong>FREE</strong></div>
							</div>
							<div class="order-col">
								<div><strong>Fizetendő összeg</strong></div>
								<div><strong class="order-total"><?php echo "$ ".number_format($total_price, 2); ?></strong></div>
							</div>
						</div>
						<div class="payment-method">
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-1">
								<label for="payment-1">
									<span></span>
									Banki átutalás
								</label>
								<div class="caption">
									<p>Banki átutalással a cég számlaszámára tudja átutalni a fizetendő összeget.</p>
								</div>
							</div>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-2">
								<label for="payment-2">
									<span></span>
									Csekkel való fizetés
								</label>
								<div class="caption">
									<p>Csekkel való fizetés esetén blablabla</p>
								</div>
							</div>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-3">
								<label for="payment-3">
									<span></span>
									PayPal
								</label>
								<div class="caption">
									<p>Fizetés PayPay accountal</p>
								</div>
							</div>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="terms">
							<label for="terms">
								<span></span>
								Elolvastam, és elfogadtam a <a href="#">felhasználói és vásárlási feltételeket.</a>
							</label>
						</div>
						<a href="#" onclick="myFunction()" class="primary-btn order-submit">Rendelés leadása</a>
					</div>
					<!-- /Order Details -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
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
<script>


<script>
function myFunction() {
  confirm("Biztosan szeretnéd leadni a rendelést?");
}
</script>
	</script>
	</body>
</html>
