<?php
session_start();
include 'configka.php';
include 'connectionka.php';
include 'config.php';


if (!isset($_POST['id']) || empty($_POST['id']) || !is_numeric($_POST['id'])) {
    $errors[] = 'You must select a product in order to see its details!';
} else {
	$productId = $_POST['id'];
	


    /*
     * Get the product details.
     */
    $sql = 'SELECT * 
            FROM products 
            WHERE id = ? 
            LIMIT 1';

    $statement = $connection->prepare($sql);

    $statement->bind_param('i', $productId);

    $statement->execute();


    $result = $statement->get_result();

    $products = $result->fetch_all(MYSQLI_ASSOC);


    $result->close();

    $statement->close();

    if (!$products) {
        $errors[] = 'No product found.';
    } else {
        $product = $products[0];

        $productName = $product['name'];
        $productQuantity = $product['quantity'];
        $productDescription = $product['description'];
        $productPrice = $product['price'];

        $sql = 'SELECT * 
                FROM products_images 
                WHERE product_id = ?';

        $statement = $connection->prepare($sql);

        $statement->bind_param('i', $productId);

        $statement->execute();

        $result = $statement->get_result();  

        $images = $result->fetch_all(MYSQLI_ASSOC);

        $result->close();

        $statement->close();

        $connection->close();
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
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li><a href="index.php">Kezdőlap</a></li>
						<li><a href="sales.php">Akciók</a></li>
						<li><a href="categories.php">Kategóriák</a></li>
						<li><a href="laptops.php">Laptopok</a></li>
						<li><a href="smartphones.php">Okostelefonok</a></li>
						<li><a href="cameras.php">Kamerák</a></li>
						<li class="active"><a href="store.php">Accessories</a></li>
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
						<ul class="breadcrumb-tree">
							<li><a href="#">Kezdőlap</a></li>
							<li><a href="#">Kategóriák</a></li>
							<li><a href="#">Kiegészítők</a></li>
							<li class="active"><?php echo "Fejhallgatók"?></li>
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
					<!-- ASIDE -->
					<div id="aside" class="col-md-3">
						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Categories</h3>
							<div class="checkbox-filter">

								<div class="input-checkbox">
									<input type="checkbox" id="category-1">
									<label for="category-1">
										<span></span>
										Laptops
										<small>(120)</small>
									</label>
								</div>

								<div class="input-checkbox">
									<input type="checkbox" id="category-2">
									<label for="category-2">
										<span></span>
										Smartphones
										<small>(740)</small>
									</label>
								</div>

								<div class="input-checkbox">
									<input type="checkbox" id="category-3">
									<label for="category-3">
										<span></span>
										Cameras
										<small>(1450)</small>
									</label>
								</div>

								<div class="input-checkbox">
									<input type="checkbox" id="category-4">
									<label for="category-4">
										<span></span>
										Accessories
										<small>(578)</small>
									</label>
								</div>

								<div class="input-checkbox">
									<input type="checkbox" id="category-5">
									<label for="category-5">
										<span></span>
										Laptops
										<small>(120)</small>
									</label>
								</div>

								<div class="input-checkbox">
									<input type="checkbox" id="category-6">
									<label for="category-6">
										<span></span>
										Smartphones
										<small>(740)</small>
									</label>
								</div>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Price</h3>
							<div class="price-filter">
								<div id="price-slider"></div>
								<div class="input-number price-min">
									<input id="price-min" type="number">
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
								<span>-</span>
								<div class="input-number price-max">
									<input id="price-max" type="number">
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Brand</h3>
							<div class="checkbox-filter">
								<div class="input-checkbox">
									<input type="checkbox" id="brand-1">
									<label for="brand-1">
										<span></span>
										SAMSUNG
										<small>(578)</small>
									</label>
								</div>
								<div class="input-checkbox">
									<input type="checkbox" id="brand-2">
									<label for="brand-2">
										<span></span>
										LG
										<small>(125)</small>
									</label>
								</div>
								<div class="input-checkbox">
									<input type="checkbox" id="brand-3">
									<label for="brand-3">
										<span></span>
										SONY
										<small>(755)</small>
									</label>
								</div>
								<div class="input-checkbox">
									<input type="checkbox" id="brand-4">
									<label for="brand-4">
										<span></span>
										SAMSUNG
										<small>(578)</small>
									</label>
								</div>
								<div class="input-checkbox">
									<input type="checkbox" id="brand-5">
									<label for="brand-5">
										<span></span>
										LG
										<small>(125)</small>
									</label>
								</div>
								<div class="input-checkbox">
									<input type="checkbox" id="brand-6">
									<label for="brand-6">
										<span></span>
										SONY
										<small>(755)</small>
									</label>
								</div>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Top selling</h3>
							<div class="product-widget">
								<div class="product-img">
									<img src="./img/product01.png" alt="">
								</div>
								<div class="product-body">
									<p class="product-category">Category</p>
									<h3 class="product-name"><a href="#">product name goes here</a></h3>
									<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
								</div>
							</div>

							<div class="product-widget">
								<div class="product-img">
									<img src="./img/product02.png" alt="">
								</div>
								<div class="product-body">
									<p class="product-category">Category</p>
									<h3 class="product-name"><a href="#">product name goes here</a></h3>
									<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
								</div>
							</div>

							<div class="product-widget">
								<div class="product-img">
									<img src="./img/product03.png" alt="">
								</div>
								<div class="product-body">
									<p class="product-category">Category</p>
									<h3 class="product-name"><a href="#">product name goes here</a></h3>
									<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
								</div>
							</div>
						</div>
						<!-- /aside Widget -->
					</div>
					<!-- /ASIDE -->

					<!-- STORE -->
					<div id="store" class="col-md-9">
						<!-- store top filter -->
						<div class="store-filter clearfix">
							<div class="store-sort">
								<label>
									Sort By:
									<select class="input-select">
										<option value="0">Popular</option>
										<option value="1">Position</option>
									</select>
								</label>

								<label>
									Show:
									<select class="input-select">
										<option value="0">20</option>
										<option value="1">50</option>
									</select>
								</label>
							</div>
							<ul class="store-grid">
								<li class="active"><i class="fa fa-th"></i></li>
								<li><a href="#"><i class="fa fa-th-list"></i></a></li>
							</ul>
						</div>
						<!-- /store top filter -->

						<?php
            if (isset($errors)) {
                echo implode('<br/>', $errors);
                exit();
            }
            ?>

						<!-- store products -->
						<div class="row">
							<!-- product -->
							<div class="col-md-4 col-xs-6">
								<div class="product">
									<div class="product-img">
										<img src="./img/product01.png" alt="">
										<div class="product-label">
											<span class="sale">-30%</span>
											<span class="new">NEW</span>
										</div>
									</div>
									<div class="product-body">
										<p class="product-category">Category</p>
										<h3 class="product-name"><a href="#"></a></h3>
										<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="product-btns">
											<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
											<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
											<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
										</div>
									</div>
									<div class="add-to-cart">
										<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
									</div>
								</div>
							</div>
							<!-- /product -->

							<div class="clearfix visible-sm visible-xs"></div>

			
            <?php
            if (isset($errors)) {
                echo implode('<br/>', $errors);
                exit();
            }
            ?>
							<div class="col-md-4 col-xs-6">
								<div class="product">
									<div class="product-img">
									<?php
                foreach ($images as $image) {
                    $imageId = $image['id'];
                    $imageFilename = $image['filename'];
                    ?>
										<img src="<?php echo $imageFilename; ?>" alt="">
										<?php
                }
                ?>
									</div>
									<div class="product-body">
										<p class="product-category">Category</p>
										<h3 class="product-name"><a href="#"><?php echo $productName; ?></a></h3>
										<h4 class="product-price"><?php echo '$' . $productPrice; ?><del class="product-old-price"></del></h4>
										<div class="product-rating">
										</div>
										<div class="product-btns">
											<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
											<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
											<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
										</div>
									</div>
									<div class="add-to-cart">
										<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
									</div>
								</div>
							</div>

        </div>

						</div>
						<!-- /store products -->

						<!-- store bottom filter -->
						<div class="store-filter clearfix">
							<span class="store-qty">Showing 20-100 products</span>
							<ul class="store-pagination">
								<li class="active">1</li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
							</ul>
						</div>
						<!-- /store bottom filter -->
					</div>
					<!-- /STORE -->
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
	
		</body>
	</html>

