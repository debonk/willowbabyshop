<div class="product-block">
    <?php if ($product['thumb']) {    ?>
		<div class="image">
			<?php if( $product['special'] ) {   ?>
				<span class="product-label sale-exist radius-3x text-center"><span class="product-label-special"><?php echo $objlang->get('text_sale'); ?></span></span>
			<?php } ?>
			<div class="product-img img">
				<a class="img" title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>">
					<img class="img-responsive" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" />
				</a>
				<div class="zoom hidden-xs hidden-sm">
					<?php if( isset($categoryPzoom) && $categoryPzoom ) { $zimage = str_replace( "cache/","", preg_replace("#-\d+x\d+#", "",  $product['thumb'] ));  ?>
						<a data-toggle="tooltip" data-placement="top" href="<?php echo $zimage;?>" class="product-zoom info-view colorbox cboxElement" title="<?php echo $product['name']; ?>"><i class="fa fa-search"></i></a>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="product-meta">
		<div class="top">
			<h6 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h6>
			<?php if( isset($product['description']) ){ ?>
				<p class="description"><?php echo utf8_substr( strip_tags($product['description']),0,200);?>...</p>
			<?php } ?>
			<?php if ($product['price']) { ?>
				<div class="price clearfix" style="display:none;">
					<?php if (!$product['special']) {  ?>
						<span class="price-olds"><?php echo $product['price']; ?></span>
						<?php if( preg_match( '#(\d+).?(\d+)#',  $product['price'], $p ) ) { ?>
						<?php } ?>
					<?php } else { ?>
						<span class="price-new"><?php echo $product['special']; ?></span>
						<span class="price-old"><?php echo $product['price']; ?></span>
						<?php if( preg_match( '#(\d+).?(\d+)#',  $product['special'], $p ) ) { ?>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
			<?php if ($product['rating']) { ?>
				<div class="rating">
					<?php for ($is = 1; $is <= 5; $is++) { ?>
						<?php if ($product['rating'] < $is) { ?>
							<span><i class="zmdi zmdi-star-outline"></i></span>
						<?php } else { ?>
							<span class="rate"><i class="zmdi zmdi-star-outline"></i></span>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
        <div class="bottom">
			<div class="action">
				<?php if( !isset($listingConfig['catalog_mode']) || !$listingConfig['catalog_mode'] ) { ?>
					<div class="cart">
						<button class="btn-action" style="display:none;" data-loading-text="Loading..." type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i></button>
					</div>
				<?php } ?>
				<div class="compare">
					<button class="btn-action" type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $objlang->get("button_compare"); ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-bar-chart"></i></button> 
				</div>
				<div class="wishlist">
					<button class="btn-action" type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $objlang->get("button_wishlist"); ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart-o"></i></button> 
				</div>
				<?php if ( isset($quickview) && $quickview ) { ?>
					<div class="quickview hidden-sm hidden-xs">
						<a class="iframe-link text-center btn-action quick-view" data-toggle="tooltip" data-placement="top" href="<?php echo $ourl->link('themecontrol/product','product_id='.$product['product_id']);?>"  title="<?php echo $objlang->get('quick_view'); ?>" ><i class="zmdi zmdi-eye"></i></a>
					</div>
				<?php } ?> 
			</div>
        </div>
	</div>
</div>