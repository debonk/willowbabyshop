<?= $header; ?>
<?= $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-option" data-toggle="tooltip" title="<?= $button_save; ?>"
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
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
			<?= $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i>
					<?= $text_form; ?>
				</h3>
			</div>
			<div class="panel-body">
				<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-option"
					class="form-horizontal">
					<div class="form-group required">
						<label class="col-sm-2 control-label">
							<?= $entry_name; ?>
						</label>
						<div class="col-sm-10">
							<?php foreach ($languages as $language) { ?>
							<div class="input-group"><span class="input-group-addon"><img
										src="language/<?= $language['code']; ?>/<?= $language['code']; ?>.png"
										title="<?= $language['name']; ?>" /></span>
								<input type="text" name="option_description[<?= $language['language_id']; ?>][name]"
									value="<?= isset($option_description[$language['language_id']]) ? $option_description[$language['language_id']]['name'] : ''; ?>"
									placeholder="<?= $entry_name; ?>" class="form-control" />
							</div>
							<?php if (isset($error_name[$language['language_id']])) { ?>
							<div class="text-danger">
								<?= $error_name[$language['language_id']]; ?>
							</div>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-type">
							<?= $entry_type; ?>
						</label>
						<div class="col-sm-10">
							<select name="type" id="input-type" class="form-control">
								<?php foreach($type_groups as $type_group) { ?>
								<optgroup label="<?= $type_group['text']; ?>">
									<?php foreach($type_group['type_data'] as $type_data) { ?>
									<?php if ($type_data['value'] == $type) { ?>
									<option value="<?= $type_data['value']; ?>" selected="selected">
										<?= $type_data['text']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $type_data['value']; ?>">
										<?= $type_data['text']; ?>
									</option>
									<?php } ?>
									<?php } ?>
									<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-sort-order">
							<?= $entry_sort_order; ?>
						</label>
						<div class="col-sm-10">
							<input type="text" name="sort_order" value="<?= $sort_order; ?>" placeholder="<?= $entry_sort_order; ?>"
								id="input-sort-order" class="form-control" />
						</div>
					</div>
					<table id="option-value" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<td class="text-left required">
									<?= $entry_option_value; ?>
								</td>
								<td class="text-left">
									<?= $entry_image; ?>
								</td>
								<td class="text-right">
									<?= $entry_sort_order; ?>
								</td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<?php $option_value_row = 0; ?>
							<?php foreach ($option_values as $option_value) { ?>
							<tr id="option-value-row<?= $option_value_row; ?>">
								<td class="text-left"><input type="hidden"
										name="option_value[<?= $option_value_row; ?>][option_value_id]"
										value="<?= $option_value['option_value_id']; ?>" />
									<?php foreach ($languages as $language) { ?>
									<div class="input-group"><span class="input-group-addon"><img
												src="language/<?= $language['code']; ?>/<?= $language['code']; ?>.png"
												title="<?= $language['name']; ?>" /></span>
										<input type="text"
											name="option_value[<?= $option_value_row; ?>][option_value_description][<?= $language['language_id']; ?>][name]"
											value="<?= isset($option_value['option_value_description'][$language['language_id']]) ? $option_value['option_value_description'][$language['language_id']]['name'] : ''; ?>"
											placeholder="<?= $entry_option_value; ?>" class="form-control" />
									</div>
									<?php if (isset($error_option_value[$option_value_row][$language['language_id']])) { ?>
									<div class="text-danger">
										<?= $error_option_value[$option_value_row][$language['language_id']]; ?>
									</div>
									<?php } ?>
									<?php } ?>
								</td>
								<td class="text-left"><a href="" id="thumb-image<?= $option_value_row; ?>" data-toggle="image"
										class="img-thumbnail"><img src="<?= $option_value['thumb']; ?>" alt="" title=""
											data-placeholder="<?= $placeholder; ?>" /></a>
									<input type="hidden" name="option_value[<?= $option_value_row; ?>][image]"
										value="<?= $option_value['image']; ?>" id="input-image<?= $option_value_row; ?>" />
								</td>
								<td class="text-right"><input type="text" name="option_value[<?= $option_value_row; ?>][sort_order]"
										value="<?= $option_value['sort_order']; ?>" class="form-control" /></td>
								<td class="text-left"><button type="button"
										onclick="$('#option-value-row<?= $option_value_row; ?>').remove();" data-toggle="tooltip"
										title="<?= $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
								</td>
							</tr>
							<?php $option_value_row++; ?>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3"></td>
								<td class="text-left"><button type="button" onclick="addOptionValue();" data-toggle="tooltip"
										title="<?= $button_option_value_add; ?>" class="btn btn-primary"><i
											class="fa fa-plus-circle"></i></button></td>
							</tr>
						</tfoot>
					</table>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
			$('select[name=\'type\']').on('change', function () {
				if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox' || this.value == 'image') {
					$('#option-value').show();
				} else {
					$('#option-value').hide();
				}
			});

		$('select[name=\'type\']').trigger('change');

		let option_value_row = '<?= $option_value_row; ?>';

		function addOptionValue() {
			let languages = JSON.parse('<?= $js_languages; ?>');

			html = '<tr id="option-value-row' + option_value_row + '">';
			html += '  <td class="text-left"><input type="hidden" name="option_value[' + option_value_row + '][option_value_id]" value="" />';

			for (let i in languages) {
				html += '    <div class="input-group">';
				html += '      <span class="input-group-addon"><img src="language/' + languages[i]['code'] + '/' + languages[i]['code'] + '.png" title="' + languages[i]['name'] + '" /></span><input type="text" name="option_value[' + option_value_row + '][option_value_description][' + languages[i]['language_id'] + '][name]" value="" placeholder="<?= $entry_option_value; ?>" class="form-control" />';
				html += '    </div>';
			}

			html += '  </td>';
			html += '  <td class="text-left"><a href="" id="thumb-image' + option_value_row + '" data-toggle="image" class="img-thumbnail"><img src="<?= $placeholder; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a><input type="hidden" name="option_value[' + option_value_row + '][image]" value="" id="input-image' + option_value_row + '" /></td>';
			html += '  <td class="text-right"><input type="text" name="option_value[' + option_value_row + '][sort_order]" value="" placeholder="<?= $entry_sort_order; ?>" class="form-control" /></td>';
			html += '  <td class="text-left"><button type="button" onclick="$(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';

			$('#option-value tbody').append(html);

			option_value_row++;
		}
</script>
</div>
<?= $footer; ?>