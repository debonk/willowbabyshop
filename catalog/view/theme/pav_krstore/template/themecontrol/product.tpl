<?php
	echo $header;
	$column_left = $column_right = null;
	$content_top=null ;
?>
<style type="text/css">
	#top {
		display: none;
	}

	#topbar {
		display: none;
	}

	.copyright {
		display: none;
	}

	#back-to-top {
		display: none;
	}

	#sys-notification {
		position: static;
		margin-top: 30px;
	}

	.quick-view {
		padding-bottom: 25px;
	}

	body header,
	.breadcrumb,
	#menu,
	body footer {
		display: none;
	}
</style>
<?php 
	$config = $sconfig;
  $themeConfig = (array)$config->get('themecontrol');
  $productConfig = array(     
      'product_enablezoom'         => 1,
      'product_zoommode'           => 'basic',
      'product_zoomeasing'         => 1,
      'product_zoomlensshape'      => "round",
      'product_zoomlenssize'       => "150",
      'product_zoomgallery'        => 0,
      'enable_product_customtab'   => 0,
      'product_customtab_name'     => '',
      'product_customtab_content'  => '',
      'product_related_column'     => 0,        
    );
    $listingConfig = array(   
      'category_pzoom'                    => 1, 
      'quickview'                                 => 0,
      'show_swap_image'                         => 0,
      'catalog_mode'                => 1
    ); 
    $listingConfig          = array_merge($listingConfig, $themeConfig );
    $categoryPzoom            = $listingConfig['category_pzoom']; 
    $quickview                = $listingConfig['quickview'];
    $swapimg                  = ($listingConfig['show_swap_image'])?'swap':'';
    $productConfig                = array_merge( $productConfig, $themeConfig );  
    $languageID               = $config->get('config_language_id');   

?>
<div class="container">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?= $breadcrumb['href']; ?>">
				<?= $breadcrumb['text']; ?>
			</a></li>
		<?php } ?>
	</ul>
	<div class="row">
		<?= $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-sm-9'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?= $class; ?> quick-view space-top-30">
			<?= $content_top; ?>
			<div class="row">
				<?php if ($column_left || $column_right) { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } else { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } ?>
				<?php require( ThemeControlHelper::getLayoutPath( 'product/preview/default.tpl' ) );  ?>
				<?php if ($column_left || $column_right) { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } else { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } ?>
				<div class="detail-container <?= $class; ?>">
					<h1>
						<?= $heading_title; ?>
					</h1>
					<?php if ($review_status) { ?>
					<div class="rating">
						<p>
							<?php for ($i = 1; $i <= 5; $i++) { ?>
							<?php if ($rating < $i) { ?>
							<span><i class="zmdi zmdi-star-outline"></i></span>
							<?php } else { ?>
							<span class="rate"><i class="zmdi zmdi-star"></i></span>
							<?php } ?>
							<?php } ?>
						</p>
						<a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">
							<?= $reviews; ?>
						</a> - <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">
							<?= $text_write; ?>
						</a>
					</div>
					<?php } ?>
					<?php if ($price) { ?>
					<?php if (!$special) { ?>
					<h3 class="price-olds">
						<?= $price; ?>
					</h3>
					<?php } else { ?>
					<div class="price clearfix">
						<span class="price-old">
							<?= $price; ?>
						</span>&nbsp;
						<span class="label label-danger special-percentage-big">
							<?= $special_text; ?>
						</span>
						<!--Bonk-->
						<div class="price-new" id="special">
							<?= $special; ?>
						</div>
					</div>
					<?php } ?>
					<ul class="list-unstyled">
						<?php if ($tax) { ?>
						<li><span class="type">
								<?= $text_tax; ?>
							</span> <span>
								<?= $tax; ?>
							</span></li>
						<?php } ?>
						<?php if ($points) { ?>
						<li><span class="type">
								<?= $text_points; ?>
							</span> <span>
								<?= $points; ?>
							</span></li>
						<?php } ?>
						<?php if ($discounts) { ?>
						<?php foreach ($discounts as $discount) { ?>
						<li>
							<?= $discount['quantity'] . $text_discount; ?>
							<span id="discount<?= $discount['quantity']; ?>">
								<?= $discount['price']; ?>
							</span>
							<?= ' (' . $discount['text'] . ')'; ?>
						</li>
						<?php } ?>
						<?php } ?>
					</ul>
					<?php } ?>
					<ul class="list-unstyled">
						<?php if ($manufacturer) { ?>
						<li><span class="type">
								<?= $text_manufacturer; ?>
							</span> <a href="<?= $manufacturers; ?>">
								<?= $manufacturer; ?>
							</a></li>
						<?php } ?>
						<li><span class="type">
								<?= $text_model; ?>
							</span> <span>
								<?= $model; ?>
							</span></li>
						<?php if ($reward) { ?>
						<li><span class="type">
								<?= $text_reward; ?>
							</span> <span>
								<?= $reward; ?>
							</span></li>
						<?php } ?>
						<li><span class="type">
								<?= $text_stock; ?>
							</span> <span>
								<?= $stock; ?>
							</span></li>
					</ul>
					<div id="product">
						<?php if ($options) { ?>
						<h3>
							<?= $text_option; ?>
						</h3>
						<?php foreach ($options as $option) { ?>
						<?php if ($option['type'] == 'select') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>">
								<?= $option['name']; ?>
							</label>
							<select name="option[<?= $option['product_option_id']; ?>]"
								id="input-option<?= $option['product_option_id']; ?>" class="form-control">
								<option value="">
									<?= $text_select; ?>
								</option>
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
								<option value="<?= $option_value['product_option_value_id']; ?>">
									<?= $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
									(
									<?= $option_value['price_prefix']; ?>
									<?= $option_value['price']; ?>)
									<?php } ?>
								</option>
								<?php } ?>
							</select>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'radio') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?> form-group-v2">
							<label class="control-label">
								<?= $option['name']; ?>
							</label>
							<div id="input-option<?= $option['product_option_id']; ?>">
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
								<div class="radio">
									<label>
										<input type="radio" name="option[<?= $option['product_option_id']; ?>]"
											value="<?= $option_value['product_option_value_id']; ?>" />
										<?= $option_value['name']; ?>
										<?php if ($option_value['price']) { ?>
										(
										<?= $option_value['price_prefix']; ?>
										<?= $option_value['price']; ?>)
										<?php } ?>
									</label>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'checkbox') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?> form-group-v2">
							<label class="control-label">
								<?= $option['name']; ?>
							</label>
							<div id="input-option<?= $option['product_option_id']; ?>">
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="option[<?= $option['product_option_id']; ?>][]"
											value="<?= $option_value['product_option_value_id']; ?>" />
										<?= $option_value['name']; ?>
										<?php if ($option_value['price']) { ?>
										(
										<?= $option_value['price_prefix']; ?>
										<?= $option_value['price']; ?>)
										<?php } ?>
									</label>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'image') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?> form-group-v2">
							<label class="control-label">
								<?= $option['name']; ?>
							</label>
							<div id="input-option<?= $option['product_option_id']; ?>">
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
								<div class="radio">
									<label>
										<input type="radio" name="option[<?= $option['product_option_id']; ?>]"
											value="<?= $option_value['product_option_value_id']; ?>" />
										<img src="<?= $option_value['image']; ?>"
											alt="<?= $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>"
											class="img-thumbnail" />
										<?= $option_value['name']; ?>
										<?php if ($option_value['price']) { ?>
										(
										<?= $option_value['price_prefix']; ?>
										<?= $option_value['price']; ?>)
										<?php } ?>
									</label>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'text') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>">
								<?= $option['name']; ?>
							</label>
							<input type="text" name="option[<?= $option['product_option_id']; ?>]"
								value="<?= $option['value']; ?>" placeholder="<?= $option['name']; ?>"
								id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'textarea') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>">
								<?= $option['name']; ?>
							</label>
							<textarea name="option[<?= $option['product_option_id']; ?>]" rows="5"
								placeholder="<?= $option['name']; ?>"
								id="input-option<?= $option['product_option_id']; ?>"
								class="form-control"><?= $option['value']; ?></textarea>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'file') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label">
								<?= $option['name']; ?>
							</label>
							<button type="button" id="button-upload<?= $option['product_option_id']; ?>"
								data-loading-text="<?= $text_loading; ?>" class="btn btn-v2 button-upload"><i
									class="fa fa-upload"></i>
								<?= $button_upload; ?>
							</button>
							<input type="hidden" name="option[<?= $option['product_option_id']; ?>]" value=""
								id="input-option<?= $option['product_option_id']; ?>" />
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'date') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>">
								<?= $option['name']; ?>
							</label>
							<div class="input-group date clearfix">
								<input type="text" name="option[<?= $option['product_option_id']; ?>]"
									value="<?= $option['value']; ?>" data-date-format="YYYY-MM-DD"
									id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
								<span class="input-group-btn"><button class="btn btn-v1 button-calendar" type="button"><i
											class="fa fa-calendar"></i></button></span>
							</div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'datetime') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>">
								<?= $option['name']; ?>
							</label>
							<div class="input-group datetime clearfix">
								<input type="text" name="option[<?= $option['product_option_id']; ?>]"
									value="<?= $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm"
									id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
								<span class="input-group-btn"><button type="button" class="btn btn-v1 button-calendar"><i
											class="fa fa-calendar"></i></button></span>
							</div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'time') { ?>
						<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?= $option['product_option_id']; ?>">
								<?= $option['name']; ?>
							</label>
							<div class="input-group time clearfix">
								<input type="text" name="option[<?= $option['product_option_id']; ?>]"
									value="<?= $option['value']; ?>" data-date-format="HH:mm"
									id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
								<span class="input-group-btn"><button type="button" class="btn btn-v1 button-calendar"><i
											class="fa fa-calendar"></i></button></span>
							</div>
						</div>
						<?php } ?>
						<?php } ?>
						<?php } ?>
						<?php if ($recurrings) { ?>
						<h3>
							<?= $text_payment_recurring ?>
						</h3>
						<div class="form-group required">
							<select name="recurring_id" class="form-control">
								<option value="">
									<?= $text_select; ?>
								</option>
								<?php foreach ($recurrings as $recurring) { ?>
								<option value="<?= $recurring['recurring_id'] ?>">
									<?= $recurring['name'] ?>
								</option>
								<?php } ?>
							</select>
							<div class="help-block" id="recurring-description"></div>
						</div>
						<?php } ?>
						<div class="product-buttons-wrap clearfix">
							<label class="control-label qty">
								<?= $entry_qty; ?>:
							</label>
							<div class="product-qyt-action clearfix">
								<div class="quantity-adder  pull-left">
									<div class="quantity-number pull-left">
										<input type="text" name="quantity" value="<?= $minimum; ?>" size="2" id="input-quantity"
											class="form-control text-center" />
									</div>
									<span class="add-down add-action pull-left">
										<i class="zmdi zmdi-minus"></i>
									</span>
									<span class="add-up add-action pull-left">
										<i class="zmdi zmdi-plus"></i>
									</span>
								</div>
								<div class="cart pull-left">
									<button type="button" id="button-cart" data-loading-text="<?= $text_loading; ?>"
										class="btn btn-v1 button-calendar">
										<?= $button_cart; ?>
									</button>
								</div>
							</div>
							<input type="hidden" name="product_id" value="<?= $product_id; ?>" />
							<div class="action clearfix">
								<div class="pull-left">
									<a data-toggle="tooltip" class="wishlist" title="<?= $button_wishlist; ?>"
										onclick="wishlist.add('<?= $product_id; ?>');"><i class="fa fa-heart-o"></i>
										<?= $button_wishlist; ?>
									</a>
								</div>
								<div class="pull-left">
									<a data-toggle="tooltip" class="compare" title="<?= $button_compare; ?>"
										onclick="compare.add('<?= $product_id; ?>');"><i class="fa fa-bar-chart"></i>
										<?= $button_compare; ?>
									</a>
								</div>
							</div>
						</div>
						<!-- AddThis Button BEGIN -->
						<div class="addthis_toolbox addthis_default_style">
							<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
							<a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a>
							<a class="addthis_counter addthis_pill_style"></a>
						</div>
						<script type="text/javascript"
							src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
						<!-- AddThis Button END -->
						<?php if ($minimum > 1) { ?>
						<div class="alert alert-info"><i class="fa fa-info-circle"></i>
							<?= $text_minimum; ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?= $content_bottom; ?>
		</div>
		<?= $column_right; ?>
	</div>
</div>
<script type="text/javascript">
		$('select[name=\'recurring_id\'], input[name="quantity"]').change(function () {
			$.ajax({
				url: 'index.php?route=product/product/getRecurringDescription',
				type: 'post',
				data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
				dataType: 'json',
				beforeSend: function () {
					$('#recurring-description').html('');
				},
				success: function (json) {
					$('.alert, .text-danger').remove();
					if (json['success']) {
						$('#recurring-description').html(json['success']);
					}
				}
			});
		});
</script>
<script type="text/javascript">
		$('#button-cart').on('click', function () {
			$.ajax({
				url: 'index.php?route=checkout/cart/add',
				type: 'post',
				data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
				dataType: 'json',
				beforeSend: function () {
					$('#button-cart').button('loading');
				},
				complete: function () {
					$('#button-cart').button('reset');
				},
				success: function (json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');

					if (json['error']) {
						if (json['error']['option']) {
							for (i in json['error']['option']) {
								var element = $('#input-option' + i.replace('_', '-'));

								if (element.parent().hasClass('input-group')) {
									element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
								} else {
									element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
								}
							}
						}

						if (json['error']['recurring']) {
							$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
						}

						// Highlight any found errors
						$('.text-danger').parent().addClass('has-error');
					}

					if (json['success']) {
						$('#notification').html('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						//$('#cart-total').html(json['total']);
						res = json['total'].split("-");
						$('#text-items').html(res[1]);
						var out = json['total'].substr(0, json['total'].indexOf(' '));

						$('#cart-total', window.parent.document).html(out);

						$('html, body').animate({ scrollTop: 0 }, 'slow');

						$('#cart > ul', window.parent.document).load('index.php?route=common/cart/info ul li');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

	var compare = {
		'add': function (product_id) {
			$.ajax({
				url: 'index.php?route=product/compare/add',
				type: 'post',
				data: 'product_id=' + product_id,
				dataType: 'json',
				success: function (json) {
					$('.alert').remove();

					if (json['success']) {
						$('#notification').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						$('#compare-total', window.parent.document).html(json['total']);

						$('html, body').animate({ scrollTop: 0 }, 'slow');
					}
				}
			});
		},
		'remove': function () {

		}
	}

	var wishlist = {
		'add': function (product_id) {
			$.ajax({
				url: 'index.php?route=account/wishlist/add',
				type: 'post',
				data: 'product_id=' + product_id,
				dataType: 'json',
				success: function (json) {
					$('.alert').remove();

					if (json['success']) {
						$('#notification').html('<div class="alert alert-info"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}

					if (json['info']) {
						$('#notification').html('<div class="alert alert-info"><i class="fa fa-info-circle"></i> ' + json['info'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}

					$('#wishlist-total', window.parent.document).html(json['total']);

					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			});
		},
		'remove': function () {

		}
	}
</script>
<script type="text/javascript">
		$('.date').datetimepicker({
			pickTime: false
		});
	$('.datetime').datetimepicker({
		pickDate: true,
		pickTime: true
	});
	$('.time').datetimepicker({
		pickDate: false
	});
	$('button[id^=\'button-upload\']').on('click', function () {
		var node = this;
		$('#form-upload').remove();
		$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
		$('#form-upload input[name=\'file\']').trigger('click');
		if (typeof timer != 'undefined') {
			clearInterval(timer);
		}
		timer = setInterval(function () {
			if ($('#form-upload input[name=\'file\']').val() != '') {
				clearInterval(timer);
				$.ajax({
					url: 'index.php?route=tool/upload',
					type: 'post',
					dataType: 'json',
					data: new FormData($('#form-upload')[0]),
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {
						$(node).button('loading');
					},
					complete: function () {
						$(node).button('reset');
					},
					success: function (json) {
						$('.text-danger').remove();
						if (json['error']) {
							$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
						}
						if (json['success']) {
							alert(json['success']);
							$(node).parent().find('input').attr('value', json['code']);
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		}, 500);
	});
</script>
<script type="text/javascript">
		$('#review').delegate('.pagination a', 'click', function (e) {
			e.preventDefault();
			$('#review').fadeOut('slow');
			$('#review').load(this.href);
			$('#review').fadeIn('slow');
		});
	$('#review').load('index.php?route=product/product/review&product_id=<?= $product_id; ?>');
	$('#button-review').on('click', function () {
		$.ajax({
			url: 'index.php?route=product/product/write&product_id=<?= $product_id; ?>',
			type: 'post',
			dataType: 'json',
			data: $("#form-review").serialize(),
			beforeSend: function () {
				$('#button-review').button('loading');
			},
			complete: function () {
				$('#button-review').button('reset');
			},
			success: function (json) {
				$('.alert-success, .alert-danger').remove();

				if (json['error']) {
					$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				}
				if (json['success']) {
					$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
					$('input[name=\'name\']').val('');
					$('textarea[name=\'text\']').val('');
					$('input[name=\'rating\']:checked').prop('checked', false);
				}
			}
		});
	});
	$(document).ready(function () {
		$('.thumbnails').magnificPopup({
			type: 'image',
			delegate: 'a',
			gallery: {
				enabled: true
			}
		});
	});
</script>
<?php if( $productConfig['product_enablezoom'] ) { ?>
<script type="text/javascript" src=" catalog/view/javascript/jquery/elevatezoom/elevatezoom-min.js"></script>
<script type="text/javascript">
	var zoomCollection = '<?= $productConfig["product_zoomgallery"]=="basic"?".product-image-zoom":"#image";?>';
	$(zoomCollection).elevateZoom({
		<?php if ($productConfig['product_zoommode'] != 'basic') { ?>
		zoomType        : "<?= $productConfig['product_zoommode'];?>",
		<?php } ?>
		lensShape : "<?= $productConfig['product_zoomlensshape'];?>",
			lensSize    : <?=(int)$productConfig['product_zoomlenssize'];?>,
				easing: true,
					gallery: 'image-additional-carousel',
						cursor: 'pointer',
							galleryActiveClass: "active"
	});

</script>
<?php } ?>