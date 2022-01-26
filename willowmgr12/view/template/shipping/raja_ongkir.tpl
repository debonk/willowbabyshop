<?= $header; ?>
<?= $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-raja-ongkir" data-toggle="tooltip" title="<?= $button_save; ?>"
					class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?= $cancel; ?>" data-toggle="tooltip" title="<?= $button_cancel; ?>" class="btn btn-default"><i
						class="fa fa-reply"></i></a>
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
		<?php if (isset($information)) { ?>
		<div class="alert alert-info"><i class="fa fa-information"></i>
			<?= $information; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
			<?= $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i>
					<?= $text_edit; ?>
				</h3>
			</div>
			<div class="panel-body">
				<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-raja-ongkir"
					class="form-horizontal">
					<fieldset>
						<legend>
							<?= $text_credential; ?>
						</legend>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?= $entry_account_type; ?>
							</label>
							<div class="col-sm-10">
								<select name="raja_ongkir_account_type" id="input-account-type" class="form-control">
									<?php foreach ($accounts as $account) { ?>
									<?php if ($account['value'] == $raja_ongkir_account_type) { ?>
									<option value="<?= $account['value']; ?>" selected="selected">
										<?= $account['text']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $account['value']; ?>">
										<?= $account['text']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-api-key"><span data-toggle="tooltip"
									title="<?= $help_api_key; ?>">
									<?= $entry_api_key; ?>
								</span></label>
							<div class="col-sm-10">
								<input type="text" name="raja_ongkir_api_key" value="<?= $raja_ongkir_api_key; ?>"
									placeholder="<?= $entry_api_key; ?>" id="input-api-key" class="form-control" />
								<?php if ($error_api_key) { ?>
								<div class="text-danger">
									<?= $error_api_key; ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-base-url"><span data-toggle="tooltip"
									title="<?= $help_base_url; ?>">
									<?= $entry_base_url; ?>
								</span></label>
							<div class="col-sm-10">
								<input type="text" name="raja_ongkir_base_url" value="<?= $raja_ongkir_base_url; ?>"
									placeholder="<?= $help_base_url; ?>" id="input-base-url" class="form-control" readonly />
								<?php if ($error_base_url) { ?>
								<div class="text-danger">
									<?= $error_base_url; ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2 control-label"></div>
							<div class="col-sm-10">
								<button type="submit" form="form-raja-ongkir" id="button-account" class="btn btn-primary">
									<?= $button_account; ?>
								</button>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>
							<?= $text_origin; ?>
						</legend>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?= $button_cache_delete; ?>
							</label>
							<div class="col-sm-10">
								<button type="button" id="button-cache-delete" class="btn btn-info">
									<?= $button_cache_delete; ?>
								</button>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-province">
								<?= $entry_province; ?>
							</label>
							<div class="col-sm-10">
								<select name="raja_ongkir_province_id" id="input-province" class="form-control">
									<option value="0">
										<?= $text_select; ?>
									</option>
									<?php foreach ($provinces as $province) { ?>
									<?php if ($province['province_id'] == $raja_ongkir_province_id) { ?>
									<option value="<?= $province['province_id']; ?>" selected="selected">
										<?= $province['province']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $province['province_id']; ?>">
										<?= $province['province']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								</select>
								<?php if ($error_province) { ?>
								<div class="text-danger">
									<?= $error_province; ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-city">
								<?= $entry_city; ?>
							</label>
							<div class="col-sm-10">
								<select name="raja_ongkir_city_id" id="input-city" class="form-control">
									<option value="0">
										<?= $text_select; ?>
									</option>
									<?php foreach ($origin_cities as $city) { ?>
									<?php if ($city['city_id'] == $raja_ongkir_city_id) { ?>
									<option value="<?= $city['city_id']; ?>" selected="selected">
										<?= $city['city_name']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $city['city_id']; ?>">
										<?= $city['type'] . ' ' . city['city_name']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								</select>
								<?php if ($error_city) { ?>
								<div class="text-danger">
									<?= $error_city; ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-subdistrict">
								<?= $entry_subdistrict; ?>
							</label>
							<div class="col-sm-10">
								<select name="raja_ongkir_subdistrict_id" id="input-subdistrict" class="form-control">
									<?php if (isset($origin['subdistrict_id'])) { ?>
									<option value="0">
										<?= $text_select; ?>
									</option>
									<option value="<?= $origin['subdistrict_id']; ?>" selected="selected">
										<?= $origin['subdistrict_name']; ?>
									</option>
									<?php } else { ?>
									<option value="0">
										<?= $text_none; ?>
									</option>

									<?php } ?>
								</select>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>
							<?= $text_general; ?>
						</legend>
						<div class="form-group">
							<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?= $help_courier; ?>">
									<?= $entry_courier; ?>
								</span></label>
							<div class="col-sm-10">
								<div id="courier" class="well well-sm" style="height: 150px; overflow: auto;">
									<?php foreach ($couriers as $courier) { ?>
									<div class="checkbox col-sm-6 col-md-4 col-lg-3">
										<label>
											<?php if (in_array($courier['code'], $raja_ongkir_courier)) { ?>
											<input type="checkbox" name="raja_ongkir_courier[]" value="<?= $courier['code']; ?>"
												id="courier<?= $courier['code']; ?>" checked="checked" />
											<?= $courier['text']; ?>
											<?php } else { ?>
											<input type="checkbox" name="raja_ongkir_courier[]" value="<?= $courier['code']; ?>"
												id="courier<?= $courier['code']; ?>" />
											<?= $courier['text']; ?>
											<?php } ?>
										</label>
									</div>
									<?php } ?>
								</div>
								<a onclick="$(this).parent().find(':checkbox').prop('checked', true);">
									<?= $text_select_all; ?>
								</a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">
									<?= $text_unselect_all; ?>
								</a>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?= $help_service; ?>">
									<?= $entry_service; ?>
								</span></label>
							<div class="col-sm-10">
								<div id="courier" class="well well-sm" style="height: 350px; overflow: auto;">
									<?php foreach ($couriers as $courier) { ?>
									<div class="col-sm-6 col-md-4 col-lg-3">
										<div class="pt-6">
											<strong><?= $courier['text']; ?></strong>
											<?php foreach ($courier['services'] as $service) { ?>
											<div class="checkbox">
												<label>
													<?php if (in_array($service['code'], $raja_ongkir_service)) { ?>
													<input type="checkbox" name="raja_ongkir_service[]" value="<?= $service['code']; ?>"
														id="service<?= $service['code']; ?>" checked="checked" />
													<?= $service['text']; ?>
													<?php } else { ?>
													<input type="checkbox" name="raja_ongkir_service[]" value="<?= $service['code']; ?>"
														id="service<?= $service['code']; ?>" />
													<?= $service['text']; ?>
													<?php } ?>
												</label>
											</div>
											<?php } ?>
										</div>
									</div>
									<?php } ?>
								</div>
								<a onclick="$(this).parent().find(':checkbox').prop('checked', true);">
									<?= $text_select_all; ?>
								</a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">
									<?= $text_unselect_all; ?>
								</a>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-weight-class">
								<?= $entry_weight_class; ?>
							</label>
							<div class="col-sm-10">
								<select name="raja_ongkir_weight_class_id" id="input-weight-class" class="form-control">
									<?php foreach ($weight_classes as $weight_class) { ?>
									<?php if ($weight_class['weight_class_id'] == $raja_ongkir_weight_class_id) { ?>
									<option value="<?= $weight_class['weight_class_id']; ?>" selected="selected">
										<?= $weight_class['title']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $weight_class['weight_class_id']; ?>">
										<?= $weight_class['title']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								</select>
								<?php if ($error_weight_class) { ?>
								<div class="text-danger">
									<?= $error_weight_class; ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-tax-class">
								<?= $entry_tax_class; ?>
							</label>
							<div class="col-sm-10">
								<select name="raja_ongkir_tax_class_id" id="input-tax-class" class="form-control">
									<option value="0">
										<?= $text_none; ?>
									</option>
									<?php foreach ($tax_classes as $tax_class) { ?>
									<?php if ($tax_class['tax_class_id'] == $raja_ongkir_tax_class_id) { ?>
									<option value="<?= $tax_class['tax_class_id']; ?>" selected="selected">
										<?= $tax_class['title']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $tax_class['tax_class_id']; ?>">
										<?= $tax_class['title']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-geo-zone">
								<?= $entry_geo_zone; ?>
							</label>
							<div class="col-sm-10">
								<select name="raja_ongkir_geo_zone_id" id="input-geo-zone" class="form-control">
									<option value="0">
										<?= $text_all_zones; ?>
									</option>
									<?php foreach ($geo_zones as $geo_zone) { ?>
									<?php if ($geo_zone['geo_zone_id'] == $raja_ongkir_geo_zone_id) { ?>
									<option value="<?= $geo_zone['geo_zone_id']; ?>" selected="selected">
										<?= $geo_zone['name']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $geo_zone['geo_zone_id']; ?>">
										<?= $geo_zone['name']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-status">
								<?= $entry_status; ?>
							</label>
							<div class="col-sm-10">
								<select name="raja_ongkir_status" id="input-status" class="form-control">
									<?php if ($raja_ongkir_status) { ?>
									<option value="1" selected="selected">
										<?= $text_enabled; ?>
									</option>
									<option value="0">
										<?= $text_disabled; ?>
									</option>
									<?php } else { ?>
									<option value="1">
										<?= $text_enabled; ?>
									</option>
									<option value="0" selected="selected">
										<?= $text_disabled; ?>
									</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-sort-order">
								<?= $entry_sort_order; ?>
							</label>
							<div class="col-sm-10">
								<input type="text" name="raja_ongkir_sort_order" value="<?= $raja_ongkir_sort_order; ?>"
									placeholder="<?= $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('select[name=\'raja_ongkir_account_type\']').on('change', function () {
			$('input[name=\'raja_ongkir_base_url\']').val('');
		});

		$('#button-cache-delete').on('click', function () {
			$.ajax({
				url: 'index.php?route=shipping/raja_ongkir/deleteCache&token=<?= $token; ?>',
				dataType: 'json',
				beforeSend: function () {
					$('#button-cache-delete').button('loading');
				},
				complete: function () {
					$('#button-cache-delete').button('reset');
				},
				success: function (json) {
					$('.alert').remove();

					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
					}

					if (json['cache_deleted']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' + json['cache_deleted'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$('select[name=\'raja_ongkir_province_id\']').on('change', function () {
			let province_id = $('select[name=\'raja_ongkir_province_id\']').val();

			$.ajax({
				url: 'index.php?route=shipping/raja_ongkir/city&token=<?= $token; ?>&province_id=' + province_id,
				type: 'get',
				dataType: 'json',
				beforeSend: function () {
					$('label[for=\'input-province\']').append(' <i class="fa fa-circle-o-notch fa-spin"></i>');
				},
				complete: function () {
					$('.fa-spin').remove();
				},
				success: function (json) {
					$('.alert:not(.alert-info)').remove();

					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
					}

					if (json['html']) {
						$('select[name=\'raja_ongkir_city_id\']').html(json['html']);

						$('select[name=\'raja_ongkir_city_id\']').trigger('change');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$('select[name=\'raja_ongkir_province_id\']').trigger('change');

		$('select[name=\'raja_ongkir_city_id\']').on('change', function () {
			let pro = '<?= $raja_ongkir_account_type; ?>' == 'pro';

			if (pro) {
				let city_id = $('select[name=\'raja_ongkir_city_id\']').val();

				$.ajax({
					url: 'index.php?route=shipping/raja_ongkir/subdistrict&token=<?= $token; ?>&city_id=' + city_id,
					type: 'get',
					dataType: 'json',
					beforeSend: function () {
						$('label[for=\'input-city\']').append(' <i class="fa fa-circle-o-notch fa-spin"></i>');
					},
					complete: function () {
						$('.fa-spin').remove();
					},
					success: function (json) {
						$('.alert:not(.alert-info)').remove();

						if (json['error']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
						}

						if (json['html']) {
							$('select[name=\'raja_ongkir_subdistrict_id\']').html(json['html']);
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}
		});

		$('input[id^=\'courier\']').on('click', function () {
			$('input[id^=\'service' + this.value + '\']').prop('checked', this.checked);
		});

	</script>
</div>
<?= $footer; ?>