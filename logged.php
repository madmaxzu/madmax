<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


require_once("dbcontroller.php");
$db_handle = new DBController();
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
						<li><a href="#"><i class="fa fa-poo"></i>Bejelentkezve mint: <?php echo htmlspecialchars($_SESSION["username"]); ?></a></li>
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
								<a href="index.php" class="logo">
									<img src="./img/buszon3.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form action="index.php" method="post">
									<select class="input-select">
										<option value="0">Kategóriák</option>
										<option value="1">Laptopok</option>
										<option value="1">Kiegészítők</option>
									</select>
									<input type="text" name="valueToSearch" class="input" placeholder="Mit keresel?">
									<button class="search-btn" name="search" value="Filter">Keresés</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">

								<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	

<?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["product_price"];
		?>
						<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["product_price"]*$item["quantity"]);
		}
		?>
								<!-- Cart -->
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Kosaram</span>
										<div class="qty"><?php echo $total_quantity; ?></div>
									</a>
									<div class="cart-dropdown">
										<div class="cart-list">
											<div class="product-widget">
												<div class="product-img">
													<img src="<?php echo $item["product_image"]; ?>" alt="">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="#"><?php echo $item["product_name"]; ?></a></h3>
													<h4 class="product-price"><span class="qty"><?php echo $item["quantity"]; ?></span><?php echo "$ ".$item["product_price"]; ?></h4>
												</div>
												<a href="index.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a>
											</div>


													<!-- ide2 -->



      

	

</div>

										<div class="cart-summary">
											<small><?php echo $total_quantity; ?> termék a kosárban</small>
											<h5>Fizetendő összeg:<?php echo "$ ".number_format($total_price, 2); ?></h5>
										</div>
										<div class="cart-btns">
											<a href="cart2.php">Kosár megtekintése</a>
											<a href="checkout.php">Fizetés  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								</div>
								<!-- /Cart -->
								<?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
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
						<li><a href="bsales.php">Akciók</a></li>
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

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="./img/shop01.png" alt="">
							</div>
							<div class="shop-body">
								<h3>Laptopok<br>Gyűjteménye</h3>
								<a href="#" class="cta-btn">Megtekintés <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="./img/shop03.png" alt="">
							</div>
							<div class="shop-body">
								<h3>Kiegészítők<br>Gyűjteménye</h3>
								<a href="#" class="cta-btn">Megtekintés <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="./img/shop02.png" alt="">
							</div>
							<div class="shop-body">
								<h3>Kamerák<br>Gyűjteménye</h3>
								<a href="#" class="cta-btn">Megtekintés <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Új termékek</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<li class="active"><a data-toggle="tab" href="#tab1">Laptopok</a></li>
									<li><a data-toggle="tab" href="#tab1">Okostelefonok</a></li>
									<li><a data-toggle="tab" href="#tab1">Kamerák</a></li>
									<li><a data-toggle="tab" href="#tab1">Kiegészítők</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a>


<div id="product-grid">
	<div class="txt-heading">Products</div>
<!--ittvolt-->   <div id="product-grid">
	<div class="txt-heading">Products</div>




					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
                                    <?php
	$product_array = $db_handle->runQuery("SELECT * FROM products2 ORDER BY id ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
                                    <!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="<?php echo $product_array[$key]["product_image"]; ?>" alt="">
												<div class="product-label">
												<span class="new">Új</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category">Kategória</p>
												<h3 class="product-name"><a href="#"><?php echo $product_array[$key]["product_name"]; ?></a></h3>
												<h4 class="product-price"><?php echo "$".$product_array[$key]["product_price"]; ?><del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
                                            <form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                            <div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
											<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárba</button>
        </form>
                                        </div>
										</div>
										<!-- /product -->
                                        <?php
		}
	}
	?>
										<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/razer01.png" alt="">
												<div class="product-label">
													<span class="new">Új</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category">Kategória</p>
												<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
												<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárba</button>
											</div>
										</div>
										<!-- /product -->

										<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/product03.png" alt="">
												<div class="product-label">
													<span class="sale">-30%</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category">Kategória</p>
												<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
												<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárba</button>
											</div>
										</div>
										<!-- /product -->

										<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/product04.png" alt="">
											</div>
											<div class="product-body">
												<p class="product-category">Kategória</p>
												<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
												<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárba</button>
											</div>
										</div>
										<!-- /product -->

										<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/product05.png" alt="">
											</div>
											<div class="product-body">
												<p class="product-category">Kategória</p>
												<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
												<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárba</button>
											</div>
										</div>
										<!-- /product -->
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- HOT DEAL SECTION -->
		<div id="hot-deal" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="hot-deal">
							<ul class="hot-deal-countdown">
								<li>
									<div>
										<h3 id="demo"></h3>
										<span>Days</span>
									</div>
								</li>
								<li>
									<div>
										<h3 id="demo2"></h3>
										<span>Hours</span>
									</div>
								</li>
								<li>
									<div>
										<h3 id="demo3"></h3>
										<span>Mins</span>
									</div>
								</li>
								<li>
									<div>
										<h3 id="demo4"></h3>
										<span>Secs</span>
									</div>
								</li>
							</ul>
							<h2 class="text-uppercase">Heti akciós termékek</h2>
							<p>Új termékek akár 50% leárazással</p>
							<a class="primary-btn cta-btn" href="#">Megtekintés</a>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /HOT DEAL SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Top termékek</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<li class="active"><a data-toggle="tab" href="#tab2">Laptopok</a></li>
									<li><a data-toggle="tab" href="#tab2">Okostelefonok</a></li>
									<li><a data-toggle="tab" href="#tab2">Kamerák</a></li>
									<li><a data-toggle="tab" href="#tab2">Accessories</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab2" class="tab-pane fade in active">
									<div class="products-slick" data-nav="#slick-nav-2">
										<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/product06.png" alt="">
												<div class="product-label">
													<span class="sale">-30%</span>
													<span class="new">Új</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category">Kategória</p>
												<h3 class="product-name"><a href="#">termék megnevezése</a></h3>
												<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárba</button>
											</div>
										</div>
										<!-- /product -->

										<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/product07.png" alt="">
												<div class="product-label">
													<span class="new">NEW</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category">Kategória</p>
												<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
												<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárab</button>
											</div>
										</div>
										<!-- /product -->

										<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/product08.png" alt="">
												<div class="product-label">
													<span class="sale">-30%</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category">Category</p>
												<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
												<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárba</button>
											</div>
										</div>
										<!-- /product -->

										<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/product09.png" alt="">
											</div>
											<div class="product-body">
												<p class="product-category">Kategória</p>
												<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
												<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárba</button>
											</div>
										</div>
										<!-- /product -->

										<!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/predator.jpg" alt="">
											</div>
											<div class="product-body">
												<p class="product-category">Kategória</p>
												<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
												<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Kívánságlista</span></button>
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">Hozzáadás</span></button>
													<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Gyorsnézet</span></button>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Kosárba</button>
											</div>
										</div>
										<!-- /product -->
									</div>
									<div id="slick-nav-2" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- /Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-4 col-xs-6">
						<div class="section-title">
							<h4 class="title">Ajánlott termékek</h4>
							<div class="section-nav">
								<div id="slick-nav-3" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-3">
							<div>
								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product07.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product08.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product09.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- product widget -->
							</div>

							<div>
								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/predator.jpg" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/razer01.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product03.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- product widget -->
							</div>
						</div>
					</div>

					<div class="col-md-4 col-xs-6">
						<div class="section-title">
							<h4 class="title">Termék</h4>
							<div class="section-nav">
								<div id="slick-nav-4" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-4">
							<div>
								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product04.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product05.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product06.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- product widget -->
							</div>

							<div>
								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product07.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product08.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product09.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- product widget -->
							</div>
						</div>
					</div>

					<div class="clearfix visible-sm visible-xs"></div>

					<div class="col-md-4 col-xs-6">
						<div class="section-title">
							<h4 class="title">Termék</h4>
							<div class="section-nav">
								<div id="slick-nav-5" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-5">
							<div>
								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/predator.jpg" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/razer01.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product03.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- product widget -->
							</div>

							<div>
								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product04.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Kategória</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product05.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Category</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- /product widget -->

								<!-- product widget -->
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/product06.png" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Category</p>
										<h3 class="product-name"><a href="#">Termék megnevezése</a></h3>
										<h4 class="product-price">Ft980.00 <del class="product-old-price">Ft990.00</del></h4>
									</div>
								</div>
								<!-- product widget -->
							</div>
						</div>
					</div>

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
								<input class="input" type="email" placeholder="Add meg az email címed" value="<?php echo $semail; ?>">
								<button type="submit" class="newsletter-btn"><i class="fa fa-envelope" value="submit"></i> Feliratkozás</button>
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
<script>
		// Set the date we're counting down to
		var countDownDate = new Date("Apr 12, 2019 15:37:25").getTime();
		
		// Update the count down every 1 second
		var x = setInterval(function() {
		
			// Get todays date and time
			var now = new Date().getTime();
				
			// Find the distance between now and the count down date
			var distance = countDownDate - now;
				
			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
				
			// Output the result in an element with id="demo"
			document.getElementById("demo").innerHTML = days;
				document.getElementById("demo2").innerHTML = hours;

				document.getElementById("demo3").innerHTML = minutes;
						document.getElementById("demo4").innerHTML = seconds;
		
		
				
			// If the count down is over, write some text 
			if (distance < 0) {
				clearInterval(x);
				document.getElementById("demo").innerHTML = "EXPIRED";
			}
		}, 1000);
		</script>