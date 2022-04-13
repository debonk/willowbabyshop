<?php if ($error_option_model) { ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
	<?= $error_option_model; ?>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php } ?>

<div class="form-group">
	<div class="col-sm-3">
		<input type="text" name="multiple" value="" placeholder="<?= $entry_multiple; ?>" id="input-multiple"
			class="form-control" />
	</div>
	<!-- <div class="col-sm-9">
	</div> -->
</div>
<!-- <div class="col-sm-12">
		<ul class="list-group list-group-horizontal" id="multiple-option">
			<?php $multiple_column = 0; ?>
			<?php foreach ($product_options as $product_option) { ?>
			<li><a href="#tab-option<?= $multiple_column; ?>" data-toggle="tab"><i class="fa fa-minus-circle"
						onclick="$('a[href=\'#tab-option<?= $multiple_column; ?>\']').parent().remove(); $('#tab-option<?= $multiple_column; ?>').remove(); $('#option a:first').tab('show');"></i>
					<?= $product_option['name']; ?>
				</a></li>
			<?php $multiple_column++; ?>
			<?php } ?> -->
<!-- <li>
				<input type="text" name="multiple" value="" placeholder="<?= $entry_multiple; ?>" id="input-multiple"
					class="form-control" />
			</li> -->
<!-- </ul>
	</div> -->
<?php $multiple_column = 0; ?>
<?php $multiple_row = 0; ?>
<div class="col-sm-12">
	<div class="tab-content">
		<div class="table-responsive">
			<table id="multiple-table" class="table table-striped table-bordered table-hover text-left">
				<!-- <table class="table table-striped table-bordered table-hover text-left"> -->
				<thead>
					<tr>
						<td>
							<?= $entry_image; ?>
						</td>
						<td class="required" id="label-sku">
							<?= $entry_sku; ?>
						</td>
						<td class="text-right">
							<?= $entry_quantity; ?>
						</td>
						<td class="text-right required">
							<?= $entry_price; ?>
						</td>
						<td class="text-right">
							<?= $entry_option_points; ?>
						</td>
						<td class="text-right required">
							<?= $entry_weight; ?>
						</td>
						<td class="text-right">
							<?= $entry_weight_class; ?>
							<select id="weight-classes" style="display: ;">
							<?php foreach($weight_classes as $weight_class) { ?>
								<option value="<?= $weight_class['weight_class_id'] ?>" <?= ($weight_class['weight_class_id'] == $weight_class_id) ? 'selected' : '' ?>><?= $weight_class['title']; ?></option>
							<?php } ?>
						</select>
						</td>
						<td class="text-right">
							<?= $entry_action; ?>
						</td>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td colspan="6"></td>
						<td class="text-right"><button type="button" onclick="addMultipleValue();" data-toggle="tooltip"
								title="<?= $button_option_value_add; ?>" class="btn btn-primary"><i
									class="fa fa-plus-circle"></i></button></td>
					</tr>

				</tfoot>
			</table>

			<!-- <div class="tab-pane" id="tab-option' + multiple_column + '">
				<?php $multiple_column = 0; ?>
				<?php $multiple_row = 0; ?>
				<?php foreach ($product_options as $product_option) { ?>
				<div class="tab-pane" id="tab-option<?= $multiple_column; ?>">
					<input type="" name="product_option[<?= $multiple_column; ?>][product_option_id]"
						value="<?= $product_option['product_option_id']; ?>" />
					<input type="" name="product_option[<?= $multiple_column; ?>][name]" value="<?= $product_option['name']; ?>" />
					<input type="" name="product_option[<?= $multiple_column; ?>][option_id]"
						value="<?= $product_option['option_id']; ?>" />
					<input type="" name="product_option[<?= $multiple_column; ?>][type]" value="<?= $product_option['type']; ?>" />
					<?php if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
					<div class="table-responsive">
						<table id="option-value<?= $multiple_column; ?>" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<td>
										<?= $entry_option_value; ?>
									</td>
									<td class="text-left required">
										<?= $entry_model; ?>
									</td>
									<td class="text-right">
										<?= $entry_quantity; ?>
									</td>
									<td>
										<?= $entry_subtract; ?>
									</td>
									<td class="text-right">
										<?= $entry_price; ?>
									</td>
									<td class="text-right">
										<?= $entry_option_points; ?>
									</td>
									<td class="text-right">
										<?= $entry_weight; ?>
									</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
								<tr id="option-value-row<?= $multiple_row; ?>">
									<td><select
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][option_value_id]"
											class="form-control">
											<?php if (isset($option_values[$product_option['option_id']])) { ?>
											<?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
											<?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
											<option value="<?= $option_value['option_value_id']; ?>" selected="selected">
												<?= $option_value['name']; ?>
											</option>
											<?php } else { ?>
											<option value="<?= $option_value['option_value_id']; ?>">
												<?= $option_value['name']; ?>
											</option>
											<?php } ?>
											<?php } ?>
											<?php } ?>
										</select>
										<input type="hidden"
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][product_option_value_id]"
											value="<?= $product_option_value['product_option_value_id']; ?>" />
									</td>
									<td><input type="text"
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][model]"
											value="<?= $product_option_value['model']; ?>" placeholder="<?= $entry_model; ?>"
											class="form-control" /></td>
									<td class="text-right"><input type="text"
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][quantity]"
											value="<?= $product_option_value['quantity']; ?>" placeholder="<?= $entry_quantity; ?>"
											class="form-control" /></td>
									<td><select
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][subtract]"
											class="form-control">
											<?php if ($product_option_value['subtract']) { ?>
											<option value="1" selected="selected">
												<?= $text_yes; ?>
											</option>
											<option value="0">
												<?= $text_no; ?>
											</option>
											<?php } else { ?>
											<option value="1">
												<?= $text_yes; ?>
											</option>
											<option value="0" selected="selected">
												<?= $text_no; ?>
											</option>
											<?php } ?>
										</select></td>
									<td class="text-right"><select
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][price_prefix]"
											class="form-control">
											<?php if ($product_option_value['price_prefix'] == '+') { ?>
											<option value="+" selected="selected">+</option>
											<?php } else { ?>
											<option value="+">+</option>
											<?php } ?>
											<?php if ($product_option_value['price_prefix'] == '-') { ?>
											<option value="-" selected="selected">-</option>
											<?php } else { ?>
											<option value="-">-</option>
											<?php } ?>
										</select>
										<input type="text"
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][price]"
											value="<?= $product_option_value['price']; ?>" placeholder="<?= $entry_price; ?>"
											class="form-control" />
									</td>
									<td class="text-right"><select
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][points_prefix]"
											class="form-control">
											<?php if ($product_option_value['points_prefix'] == '+') { ?>
											<option value="+" selected="selected">+</option>
											<?php } else { ?>
											<option value="+">+</option>
											<?php } ?>
											<?php if ($product_option_value['points_prefix'] == '-') { ?>
											<option value="-" selected="selected">-</option>
											<?php } else { ?>
											<option value="-">-</option>
											<?php } ?>
										</select>
										<input type="text"
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][points]"
											value="<?= $product_option_value['points']; ?>" placeholder="<?= $entry_points; ?>"
											class="form-control" />
									</td>
									<td class="text-right"><select
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][weight_prefix]"
											class="form-control">
											<?php if ($product_option_value['weight_prefix'] == '+') { ?>
											<option value="+" selected="selected">+</option>
											<?php } else { ?>
											<option value="+">+</option>
											<?php } ?>
											<?php if ($product_option_value['weight_prefix'] == '-') { ?>
											<option value="-" selected="selected">-</option>
											<?php } else { ?>
											<option value="-">-</option>
											<?php } ?>
										</select>
										<input type="text"
											name="product_option[<?= $multiple_column; ?>][product_option_value][<?= $multiple_row; ?>][weight]"
											value="<?= $product_option_value['weight']; ?>" placeholder="<?= $entry_weight; ?>"
											class="form-control" />
									</td>
									<td><button type="button"
											onclick="$(this).tooltip('destroy');$('#option-value-row<?= $multiple_row; ?>').remove();"
											data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i
												class="fa fa-minus-circle"></i></button></td>
								</tr>
								<?php $multiple_row++; ?>
								<?php } ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="7"></td>
									<td><button type="button" onclick="addOptionValue('<?= $multiple_column; ?>');" data-toggle="tooltip"
											title="<?= $button_option_value_add; ?>" class="btn btn-primary"><i
												class="fa fa-plus-circle"></i></button></td>
								</tr>
							</tfoot>
						</table>
					</div>
					<select id="option-values<?= $multiple_column; ?>" style="display: none;">
						<?php if (isset($option_values[$product_option['option_id']])) { ?>
						<?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
						<option value="<?= $option_value['option_value_id']; ?>">
							<?= $option_value['name']; ?>
						</option>
						<?php } ?>
						<?php } ?>
					</select>
					<?php } ?>
				</div>
				<?php $multiple_column++; ?>
				<?php } ?>
			</div> -->
		</div>
	</div>

	<script type="text/javascript">
		let multiple_column = '<?= $multiple_column; ?>';

		$(document).ready(function () {
			$('input[name=\'multiple\']').autocomplete({
				'source': function (request, response) {
					$.ajax({
						url: 'index.php?route=catalog/option/autocomplete&token=<?= $token; ?>&filter_selection_only=1&filter_name=' + encodeURIComponent(request),
						dataType: 'json',
						success: function (json) {
							response($.map(json, function (item) {
								return {
									category: item['category'],
									label: item['name'],
									value: item['option_id'],
									type: item['type'],
									option_value: item['option_value']
								}
							}));
						}
					});
				},
				'select': function (item) {
					// html = '';
					// html = '<div class="tab-pane" id="tab-multiple' + multiple_column + '">';
					// html = '	<input type="" name="product_option[' + multiple_column + '][product_option_id]" value="" />';
					// html += '	<input type="" name="product_option[' + multiple_column + '][name]" value="' + item['label'] + '" />';
					// $('#tab-multiple .tab-content').append(html);

					html = '';

					html += '  <td class="multiple-option' + multiple_column + '">';
					html += '  <div class="btn-primary btn-xs" id="multiple-option' + multiple_column + '" data-column="' + multiple_column + '"><i class="fa fa-minus-circle" onclick="deleteMultipleOption(' + multiple_column + ');" data-toggle="tooltip" title="<?= $button_remove; ?>"></i> ' + item['label'] + '</div>';
					html += '	 <input type="" name="product_multiple[option][' + multiple_column + '][option_id]" value="' + item['value'] + '" />';
					html += '	 <input type="" name="product_multiple[option][' + multiple_column + '][type]" value="' + item['type'] + '" />';

					html += '  <select id="multiple-values' + multiple_column + '" style="display: none;">';
					for (let i = 0; i < item['option_value'].length; i++) {
						html += '  <option value="' + item['option_value'][i]['option_value_id'] + '">' + item['option_value'][i]['name'] + '</option>';
					}
					html += '  </select>';
					html += '  </td>';

					$('#tab-multiple #label-sku').before(html);
					$('#tab-multiple tfoot > tr').prepend('<td class="multiple-option' + multiple_column + '"></td>');

					// 	html += '        <td class="text-left required"><?= $entry_model ?></td>';
					// 	html += '        <td class="text-right"><?= $entry_quantity; ?></td>';
					// 	html += '        <td class="text-left"><?= $entry_subtract; ?></td>';
					// 	html += '        <td class="text-right"><?= $entry_price; ?></td>';
					// 	html += '        <td class="text-right"><?= $entry_option_points; ?></td>';
					// 	html += '        <td class="text-right"><?= $entry_weight; ?></td>';
					// 	html += '        <td></td>';
					// 	html += '      </tr>';
					// 	html += '  	 </thead>';
					// 	html += '  	 <tbody>';
					// 	html += '    </tbody>';
					// 	html += '    <tfoot>';
					// 	html += '      <tr>';
					// 	html += '        <td colspan="7"></td>';
					// 	html += '        <td class="text-left"><button type="button" onclick="addOptionValue(' + multiple_column + ');" data-toggle="tooltip" title="<?= $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
					// 	html += '      </tr>';
					// 	html += '    </tfoot>';
					// 	html += '  </table>';
					// 	html += '</div>';

					// 	html += '  <select id="option-values' + multiple_column + '" style="display: none;">';

					// 	for (i = 0; i < item['option_value'].length; i++) {
					// 		html += '  <option value="' + item['option_value'][i]['option_value_id'] + '">' + item['option_value'][i]['name'] + '</option>';
					// 	}

					// 	html += '  </select>';
					// 	html += '</div>';
					// }


					// $('#tab-multiple .tab-content').append(html);
					// $('#multiple-option').append(html);

					// $('#multiple-option').append('<div class="btn btn-primary" id="multiple-option' + multiple_column + '" value="' + multiple_column + '"><i class="fa fa-minus-circle" onclick="deleteMultipleOptionValue(' + multiple_column + ');" data-toggle="tooltip" title="<?= $button_option_delete; ?>"></i> ' + item['label'] + '</div>');

					let multiple_rows = $('[id^=\'multiple-value-row\']');

					for (let j = 0; j < multiple_rows.length; j++) {
						let row = $(multiple_rows[j]).data('row');
						html = '';
						html += '  <td class="multiple-option' + multiple_column + '"><select name="product_multiple[multiple_value][' + row + '][option_value][' + multiple_column + '][option_value_id]" class="form-control">';
						html += $('#multiple-values' + multiple_column).html();
						html += '  </select><input type="" name="product_multiple[multiple_value][' + row + '][option_value][' + multiple_column + '][product_option_value_id]" value="" /></td>';

						$('#tab-multiple #input-sku' + row).before(html);
					}


					// console.log(html);

					// for (let j of a) {
					// console.log($(multiple_rows));
					// console.log($(a[0]).attr('id'));

					// html += '    <option value="' + weight_class['weight_class_id'] + '">' + weight_class['title'] + '</option>';
					// }

					// $('#multiple-option > li:last-child').before('<li class="col-sm-3 btn btn-primary" value="' + item['value'] + '"><i class="fa fa-minus-circle" onclick="$(this).parent().remove();"></i> ' + item['label'] + '</li>');
					// $('#multiple-option > li:last-child').before('<li class="btn btn-primary" value="' + item['value'] + '"><i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-multiple' + multiple_column + '\\\']\').parent().remove(); $(\'#tab-multiple' + multiple_column + '\').remove(); $(\'#option a:first\').tab(\'show\')"></i> ' + item['label'] + '</div>');

					// $('#multiple a[href=\'#tab-multiple' + multiple_column + '\']').tab('show');

					$('[data-toggle=\'tooltip\']').tooltip({
						container: 'body',
						html: true
					});

					multiple_column++;
				}
			});
		});
	</script>
	<script type="text/javascript">
		function deleteMultipleOption(multiple_column) {
			// $('[id=\'multiple-option' + multiple_column + '\']').remove();
			$('[class^=\'multiple-option' + multiple_column + '\']').remove();
		}
	</script>
	<script type="text/javascript">
		let multiple_row = '<?= $multiple_row; ?>';
		let weight_classes = JSON.parse('<?= $json_weight_classes; ?>')

		function addMultipleValue() {
			html = ''
			html += '<tr id="multiple-value-row' + multiple_row + '" data-row="' + multiple_row + '">';
			html += '  <td><a href="" id="thumb-image' + multiple_row + '" data-toggle="image" class="img-thumbnail"><img src="<?= $placeholder; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a><input type="" name="product_multiple[multiple_value][' + multiple_row + '][image]" value="" id="input-image' + option_value_row + '" /></td>';

			let multiple_columns = $('[id^=\'multiple-option\']');

			for (let k = 0; k < multiple_columns.length; k++) {
				let column = $(multiple_columns[k]).data('column');

				html += '  <td class="multiple-option' + column + '"><select name="product_multiple[multiple_value][' + multiple_row + '][option_value][' + column + '][option_value_id]" class="form-control">';
				html += $('#multiple-values' + column).html();
				html += '  </select><input type="" name="product_multiple[multiple_value][' + multiple_row + '][option_value][' + column + '][product_option_value_id]" value="" /></td>';
			}

			html += '  <td id="input-sku' + multiple_row + '"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][sku]" value="" placeholder="<?= $entry_sku; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][quantity]" value="" placeholder="<?= $entry_quantity; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][price]" value="" placeholder="<?= $entry_price; ?>" class="form-control" /></td>';
			html += '  <td class="text-rigth"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][option_points]" value="" placeholder="<?= $entry_option_points; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][weight]" value="" placeholder="<?= $entry_weight; ?>" class="form-control" /></td>';
			html += '  <td><select name="product_multiple[multiple_value][' + multiple_row + '][weight_class_id]" class="form-control">';
			html += $('#weight-classes').html();

			// for (let weight_class of weight_classes) {
			// 	html += '    <option value="' + weight_class['weight_class_id'] + '">' + weight_class['title'] + '</option>';
			// }

			html += '    </select>';
			html += '  </td>';
			html += '  <td><button type="button" onclick="$(this).tooltip(\'destroy\');$(this).closest(\'tr\').remove();" data-toggle="tooltip" rel="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';

			$('#multiple-table tbody').append(html);
			$('[rel=tooltip]').tooltip();

			multiple_row++;
		}
	</script>
	<!-- <script type="text/javascript">
		$('#language a:first').tab('show');
		$('#option a:first').tab('show');
	</script> -->
</div>