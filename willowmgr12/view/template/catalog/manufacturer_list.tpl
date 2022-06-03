<?= $header; ?>
<?= $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right"><a href="<?= $add; ?>" data-toggle="tooltip" title="<?= $button_add; ?>"
					class="btn btn-primary"><i class="fa fa-plus"></i></a>
				<button type="button" data-toggle="tooltip" title="<?= $button_delete; ?>" class="btn btn-danger"
					onclick="confirm('<?= $text_confirm; ?>') ? $('#form-manufacturer').submit() : false;"><i
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
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label" for="input-name">
									<?= $entry_name; ?>
								</label>
								<input type="text" name="filter_name" value="<?= $filter_name; ?>" placeholder="<?= $entry_name; ?>"
									id="input-name" class="form-control" />
							</div>
							<div class="form-group">
								<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i>
									<?= $button_filter; ?>
								</button>
							</div>
						</div>
					</div>
				</div>
				<form action="<?= $delete; ?>" method="post" enctype="multipart/form-data" id="form-manufacturer">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox"
											onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
											<br>
											<?php if ($sort == 'manufacturer_id') { ?>
											<a href="<?= $sort_id; ?>" class="<?= strtolower($order); ?>">
												<?= $column_id; ?>
											</a>
											<?php } else { ?>
											<a href="<?= $sort_id; ?>">
												<?= $column_id; ?>
											</a>
											<?php } ?>
										</td>
									<td class="text-left">
										<?php if ($sort == 'name') { ?>
										<a href="<?= $sort_name; ?>" class="<?= strtolower($order); ?>">
											<?= $column_name; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_name; ?>">
											<?= $column_name; ?>
										</a>
										<?php } ?>
									</td>
									<td class="text-right">
										<?php if ($sort == 'product_total') { ?>
										<a href="<?= $sort_product_total; ?>" class="<?= strtolower($order); ?>">
											<?= $column_product_total; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_product_total; ?>">
											<?= $column_product_total; ?>
										</a>
										<?php } ?>
									</td>
									<td class="text-right">
										<?php if ($sort == 'sort_order') { ?>
										<a href="<?= $sort_sort_order; ?>" class="<?= strtolower($order); ?>">
											<?= $column_sort_order; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_sort_order; ?>">
											<?= $column_sort_order; ?>
										</a>
										<?php } ?>
									</td>
									<td class="text-right">
										<?= $column_action; ?>
									</td>
								</tr>
							</thead>
							<tbody>
								<?php if ($manufacturers) { ?>
								<?php foreach ($manufacturers as $manufacturer) { ?>
								<tr>
									<td class="text-center">
										<?php if (in_array($manufacturer['manufacturer_id'], $selected)) { ?>
										<input type="checkbox" name="selected[]" value="<?= $manufacturer['manufacturer_id']; ?>"
											checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?= $manufacturer['manufacturer_id']; ?>" />
										<?php } ?>
										<br>
										<?= $manufacturer['manufacturer_id']; ?>
									</td>
									<td class="text-left">
										<?= $manufacturer['name']; ?>
									</td>
									<td class="text-right">
										<?= $manufacturer['product_total']; ?>
									</td>
									<td class="text-right">
										<?= $manufacturer['sort_order']; ?>
									</td>
									<td class="text-right"><a href="<?= $manufacturer['edit']; ?>" data-toggle="tooltip"
											title="<?= $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td class="text-center" colspan="5">
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
			var url = 'index.php?route=catalog/manufacturer&token=<?= $token; ?>';

			var filter_name = $('input[name=\'filter_name\']').val();

			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}

			location = url;
		});
	</script>
</div>
<?= $footer; ?>