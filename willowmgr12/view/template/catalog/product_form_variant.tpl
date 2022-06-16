<div class="form-group">
	<div class="col-sm-3">
		<input type="text" name="variant" value="" placeholder="<?= $entry_variant; ?>" id="input-variant"
			class="form-control" />
	</div>
</div>
<div>
	<div class="tab-content">
		<div class="table-responsive">
			<table id="table-product-variant" class="table table-striped table-bordered table-hover text-left">
				<thead>
					<tr>
						<td>
							<?= $column_image; ?>
						</td>
						<?php foreach($product_variants['option'] as $column => $product_option) { ?>
						<td class="variant-option<?= $column; ?> bg-primary">
							<div id="variant-option<?= $column; ?>" data-column="<?= $column; ?>"><i class="fa fa-minus-circle"
									onclick="deleteVariantOption('<?= $column; ?>');" data-toggle="tooltip"
									title="<?= $button_remove; ?>"></i>
								<?= $product_option['name']; ?>
							</div>
							<input type="hidden" name="product_variant[option][<?= $column; ?>][option_id]"
								value="<?= $product_option['option_id']; ?>" />
							<select id="variant-values<?= $column; ?>" style="display: none;">
								<?php foreach($product_option['option_value'] as $option_value) { ?>
								<option value="<?= $option_value['option_value_id']; ?>">
									<?= $option_value['name']; ?>
								</option>
								<?php } ?>
							</select>
						</td>
						<?php } ?>
						<td class="required" id="label-model">
							<?= $column_model; ?>
						</td>
						<td class="text-right">
							<?= $column_quantity; ?>
						</td>
						<td class="text-right">
							<?= $column_price; ?>
						</td>
						<td class="text-right">
							<?= $column_points; ?>
						</td>
						<td class="text-right">
							<?= $column_weight; ?>
						</td>
						<td class="text-right">
							<?= $column_weight_class; ?>
							<select id="weight-classes" class="hidden">
								<?php foreach($weight_classes as $weight_class) { ?>
								<option value="<?= $weight_class['weight_class_id'] ?>"
									<?=($weight_class['weight_class_id']==$product_variants['variant'][0]['weight_class_id']) ? 'selected'
									: '' ?>>
									<?= $weight_class['title']; ?>
								</option>
								<?php } ?>
							</select>
						</td>
						<td class="text-right">
							<?= $column_action; ?>
						</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($product_variants['variant'] as $row => $variant) { ?>
					<tr id="variant-value-row<?= $row; ?>" data-row="<?= $row; ?>">
						<td><a href="" id="thumb-variant-image<?= $row; ?>" data-toggle="image" class="img-thumbnail"><img
									src="<?= $variant['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a><input
								type="hidden" name="product_variant[variant][<?= $row; ?>][image]" value="<?= $variant['image']; ?>"
								id="input-variant-image<?= $row; ?>" /></td>
						<?php foreach($variant['option_value_id'] as $column => $option_value_id) { ?>
						<td class="variant-option<?= $column; ?>"><select
								name="product_variant[variant][<?= $row; ?>][option_value_id][<?= $column; ?>]" class="form-control">
								<?php foreach($product_variants['option'][$column]['option_value'] as $option_value) { ?>
								<option value="<?= $option_value['option_value_id']; ?>"
									<?=($option_value['option_value_id']==$variant['option_value_id'][$column]) ? 'selected' : '' ?>>
									<?= $option_value['name']; ?>
								</option>
								<?php } ?>
							</select>
						</td>
						<?php } ?>
						<td id="input-model<?= $row; ?>"><input type="text" name="product_variant[variant][<?= $row; ?>][model]"
								value="<?= $variant['model']; ?>" placeholder="<?= $entry_model; ?>" class="form-control" /></td>
						<td class="text-right"><input type="text" name="product_variant[variant][<?= $row; ?>][quantity]"
								value="<?= $variant['quantity']; ?>" placeholder="<?= $entry_quantity; ?>" class="form-control" /></td>
						<td class="text-right"><input type="text" name="product_variant[variant][<?= $row; ?>][price]"
								value="<?= $variant['price']; ?>" placeholder="<?= $entry_price; ?>" class="form-control"
								id="input-price<?= $row; ?>" /></td>
						<td class="text-rigth"><input type="text" name="product_variant[variant][<?= $row; ?>][points]"
								value="<?= $variant['points']; ?>" placeholder="<?= $entry_points; ?>" class="form-control"
								id="input-points<?= $row; ?>" />
						</td>
						<td class="text-right"><input type="text" name="product_variant[variant][<?= $row; ?>][weight]"
								value="<?= $variant['weight']; ?>" placeholder="<?= $entry_weight; ?>" class="form-control"
								id="input-weight<?= $row; ?>" />
						</td>
						<td><select name="product_variant[variant][<?= $row; ?>][weight_class_id]" class="form-control"
								id="weight-classes<?= $row; ?>">
								<?php foreach($weight_classes as $weight_class) { ?>
								<option value="<?= $weight_class['weight_class_id'] ?>"
									<?=($weight_class['weight_class_id']==$variant['weight_class_id']) ? 'selected' : '' ?>>
									<?= $weight_class['title']; ?>
								</option>
								<?php } ?>
							</select>
						</td>
						<td class="text-right">
							<button type="button" onclick="$(this).tooltip('destroy');$(this).closest('tr').remove();"
								data-toggle="tooltip" rel="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i
									class="fa fa-minus-circle"></i></button>

						</td>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td class="text-right" colspan="15"><button type="button" onclick="addVariantValue();" data-toggle="tooltip"
								title="<?= $button_option_value_add; ?>" class="btn btn-primary"><i
									class="fa fa-plus-circle"></i></button></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

	<script type="text/javascript">
		let variant_column = '<?= $option_count; ?>';

		$(document).ready(function () {
			$('input[name=\'variant\']').autocomplete({
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
					html = '';
					html += '  <td class="variant-option' + variant_column + ' bg-primary">';
					html += '  <div id="variant-option' + variant_column + '" data-column="' + variant_column + '"><i class="fa fa-minus-circle" onclick="deleteVariantOption(' + variant_column + ');" data-toggle="tooltip" title="<?= $button_remove; ?>"></i> ' + item['label'] + '</div>';
					html += '	 <input type="hidden" name="product_variant[option][' + variant_column + '][option_id]" value="' + item['value'] + '" />';

					html += '  <select id="variant-values' + variant_column + '" style="display: none;">';
					for (let i = 0; i < item['option_value'].length; i++) {
						html += '  <option value="' + item['option_value'][i]['option_value_id'] + '">' + item['option_value'][i]['name'] + '</option>';
					}
					html += '  </select>';
					html += '  </td>';

					$('#tab-variant #label-model').before(html);

					let variant_rows = $('[id^=\'variant-value-row\']');

					for (let j = 0; j < variant_rows.length; j++) {
						let row = $(variant_rows[j]).data('row');
						html = '';
						html += '  <td class="variant-option' + variant_column + '"><select name="product_variant[variant][' + row + '][option_value_id][' + variant_column + ']" class="form-control">';
						html += $('#variant-values' + variant_column).html();
						html += '  </select></td>';

						$('#tab-variant #input-model' + row).before(html);
					}

					variant_column++;

					$('[data-toggle=\'tooltip\']').tooltip({
						container: 'body',
						html: true
					});
				}
			});
		});
	</script>
	<script type="text/javascript">
		function deleteVariantOption(variant_column) {
			$('[class^=\'variant-option' + variant_column + '\']').remove();
		}

		let variant_row = '<?= $variant_count; ?>';
		let default_value = JSON.parse('<?= $default_value; ?>');

		function addVariantValue() {
			html = ''
			html += '<tr id="variant-value-row' + variant_row + '" data-row="' + variant_row + '">';
			html += '  <td><a href="" id="thumb-variant-image' + variant_row + '" data-toggle="image" class="img-thumbnail"><img src="' + default_value.thumb + '" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a><input type="hidden" name="product_variant[variant][' + variant_row + '][image]" value="' + default_value.image + '" id="input-variant-image' + variant_row + '" /></td>';

			let variant_columns = $('[id^=\'variant-option\']');

			for (let k = 0; k < variant_columns.length; k++) {
				let column = $(variant_columns[k]).data('column');

				html += '  <td class="variant-option' + column + '"><select name="product_variant[variant][' + variant_row + '][option_value_id][' + column + ']" class="form-control">';
				html += $('#variant-values' + column).html();
				html += '  </select></td>';
			}

			html += '  <td id="input-model' + variant_row + '"><input type="text" name="product_variant[variant][' + variant_row + '][model]" value="" placeholder="<?= $entry_model; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_variant[variant][' + variant_row + '][quantity]" value="" placeholder="<?= $entry_quantity; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_variant[variant][' + variant_row + '][price]" value="' + default_value.price + '" placeholder="<?= $entry_price; ?>" class="form-control" /></td>';
			html += '  <td class="text-rigth"><input type="text" name="product_variant[variant][' + variant_row + '][points]" value="' + default_value.points + '" placeholder="<?= $entry_points; ?>" class="form-control" /></td>';
			html += '  <td class="text-right"><input type="text" name="product_variant[variant][' + variant_row + '][weight]" value="' + default_value.weight + '" placeholder="<?= $entry_weight; ?>" class="form-control" /></td>';
			html += '  <td><select name="product_variant[variant][' + variant_row + '][weight_class_id]" class="form-control">';
			html += $('#weight-classes').html();
			html += '    </select>';
			html += '  </td>';
			html += '  <td class="text-right"><button type="button" onclick="$(this).tooltip(\'destroy\');$(this).closest(\'tr\').remove();" data-toggle="tooltip" rel="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';

			$('#table-product-variant tbody').append(html);
			$('[rel=tooltip]').tooltip();

			variant_row++;
		}
	</script>
</div>