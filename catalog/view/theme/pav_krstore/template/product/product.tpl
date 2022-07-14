<?php
  $config = $sconfig;
  $themeConfig = (array)$config->get('themecontrol');
  $productConfig = array(
      'product_enablezoom'         	=> 1,
      'product_zoommode'           	=> 'basic',
      'product_zoomeasing'         	=> 1,
      'product_zoomlensshape'      	=> "round",
      'product_zoomlenssize'       	=> "300",
      'product_zoomgallery'        	=> 0,
      'enable_product_customtab'   	=> 0,
      'product_customtab_name'     	=> '',
      'product_customtab_content'  	=> '',
      'product_related_column'     	=> 0,
    );
    $listingConfig = array(   
      'category_pzoom'				=> 1,
      'quickview'					=> 0,
      'show_swap_image'				=> 0,
      'catalog_mode'                => 1
    ); 
    $listingConfig					= array_merge($listingConfig, $themeConfig );
    $categoryPzoom					= $listingConfig['category_pzoom']; 
    $quickview						= $listingConfig['quickview'];
    $swapimg						= ($listingConfig['show_swap_image'])?'swap':'';
    $productConfig					= array_merge( $productConfig, $themeConfig );  
    $languageID						= $config->get('config_language_id');   

?>
<!--Bonk: tp231 -->
<?= $header; ?>

<div class="container">
	<div class="row">
		<?= $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-lg-9 col-md-9 col-sm-12 col-xs-12'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<!--Bonk: tp231-c -->
		<div id="content" class="<?= $class; ?>">
			<?= $content_top; ?>
			<ul class="breadcrumb detail">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?= $breadcrumb['href']; ?>">
						<?= $breadcrumb['text']; ?>
					</a></li>
				<?php } ?>
			</ul>
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
					<h1 id="title">
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
						<?php if ($reviews) { ?>
						<a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">
							<?= $reviews; ?>
						</a> -
						<?php } ?>
						<a href="" onclick="$('a[href=\'#review-form\']').trigger('click'); return false;">
							<?= $text_write; ?>
						</a>
					</div>
					<?php } ?>
					<?php if ($price) { ?>
					<div id="price">
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
							<div class="price-new">
								<?= $special; ?>
							</div>
						</div>
						<?php } ?>
					</div>
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
							</span> <span id="points">
								<?= $points; ?>
							</span></li>
						<?php } ?>
						<?php if ($discounts) { ?>
						<div id="discount">
							<?php foreach ($discounts as $discount) { ?>
							<li>
								<?= $discount['text']; ?>
							</li>
							<?php } ?>
						</div>
						<?php } ?>
					</ul>
					<?php } ?>
					<ul class="list-unstyled">
						<?php if ($manufacturer) { ?>
						<?php if ($manufacturers_img) { ?>
						<li class="text-center"><a href="<?= $manufacturers; ?>">
								<?= ($manufacturers_img) ? '<img src="'.$manufacturers_img.'" title="'.$manufacturer.'" />' : '' ;?>
							</a></li>
						<?php } else { ?>
						<li><span class="type">
								<?= $text_manufacturer; ?>
							</span> <a href="<?= $manufacturers; ?>">
								<?= $manufacturer; ?>
							</a></li>
						<?php } ?>
						<?php } ?>
						<li><span class="type">
								<?= $text_model; ?>
							</span> <span id="model">
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
							</span> <span id="stock">
								<?= $stock; ?>
							</span></li>
					</ul>
					<div id="product">
						<div class="clearfix">
							<div class=" col-lg-8">
								<?php if ($variant_option) { ?>
								<h3>
									<?= $text_variant; ?>
								</h3>
								<?php foreach ($variant_option as $idx => $option) { ?>
								<?php if ($option['type'] == 'select') { ?>
								<div class="form-group required">
									<label class="control-label" for="input-variant<?= $idx; ?>">
										<?= $option['name']; ?>
									</label>
									<select name="variant[variant_id][<?= $idx; ?>]" id="input-variant<?= $idx; ?>" class="form-control">
										<option value="">
											<?= $text_select; ?>
										</option>
										<?php foreach ($option['option_value'] as $option_value) { ?>
										<option value="<?= $option_value['option_value_id']; ?>">
											<?= $option_value['name']; ?>
										</option>
										<?php } ?>
									</select>
								</div>
								<?php } ?>
								<?php if ($option['type'] == 'radio') { ?>
								<div class="form-group required form-group-v2">
									<label class="control-label">
										<?= $option['name']; ?>
									</label>
									<div id="input-variant<?= $idx; ?>">
										<?php foreach ($option['option_value'] as $option_value) { ?>
										<div class="radio">
											<label>
												<input type="radio" name="variant[variant_id][<?= $idx; ?>]"
													value="<?= $option_value['option_value_id']; ?>" />
												<?= $option_value['name']; ?>
											</label>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php } ?>
								<?php if ($option['type'] == 'checkbox') { ?>
								<div class="form-group required form-group-v2">
									<label class="control-label">
										<?= $option['name']; ?>
									</label>
									<div id="input-variant<?= $idx; ?>">
										<?php foreach ($option['option_value'] as $option_value) { ?>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="variant[variant_id][<?= $idx; ?>][]"
													value="<?= $option_value['option_value_id']; ?>" />
												<?= $option_value['name']; ?>
											</label>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php } ?>
								<?php if ($option['type'] == 'image') { ?>
								<div class="form-group required form-group-v2">
									<label class="control-label">
										<?= $option['name']; ?>
									</label>
									<div id="input-variant<?= $idx; ?>">
										<?php foreach ($option['option_value'] as $option_value) { ?>
										<div class="radio">
											<label>
												<input type="radio" name="variant[variant_id][<?= $idx; ?>]"
													value="<?= $option_value['option_value_id']; ?>" />
												<img src="<?= $option_value['image']; ?>" alt="<?= $option_value['name']; ?>"
													class="img-thumbnail" />
											</label>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php } ?>
								<?php } ?>
								<?php } ?>
							</div>
						</div>

						<div>
							<?php if ($options) { ?>
							<h3>
								<?= $text_option; ?>
							</h3>
							<?php foreach ($options as $option) { ?>
							<?php if ($option['type'] == 'text') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
								<label class="control-label" for="input-option<?= $option['product_option_id']; ?>">
									<?= $option['name']; ?>
								</label>
								<input type="text" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['value']; ?>"
									placeholder="<?= $option['name']; ?>" id="input-option<?= $option['product_option_id']; ?>"
									class="form-control" />
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'textarea') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
								<label class="control-label" for="input-option<?= $option['product_option_id']; ?>">
									<?= $option['name']; ?>
								</label>
								<textarea name="option[<?= $option['product_option_id']; ?>]" rows="5"
									placeholder="<?= $option['name']; ?>" id="input-option<?= $option['product_option_id']; ?>"
									class="form-control"><?= $option['value']; ?></textarea>
							</div>
							<?php } ?>
							<?php if ($option['type'] == 'file') { ?>
							<div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
								<label class="control-label">
									<?= $option['name']; ?>
								</label>
								<button type="button" id="button-upload<?= $option['product_option_id']; ?>"
									data-loading-text="<?= $text_loading; ?>" class="btn btn-v1 button-upload"><i
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
							<div class="form-group required col-lg-8">
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
							<div class="product-buttons-wrap clearfix col-xs-12">
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
										<button type="button" data-loading-text="<?= $text_loading; ?>" class="btn btn-v1 button-cart"
											id="button-cart">
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
							<?php if ($minimum > 1) { ?>
							<div class="alert alert-info"><i class="fa fa-info-circle"></i>
								<?= $text_minimum; ?>
							</div>
							<?php } ?>
							<?php if ($tags) { ?>
							<p>
								<?= $text_tags; ?>
								<?php for ($i = 0; $i < count($tags); $i++) { ?>
								<?php if ($i < (count($tags) - 1)) { ?>
								<a href="<?= $tags[$i]['href']; ?>">
									<?= $tags[$i]['tag']; ?>
								</a>,
								<?php } 
									else { ?>
								<a href="<?= $tags[$i]['href']; ?>">
									<?= $tags[$i]['tag']; ?>
								</a>
								<?php } ?>
								<?php } ?>
							</p>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-v88">
				<ul class="nav text-center nav-tabs">
					<li class="active"><a href="#tab-description" data-toggle="tab">
							<?= $tab_description; ?>
						</a></li>
					<?php if ($attribute_groups) { ?>
					<li><a href="#tab-specification" data-toggle="tab">
							<?= $tab_attribute; ?>
						</a></li>
					<?php } ?>
					<?php if ($review_status) { ?>
					<li><a href="#tab-review" data-toggle="tab">
							<?= $tab_review; ?>
						</a></li>
					<?php } ?>
					<?php if( $productConfig['enable_product_customtab'] && isset($productConfig['product_customtab_name'][$languageID]) ) { ?>
					<li><a href="#tab-customtab" data-toggle="tab">
							<?= $productConfig['product_customtab_name'][$languageID]; ?>
						</a></li>
					<?php } ?>
				</ul>
				<div class="tab-content text-left">
					<div class="tab-pane active" id="tab-description">
						<?= $description; ?>
					</div>
					<?php if ($attribute_groups) { ?>
					<div class="tab-pane" id="tab-specification">
						<table class="table table-bordered">
							<?php foreach ($attribute_groups as $attribute_group) { ?>
							<thead>
								<tr>
									<td colspan="2"><strong>
											<?= $attribute_group['name']; ?>
										</strong></td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
								<tr>
									<td>
										<?= $attribute['name']; ?>
									</td>
									<td>
										<?= $attribute['text']; ?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
							<?php } ?>
						</table>
					</div>
					<?php } ?>
					<?php if ($review_status) { ?>

					<div class="tab-pane" id="tab-review">
						<div id="review" class="space-20"></div>
						<p> <a href="#review-form" class="popup-with-form btn btn-v2"
								onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">
								<?= $text_write; ?>
							</a></p>

						<div class="hide">
							<div id="review-form" class="panel review-form-width">
								<div class="panel-body">
									<form class="form-horizontal" id="form-review">
										<div class="panel-heading">
											<h4 class="panel-title panel-v1">
												<?= $text_write; ?>
											</h4>
										</div>
										<div class="form-group required">
											<div class="col-sm-12">
												<label class="control-label" for="input-name">
													<?= $entry_name; ?>
												</label>
												<input type="text" name="name" value="" id="input-name" class="form-control" />
											</div>
										</div>
										<div class="form-group required">
											<div class="col-sm-12">
												<label class="control-label" for="input-review">
													<?= $entry_review; ?>
												</label>
												<textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
												<div class="help-block">
													<?= $text_note; ?>
												</div>
											</div>
										</div>
										<div class="form-group required" style="font-family: arial;">
											<div class="col-sm-12">
												<label class="control-label">
													<?= $entry_rating; ?>
												</label>
												<div id="input-rating">
													&nbsp;&nbsp;&nbsp;
													<?= $entry_bad; ?>&nbsp;
													<input type="radio" name="rating" value="1" />
													&nbsp;
													<input type="radio" name="rating" value="2" />
													&nbsp;
													<input type="radio" name="rating" value="3" />
													&nbsp;
													<input type="radio" name="rating" value="4" />
													&nbsp;
													<input type="radio" name="rating" value="5" />
													&nbsp;
													<?= $entry_good; ?>
												</div>
											</div>
										</div>
										<?= $captcha; ?>
										<div class="buttons">
											<div class="pull-right">
												<button type="button" id="button-review" data-loading-text="<?= $text_loading; ?>"
													class="btn btn-v1">
													<?= $button_continue; ?>
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
					<?php } ?>
					<?php if( $productConfig['enable_product_customtab'] && isset($productConfig['product_customtab_content'][$languageID]) ) { ?>
					<div id="tab-customtab" class="tab-pane custom-tab">
						<div class="inner">
							<?= html_entity_decode( $productConfig['product_customtab_content'][$languageID], ENT_QUOTES, 'UTF-8'); ?>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php if ($products) {  $heading_title = $text_related; $customcols = 4; ?>
			<div class="panel panel-default product-related">
				<?php require( ThemeControlHelper::getLayoutPath( 'common/products_carousel.tpl' ) );  ?>
			</div>
			<?php } ?>
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
	$('[name^=\'variant\']').on('change', function () {
		$.ajax({
			url: 'index.php?route=product/product/variant&product_id=<?= $product_id; ?>',
			type: 'post',
			data: $('#product select, #product input[type=\'radio\']:checked'),
			dataType: 'json',
			success: function (json) {
				if (json['detail']) {
					let html = '';

					if (json['detail']['special']) {
						html = '<div class="price clearfix">';
						html += '  <span class="price-old">' + json['detail']['price'] + ' </span>&nbsp;';
						html += '  <span class="label label-danger special-percentage-big">' + json['detail']['special_text'] + '</span>';
						html += '  <div class="price-new">' + json['detail']['special'] + '</div>';
						html += '</div>';

						$('.product-label').show();
					} else {
						html = '<h3 class="price-olds" id="price">' + json['detail']['price'] + '</h3>';

						$('.product-label').hide();
					}

					$('#price').html(html);

					html = '';

					if (json['detail']['discount']) {
						for (const i in json['detail']['discount']) {
							html += '<li>' + json['detail']['discount'][i]['text'] + '</li>';
						}
					}

					$('#discount').html(html);

					$('#model').html(json['detail']['model']);
					$('#title').html(json['detail']['name']);
					$('#stock').html(json['detail']['stock']);
					$('#points').html(json['detail']['points']);

					$('#thumb-v' + json['detail']['idx']).trigger('click');
				}
			}
		});
	});

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
					if (json['error']['variant']) {
						if (json['error']['variant']['warning']) {
							$('#notification').html('<div class="alert alert-danger">' + json['error']['variant']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>').fadeIn();
							setTimeout(function () { $('#notification').fadeOut(1000); }, 3000);

						} else {
							for (i in json['error']['variant']) {
								var element = $('#input-variant' + i);

								if (element.parent().hasClass('input-group')) {
									element.parent().after('<div class="text-danger">' + json['error']['variant'][i] + '</div>');
								} else {
									element.after('<div class="text-danger">' + json['error']['variant'][i] + '</div>');
								}
							}
						}
					}

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
					$('#notification').html('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>').fadeIn();
					setTimeout(function () { $('#notification').fadeOut(1000); }, 3000);

					res = json['total'].split("-");
					$('#text-items').html(res[1]);
					var out = json['total'].substr(0, json['total'].indexOf(' '));
					$('#cart-total').html(out);
					$('html, body').animate({ scrollTop: 0 }, 'slow');

					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	});
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
				$('.alert-success, .text-danger').remove();

				if (json['error']) {
					for (i in json['error']) {
						let element = $('#form-review #input-' + i);

						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}

					// Highlight any found errors
					$('.text-danger').parent().addClass('has-error');
				}

				if (json['success']) {
					$('#notification').html('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('input[name=\'name\']').val('');
					$('textarea[name=\'text\']').val('');
					$('input[name=\'rating\']:checked').prop('checked', false);

					$('.mfp-close').trigger('click');
				}
			}
		});
	});

	$(document).ready(function () {
		$('.thumbnail a').click(
			function () {
				$.magnificPopup.open({
					items: {
						src: $('img', this).attr('src')
					},
					type: 'image'
				});
				return false;
			}
		);
	});
</script>
<?php if( $productConfig['product_enablezoom'] ) { ?>
<script type="text/javascript" src=" catalog/view/javascript/jquery/elevatezoom/elevatezoom-min.js"></script>
<script type="text/javascript">
	let zoomCollection = '<?= $productConfig["product_zoomgallery"]=="basic"?".product-image-zoom":"#image";?>';
	let zoomType = '<?= $productConfig["product_zoommode"];?>';

	if (zoomType == 'basic') {
		zoomType = undefined;
	}

	$(zoomCollection).elevateZoom({
		zoomType: zoomType,
		lensShape: "<?= $productConfig['product_zoomlensshape'];?>",
		lensSize: "<?= (int)$productConfig['product_zoomlenssize'];?>",
		easing: true,
		gallery: 'image-additional-carousel',
		cursor: 'pointer',
		galleryActiveClass: "active"
	});

</script>
<?php } else { ?>
<script type="text/javascript">
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
<?php } ?>
<script type="application/ld+json"><?= $mark_up_breadcrumb;?></script>
<script type="application/ld+json"><?= $mark_up_product;?></script>
<?= $footer; ?>