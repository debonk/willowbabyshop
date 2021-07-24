<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo  $helper->getDirection(); ?>" class="<?php echo $helper->getDirection(); ?>"
	lang="<?php echo $lang; ?>">
<!--<![endif]-->
<!--Bonk: tp211 -->
<?php  require( ThemeControlHelper::getLayoutPath( 'common/parts/head.tpl' ) );   ?>

<body class="<?php echo $class; ?> <?php echo $helper->getPageClass();?>">
	<div class="row-offcanvas row-offcanvas-left layout-<?php echo $template_layout; ?>">
		<?php
		if( isset($_COOKIE[$themeName .'_skin']) && $_COOKIE[$themeName .'_skin'] ){
			$skin = trim($_COOKIE[$themeName .'_skin']);
		}
	?>
		<header class="header-v1 bg-white clearfix">
			<div class="container">
				<div class="row">
					<div id="logo" class="col-sm-4 col-sm-push-4 col-sm-offset-0 col-xs-6 col-xs-offset-3">
						<?php if ($logo) { ?>
						<a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>"
								alt="<?php echo $name; ?>" class="img-responsive" /></a>
						<?php }
					else { ?>
						<h1><a href="<?php echo $home; ?>">
								<?php echo $name; ?>
							</a></h1>
						<?php } ?>
					</div>
					<div class="col-sm-4 col-sm-push-4 col-xs-3 right-panel">
						<div id="cart-top" class="col-xs-1 pull-right">
							<?php echo $cart; ?>
						</div>
						<div id="setting" class="dropdown col-xs-1 pull-right">
							<div class="dropdown-toggle text-center" data-toggle="dropdown">
								<i class="fa fa-cog fa-lg"></i>
							</div>
							<ul class="dropdown-menu box-setting">
								<li>
									<h5>ACCOUNT</h5>
								</li>
								<li class="language">
									<?php echo $language; ?>
								</li>
								<li class="currency">
									<?php echo $currency; ?>
								</li>
								<li class="account">
									<ul>
										<?php if ($logged) { ?>
										<li><a href="<?php echo $account; ?>"><i class="fa fa-user"></i>
												<?php echo $text_account; ?>
											</a></li>
										<li><a id="wishlist-total" href="<?php echo $wishlist; ?>"><i class="fa fa-heart"></i>
												<?php echo $text_wishlist; ?>
											</a></li>
										<li><a href="<?php echo $shopping_cart; ?>"><i class="fa fa-shopping-cart"></i>
												<?php echo $text_shopping_cart; ?>
											</a></li>
										<li><a href="<?php echo $checkout; ?>"><i class="fa fa-check"></i>
												<?php echo $text_checkout; ?>
											</a></li>
										<li class="logout"><a href="<?php echo $logout; ?>"><i class="fa fa-sign-out"></i>
												<?php echo $text_logout; ?>
											</a></li>
										<?php }
									else { ?>
										<li><a href="<?php echo $account; ?>"><i class="fa fa-user"></i>
												<?php echo $text_account; ?>
											</a></li>
										<li><a href="<?php echo $wishlist; ?>"><i class="fa fa-heart"></i> <span id="wishlist-total">
													<?php echo $text_wishlist; ?>
												</span></a></li>
										<li><a href="<?php echo $shopping_cart; ?>"><i class="zmdi zmdi-shopping-basket"></i>
												<?php echo $text_shopping_cart; ?>
											</a></li>
										<li><a href="<?php echo $checkout; ?>"><i class="fa fa-check"></i>
												<?php echo $text_checkout; ?>
											</a></li>
										<li class="logout"><a href="<?php echo $login; ?>"><i class="fa fa-key"></i>
												<?php echo $text_login; ?>
											</a></li>
										<li><a href="<?php echo $register; ?>"><i class="fa fa-pencil"></i>
												<?php echo $text_register; ?>
											</a></li>
										<?php } ?>
									</ul>
								</li>
							</ul>
						</div>
						<div id="search" class="search col-md-9 hidden-sm hidden-xs pull-right">
							<?php echo $search; ?>
						</div>

						<!-- Bonk: Blog n Contact Button -->
						<!--					<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
						<a href="index.php?route=pavblog/blogs" class="userbutton"><i class="fa fa-pencil-square-o fa-lg"></i>  Blog</a>
						<a href="index.php?route=information/contact" class="userbutton userbutton2"> <i class="fa fa-envelope fa-lg"></i>  Contact Us!</a>
					</div>
-->
					</div>
					<div class="col-sm-4 col-sm-pull-8 col-xs-12">
						<!-- Bonk: hidden-xs -->
						<div id="icon-box-header">
							<?php
						if($content=$helper->getLangConfig('icon_box_header')){
							echo $content;
						}
					?>
						</div>
						<div class="welcome col-lg-10 col-xs-12">
							<?php echo $welcome;?>
						</div>
					</div>
				</div>
			</div>
			<div id="group-menu">
				<div class="container">
					<div class="row">
						<div class="bo-mainmenu">
							<?php  require( ThemeControlHelper::getLayoutPath( 'common/parts/mainmenu.tpl' ) );   ?>
						</div>
						<div id="search2" class="search hidden-lg hidden-md col-sm-7 col-xs-7 pull-right">
							<?php echo $search; ?>
						</div>
					</div>
				</div>
			</div>
		</header>

		<!-- sys-notification -->
		<div id="sys-notification">
			<div class="container">
				<div id="notification"></div>
			</div>
		</div>
		<!-- /sys-notification -->

		<?php
		/**
		* Showcase modules
		* $ospans allow overrides width of columns base on thiers indexs. format array( column-index=>span number ), example array( 1=> 3 )[value from 1->12]
		*/
		//$modules = $helper->getCloneModulesInLayout( $blockid, $layoutID );
		$blockid = 'slideshow';
		$blockcls = "hidden-xs hidden-sm";
		$ospans = array(1=>12);
		require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
	?>
		<?php
		/**
		* Showcase modules
		* $ospans allow overrides width of columns base on thiers indexs. format array( column-index=>span number ), example array( 1=> 3 )[value from 1->12]
		*/
		$blockid = 'showcase';
		$blockcls = 'hidden-xs hidden-sm';
		$ospans = array(1=>12);
		require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
	?>
		<?php
		/**
		* promotion modules
		* $ospans allow overrides width of columns base on thiers indexs. format array( column-index=>span number ), example array( 1=> 3 )[value from 1->12]
		*/
		$blockid = 'promotion';
		$blockcls = "hidden-xs hidden-sm";
		$ospans = array(1=>12, 2=>12);
		require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
	?>
		<div class="maincols clearfix">
			<script type="text/javascript">
				$('#button-shopee').on('click', function (e) {
					var url = 'https://partner.test-stable.shopeemobile.com/api/v2/shop/auth_partner?partner_id=1001839&redirect=www.willowbabyshop.com&sign=<?php echo $auth_signature ?>&timestamp=<?php echo $timestamp ?>';

					open(url);
				});

			</script>