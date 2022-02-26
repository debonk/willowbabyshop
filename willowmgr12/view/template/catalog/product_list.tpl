<?= $header; ?>
<?= $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right"><a href="<?= $add; ?>" data-toggle="tooltip" title="<?= $button_add; ?>"
					class="btn btn-primary"><i class="fa fa-plus"></i></a>
				<button type="button" data-toggle="tooltip" title="<?= $button_copy; ?>" class="btn btn-default"
					onclick="$('#form-product').attr('action', '<?= $copy; ?>').submit()"><i class="fa fa-copy"></i></button>
				<button type="button" data-toggle="tooltip" title="<?= $button_delete; ?>" class="btn btn-danger"
					onclick="confirm('<?= $text_confirm; ?>') ? $('#form-product').submit() : false;"><i
						class="fa fa-trash-o"></i></button>
			</div>
			<h1>
				<?= $heading_title; ?>
			</h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?= $breadcrumb['href']; ?>">
						<?= $breadcrumb['text']; ?>
					</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
			<?= $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i>
			<?= $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i>
					<?= $text_list; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="well">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label" for="input-name">
									<?= $entry_name; ?>
								</label>
								<input type="text" name="filter_name" value="<?= $filter_name; ?>" placeholder="<?= $entry_name; ?>"
									id="input-name" class="form-control" />
							</div>
							<div class="form-group">
								<label class="control-label" for="input-model">
									<?= $entry_model; ?>
								</label>
								<input type="text" name="filter_model" value="<?= $filter_model; ?>" placeholder="<?= $entry_model; ?>"
									id="input-model" class="form-control" />
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label" for="input-price">
									<?= $entry_price; ?>
								</label>
								<input type="text" name="filter_price" value="<?= $filter_price; ?>" placeholder="<?= $entry_price; ?>"
									id="input-price" class="form-control" />
							</div>
							<div class="form-group">
								<label class="control-label" for="input-quantity">
									<?= $entry_quantity; ?>
								</label>
								<input type="text" name="filter_quantity" value="<?= $filter_quantity; ?>"
									placeholder="<?= $entry_quantity; ?>" id="input-quantity" class="form-control" />
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label" for="input-manufacturer">
									<?= $column_manufacturer; ?>
								</label>
								<select name="filter_manufacturer" id="input-manufacturer" class="form-control">
									<option value="*">
										<?= $entry_all_manufacturer; ?>
									</option>
									<?php foreach ($manufacturers as $manufacturer) { ?>
									<?php if ($manufacturer['manufacturer_id']==$filter_manufacturer) { ?>
									<option value="<?= $manufacturer['manufacturer_id']; ?>" selected="selected">
										<?= $manufacturer['name']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $manufacturer['manufacturer_id']; ?>">
										<?= $manufacturer['name']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="input-category">
									<?= $column_category; ?>
								</label>
								<select name="filter_category" id="input-category" class="form-control">
									<option value="*">
										<?= $entry_all_category; ?>
									</option>
									<?php foreach ($categories as $category) { ?>
									<?php if ($category['category_id']==$filter_category) { ?>
									<option value="<?= $category['category_id']; ?>" selected="selected">
										<?= $category['name']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $category['category_id']; ?>">
										<?= $category['name']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label" for="input-status">
									<?= $entry_status; ?>
								</label>
								<select name="filter_status" id="input-status" class="form-control">
									<option value="*"></option>
									<?php if ($filter_status) { ?>
									<option value="1" selected="selected">
										<?= $text_enabled; ?>
									</option>
									<?php } else { ?>
									<option value="1">
										<?= $text_enabled; ?>
									</option>
									<?php } ?>
									<?php if (!$filter_status && !is_null($filter_status)) { ?>
									<option value="0" selected="selected">
										<?= $text_disabled; ?>
									</option>
									<?php } else { ?>
									<option value="0">
										<?= $text_disabled; ?>
									</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="input-tag">
									<?= $entry_tag; ?>
								</label>
								<input type="text" name="filter_tag" value="<?= $filter_tag; ?>" placeholder="<?= $entry_tag; ?>"
									id="input-tag" class="form-control" />
							</div>
							<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i>
								<?= $button_filter; ?>
							</button>
						</div>
					</div>
				</div>
				<form action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form-product">
					<div class="table-responsive">
						<table class="table table-bordered table-hover text-left">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox"
											onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /><br>
										<?php if ($sort == 'p.product_id') { ?>
										<a href="<?= $sort_id; ?>" class="<?= strtolower($order); ?>">
											<?= $column_product_id; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_id; ?>">
											<?= $column_product_id; ?>
										</a>
										<?php } ?>
									</td>
									<td class="text-center">
										<?= $column_image; ?>
									</td>
									<td>
										<?php if ($sort == 'pd.name') { ?>
										<a href="<?= $sort_name; ?>" class="<?= strtolower($order); ?>">
											<?= $column_name; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_name; ?>">
											<?= $column_name; ?>
										</a>
										<?php } ?>
									</td>
									<td>
										<?php if ($sort == 'p.model') { ?>
										<a href="<?= $sort_model; ?>" class="<?= strtolower($order); ?>">
											<?= $column_model; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_model; ?>">
											<?= $column_model; ?>
										</a>
										<?php } ?>
									</td>
									<td>
										<?php if ($sort == 'pd.tag') { ?>
										<a href="<?= $sort_tag; ?>" class="<?= strtolower($order); ?>">
											<?= $column_tag; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_tag; ?>">
											<?= $column_tag; ?>
										</a>
										<?php } ?>
									</td>
									<td>
										<?php if ($sort == 'manufacturer_name') { ?>
										<a href="<?= $sort_manufacturer; ?>" class="<?= strtolower($order); ?>">
											<?= $column_manufacturer; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_manufacturer; ?>">
											<?= $column_manufacturer; ?>
										</a>
										<?php } ?>
									</td>
									<td>
										<?php if ($sort == 'p2c.category_id') { ?>
										<a href="<?= $sort_category; ?>" class="<?= strtolower($order); ?>">
											<?= $column_category; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_category; ?>">
											<?= $column_category; ?>
										</a>
										<?php } ?>
									</td>
									<td class="text-right">
										<?php if ($sort == 'p.price') { ?>
										<a href="<?= $sort_price; ?>" class="<?= strtolower($order); ?>">
											<?= $column_price; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_price; ?>">
											<?= $column_price; ?>
										</a>
										<?php } ?>
									</td>
									<td class="text-right">
										<?= $column_weight; ?>
									</td>
									<td>
										<?= $column_option; ?>
									</td>
									<td class="text-right">
										<?php if ($sort == 'p.quantity') { ?>
										<a href="<?= $sort_quantity; ?>" class="<?= strtolower($order); ?>">
											<?= $column_quantity; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_quantity; ?>">
											<?= $column_quantity; ?>
										</a>
										<?php } ?>
									</td>
									<td>
										<?php if ($sort == 'p.date_modified') { ?>
										<a href="<?= $sort_date_modified; ?>" class="<?= strtolower($order); ?>">
											<?= $column_date_modified; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_date_modified; ?>">
											<?= $column_date_modified; ?>
										</a>
										<?php } ?>
									</td>
									<td>
										<?php if ($sort == 'p.status') { ?>
										<a href="<?= $sort_status; ?>" class="<?= strtolower($order); ?>">
											<?= $column_status; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_status; ?>">
											<?= $column_status; ?>
										</a>
										<?php } ?>
									</td>
									<td class="text-right">
										<?= $column_action; ?>
									</td>
								</tr>
							</thead>
							<tbody>
								<?php if ($products) { ?>
								<?php foreach ($products as $product) { ?>
								<tr>
									<td class="text-center">
										<?php if (in_array($product['product_id'], $selected)) { ?>
										<input type="checkbox" name="selected[]" value="<?= $product['product_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?= $product['product_id']; ?>" />
										<?php } ?><br>
										<?= $product['product_id']; ?>
									</td>
									<td class="text-center">
										<?php if ($product['image']) { ?>
										<img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>" class="img-thumbnail" />
										<?php } else { ?>
										<span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
										<?php } ?>
									</td>
									<td>
										<?= $product['name']; ?>
									</td>
									<td>
										<?= $product['model']; ?>
									</td>
									<td>
										<?= $product['tag']; ?>
									</td>
									<td>
										<?= $product['manufacturer'];?>
									</td>
									<td>
										<?php foreach ($categories as $category) { ?>
										<?php if (in_array($category['category_id'], $product['category'])) { ?>
										<?= $category['name'];?><br>
										<?php } ?>
										<?php } ?>
									</td>
									<td class="text-right">
										<?php if ($product['special']) { ?>
										<span style="text-decoration: line-through;">
											<?= $product['price']; ?>
										</span><br />
										<div class="text-danger">
											<?= $product['special']; ?>
										</div>
										<?php } else { ?>
										<?= $product['price']; ?>
										<?php } ?>
									</td>
									<td class="text-right">
										<?= $product['weight']; ?>
									</td>
									<td>
										<?php foreach ($product['option'] as $option) { ?>
										<?= $option; ?><br>
										<?php } ?>
									</td>
									<td class="text-right">
										<?php if ($product['quantity'] <= 0) { ?>
										<span class="label label-warning">
											<?= $product['quantity']; ?>
										</span>
										<?php } elseif ($product['quantity'] <= 5) { ?>
										<span class="label label-danger">
											<?= $product['quantity']; ?>
										</span>
										<?php } else { ?>
										<span class="label label-success">
											<?= $product['quantity']; ?>
										</span>
										<?php } ?>
									</td>
									<td>
										<?= $product['date_modified']; ?>
									</td>
									<td>
										<?= $product['status']; ?>
									</td>
									<td class="text-right"><a href="<?= $product['edit']; ?>" data-toggle="tooltip"
											title="<?= $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td class="text-center" colspan="14">
										<?= $text_no_results; ?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-6 text-left">
						<?= $pagination; ?>
					</div>
					<div class="col-sm-6 text-right">
						<?= $results; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).keypress(function (e) {
			if (e.which == 13) {
				$("#button-filter").click();
			}
		});
		$('#button-filter').on('click', function () {
			var url = 'index.php?route=catalog/product&token=<?= $token; ?>';

			var filter_name = $('input[name=\'filter_name\']').val();

			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}

			var filter_tag = $('input[name=\'filter_tag\']').val();

			if (filter_tag) {
				url += '&filter_tag=' + encodeURIComponent(filter_tag);
			}

			var filter_model = $('input[name=\'filter_model\']').val();

			if (filter_model) {
				url += '&filter_model=' + encodeURIComponent(filter_model);
			}

			var filter_tag = $('input[name=\'filter_tag\']').val();

			if (filter_tag) {
				url += '&filter_tag=' + encodeURIComponent(filter_tag);
			}

			var filter_manufacturer = $('select[name=\'filter_manufacturer\']').val();

			if (filter_manufacturer != '*') {
				url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
			}

			var filter_category = $('select[name=\'filter_category\']').val();

			if (filter_category != '*') {
				url += '&filter_category=' + encodeURIComponent(filter_category);
			}

			var filter_price = $('input[name=\'filter_price\']').val();

			if (filter_price) {
				url += '&filter_price=' + encodeURIComponent(filter_price);
			}

			var filter_quantity = $('input[name=\'filter_quantity\']').val();

			if (filter_quantity) {
				url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
			}

			var filter_status = $('select[name=\'filter_status\']').val();

			if (filter_status != '*') {
				url += '&filter_status=' + encodeURIComponent(filter_status);
			}

			location = url;
		});
	</script>
	<script type="text/javascript">
		$('input[name=\'filter_name\']').autocomplete({
			'source': function (request, response) {
				$.ajax({
					url: 'index.php?route=catalog/product/autocomplete&token=<?= $token; ?>&filter_name=' + encodeURIComponent(request),
					dataType: 'json',
					success: function (json) {
						response($.map(json, function (item) {
							return {
								label: item['name'],
								value: item['product_id']
							}
						}));
					}
				});
			},
			'select': function (item) {
				$('input[name=\'filter_name\']').val(item['label']);
			}
		});

		$('input[name=\'filter_model\']').autocomplete({
			'source': function (request, response) {
				$.ajax({
					url: 'index.php?route=catalog/product/autocomplete&token=<?= $token; ?>&filter_model=' + encodeURIComponent(request),
					dataType: 'json',
					success: function (json) {
						response($.map(json, function (item) {
							return {
								label: item['model'],
								value: item['product_id']
							}
						}));
					}
				});
			},
			'select': function (item) {
				$('input[name=\'filter_model\']').val(item['label']);
			}
		});
	</script>
</div>
<?= $footer; ?>