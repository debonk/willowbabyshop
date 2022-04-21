<div class="form-group">
	<div class="col-sm-3">
		<input type="text" name="multiple" value="" placeholder="<?= $entry_multiple; ?>" id="input-multiple"
			class="form-control" />
	</div>
</div>
<div>
	<div class="tab-content">
		<div class="table-responsive">
			<table id="table-product-multiple" class="table table-striped table-bordered table-hover text-left">
				<thead>
					<tr>
						<td>
							<?= $entry_image; ?>
						</td>
						<?php foreach($product_multiples['option'] as $column => $product_option) { ?>
						<td class="multiple-option<?= $column; ?> bg-primary">
							<div id="multiple-option<?= $column; ?>" data-column="<?= $column; ?>"><i
									class="fa fa-minus-circle" onclick="deleteMultipleOption('<?= $column; ?>');" data-toggle="tooltip"
									title="<?= $button_remove; ?>"></i>
								<?= $product_option['name']; ?>
							</div>
							<input type="hidden" name="product_multiple[option][<?= $column; ?>]"
								value="<?= $product_option['option_id']; ?>" />
							<select id="multiple-values<?= $column; ?>" style="display: none;">
								<?php foreach($product_option['option_value'] as $option_value) { ?>
								<option value="<?= $option_value['option_value_id']; ?>">
									<?= $option_value['name']; ?>
								</option>
								<?php } ?>
							</select>
						</td>
						<?php } ?>
						<td class="required" id="label-model">
							<?= $entry_model; ?>
						</td>
						<td class="text-right">
							<?= $entry_quantity; ?>
						</td>
						<td class="text-right">
							<?= $entry_price; ?>
						</td>
						<td class="text-right">
							<?= $entry_points; ?>
						</td>
						<td class="text-right">
							<?= $entry_weight; ?>
						</td>
						<td class="text-right">
							<?= $entry_weight_class; ?>
						</td>
						<td class="text-right">
							<?= $entry_action; ?>
						</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($product_multiples['multiple_value'] as $row => $multiple_value) { ?>
					<tr id="multiple-value-row<?= $row; ?>" data-row="<?= $row; ?>">
						<td><a href="" id="thumb-image<?= $row; ?>" data-toggle="image" class="img-thumbnail"><img
									src="<?= $multiple_value['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a><input
								type="hidden" name="product_multiple[multiple_value][<?= $row; ?>][image]"
								value="<?= $multiple_value['image']; ?>" id="input-image<?= $row; ?>" /></td>
						<?php foreach($multiple_value['option_value_id'] as $column => $option_value_id) { ?>
						<td class="multiple-option<?= $column; ?>"><select
								name="product_multiple[multiple_value][<?= $row; ?>][option_value_id][<?= $column; ?>]"
								class="form-control">
								<?php foreach($product_multiples['option'][$column]['option_value'] as $option_value) { ?>
								<option value="<?= $option_value['option_value_id']; ?>"
									<?=($option_value['option_value_id']==$multiple_value['option_value_id'][$column]) ? 'selected' : ''
									?>>
									<?= $option_value['name']; ?>
								</option>
								<?php } ?>
							</select>
						</td>
						<?php } ?>
						<td id="input-model<?= $row; ?>"><input type="text"
								name="product_multiple[multiple_value][<?= $row; ?>][model]" value="<?= $multiple_value['model']; ?>"
								placeholder="<?= $entry_model; ?>" class="form-control" /></td>
						<td class="text-right"><input type="text" name="product_multiple[multiple_value][<?= $row; ?>][quantity]"
								value="<?= $multiple_value['quantity']; ?>" placeholder="<?= $entry_quantity; ?>"
								class="form-control" /></td>
						<td class="text-right"><input type="text" name="product_multiple[multiple_value][<?= $row; ?>][price]"
								value="<?= $multiple_value['price']; ?>" placeholder="<?= $entry_price; ?>" class="form-control" id="input-price<?= $row; ?>" /></td>
						<td class="text-rigth"><input type="text" name="product_multiple[multiple_value][<?= $row; ?>][points]"
								value="<?= $multiple_value['points']; ?>" placeholder="<?= $entry_points; ?>" class="form-control" id="input-points<?= $row; ?>" />
						</td>
						<td class="text-right"><input type="text" name="product_multiple[multiple_value][<?= $row; ?>][weight]"
								value="<?= $multiple_value['weight']; ?>" placeholder="<?= $entry_weight; ?>" class="form-control" id="input-weight<?= $row; ?>" />
						</td>
						<td><select name="product_multiple[multiple_value][<?= $row; ?>][weight_class_id]" class="form-control"
								id="weight-classes<?= $row; ?>">
								<?php foreach($weight_classes as $weight_class) { ?>
								<option value="<?= $weight_class['weight_class_id'] ?>"
									<?=($weight_class['weight_class_id']==$multiple_value['weight_class_id']) ? 'selected' : '' ?>>
									<?= $weight_class['title']; ?>
								</option>
								<?php } ?>
							</select>
						</td>
						<td class="text-right">
							<?php if ($row) { ?>
							<button type="button" onclick="$(this).tooltip('destroy');$(this).closest('tr').remove();"
								data-toggle="tooltip" rel="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i
									class="fa fa-minus-circle"></i></button>
							<?php } ?>

						</td>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<?php foreach($multiple_value['option_value_id'] as $column => $option_value_id) { ?>
						<td class="multiple-option<?= $column; ?>"></td>
						<?php } ?>
						<td colspan="6"></td>
						<td class="text-right"><button type="button" onclick="addMultipleValue();" data-toggle="tooltip"
								title="<?= $button_option_value_add; ?>" class="btn btn-primary"><i
									class="fa fa-plus-circle"></i></button></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

	<script type="text/javascript">
		let multiple_column = '<?= $option_count; ?>';

		if (multiple_column == 0) {
			$('#table-product-multiple tfoot').hide();
		}

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
					$('#table-product-multiple tfoot').show();

					html = '';
					html += '  <td class="multiple-option' + multiple_column + ' bg-primary">';
					html += '  <div id="multiple-option' + multiple_column + '" data-column="' + multiple_column + '"><i class="fa fa-minus-circle" onclick="deleteMultipleOption(' + multiple_column + ');" data-toggle="tooltip" title="<?= $button_remove; ?>"></i> ' + item['label'] + '</div>';
					html += '	 <input type="hidden" name="product_multiple[option][' + multiple_column + ']" value="' + item['value'] + '" />';

					html += '  <select id="multiple-values' + multiple_column + '" style="display: none;">';
					for (let i = 0; i < item['option_value'].length; i++) {
						html += '  <option value="' + item['option_value'][i]['option_value_id'] + '">' + item['option_value'][i]['name'] + '</option>';
					}
					html += '  </select>';
					html += '  </td>';

					$('#tab-multiple #label-model').before(html);
					$('#tab-multiple tfoot > tr').prepend('<td class="multiple-option' + multiple_column + '"></td>');

					let multiple_rows = $('[id^=\'multiple-value-row\']');

					for (let j = 0; j < multiple_rows.length; j++) {
						let row = $(multiple_rows[j]).data('row');
						html = '';
						html += '  <td class="multiple-option' + multiple_column + '"><select name="product_multiple[multiple_value][' + row + '][option_value_id][' + multiple_column + ']" class="form-control">';
						html += $('#multiple-values' + multiple_column).html();
						html += '  </select></td>';

						$('#tab-multiple #input-model' + row).before(html);
					}

					multiple_column++;

					$('[data-toggle=\'tooltip\']').tooltip({
						container: 'body',
						html: true
					});
				}
			});
		});
	</script>
	<script type="text/javascript">
		function deleteMultipleOption(multiple_column) {
			$('[class^=\'multiple-option' + multiple_column + '\']').remove();
		}

		let multiple_row = '<?= $multiple_value_count; ?>';

		function addMultipleValue() {
			html = ''
			html += '<tr id="multiple-value-row' + multiple_row + '" data-row="' + multiple_row + '">';
			html += '  <td><a href="" id="thumb-image' + multiple_row + '" data-toggle="image" class="img-thumbnail"><img src="<?= $placeholder; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a><input type="hidden" name="product_multiple[multiple_value][' + multiple_row + '][image]" value="" id="input-image' + multiple_row + '" /></td>';

			let multiple_columns = $('[id^=\'multiple-option\']');

			for (let k = 0; k < multiple_columns.length; k++) {
				let column = $(multiple_columns[k]).data('column');

				html += '  <td class="multiple-option' + column + '"><select name="product_multiple[multiple_value][' + multiple_row + '][option_value_id][' + column + ']" class="form-control">';
				html += $('#multiple-values' + column).html();
				html += '  </select></td>';
			}

			html += '  <td id="input-model' + multiple_row + '"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][model]" value="" placeholder="<?= $entry_model; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][quantity]" value="" placeholder="<?= $entry_quantity; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][price]" value="' + $('#input-price0').val() + '" placeholder="<?= $entry_price; ?>" class="form-control" /></td>';
			html += '  <td class="text-rigth"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][points]" value="' + $('#input-points0').val() + '" placeholder="<?= $entry_points; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_multiple[multiple_value][' + multiple_row + '][weight]" value="' + $('#input-weight0').val() + '" placeholder="<?= $entry_weight; ?>" class="form-control" /></td>';
			html += '  <td><select name="product_multiple[multiple_value][' + multiple_row + '][weight_class_id]" class="form-control">';
			html += $('#weight-classes0').html();
			html += '    </select>';
			html += '  </td>';
			html += '  <td class="text-right"><button type="button" onclick="$(this).tooltip(\'destroy\');$(this).closest(\'tr\').remove();" data-toggle="tooltip" rel="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';

			$('#table-product-multiple tbody').append(html);
			$('[rel=tooltip]').tooltip();

			multiple_row++;
		}
	</script>
</div>