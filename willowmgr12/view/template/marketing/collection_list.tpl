<?= $header; ?>
<?= $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="button" data-toggle="tooltip" title="<?= $button_export; ?>" class="btn btn-info"
					onclick="$('#form-collection').submit()"><i class="fa fa-upload"></i></button>
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
		<?php if ($error) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
			<?= $error; ?>
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
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="input-invoice">
									<?= $entry_invoice; ?>
								</label>
								<input type="text" name="filter_invoice" value="<?= $filter['invoice']; ?>"
									placeholder="<?= $entry_invoice; ?>" id="input-invoice" class="form-control" />
							</div>
							<div class="form-group">
								<label class="control-label" for="input-account">
									<?= $entry_account; ?>
								</label>
								<input type="text" name="filter_account" value="<?= $filter['account']; ?>"
									placeholder="<?= $entry_account; ?>" id="input-account" class="form-control" />
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="input-customer-id">
									<?= $entry_customer_id; ?>
								</label>
								<input type="text" name="filter_customer_id" value="<?= $filter['customer_id']; ?>"
									placeholder="<?= $entry_customer_id; ?>" id="input-customer-id" class="form-control" />
							</div>
							<div class="form-group">
								<label class="control-label" for="input-name">
									<?= $entry_name; ?>
								</label>
								<input type="text" name="filter_name" value="<?= $filter['name']; ?>" placeholder="<?= $entry_name; ?>"
									id="input-name" class="form-control" />
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="input-date-start">
									<?php echo $entry_date_start; ?>
								</label>
								<div class="input-group date">
									<input type="text" name="filter_date_start" value="<?php echo $filter['date_start']; ?>"
										placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start"
										class="form-control" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label" for="input-date-end">
									<?php echo $entry_date_end; ?>
								</label>
								<div class="input-group date">
									<input type="text" name="filter_date_end" value="<?php echo $filter['date_end']; ?>"
										placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end"
										class="form-control" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
							<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i>
								<?= $button_filter; ?>
							</button>
						</div>
					</div>
				</div>
				<form action="<?= $export; ?>" method="post" enctype="multipart/form-data" id="form-collection">
					<div class="table-responsive">
						<table class="table table-bordered table-hover text-left">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox"
											onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
									</td>
									<td>
										<?php if ($sort == 'invoice') { ?>
										<a href="<?= $sort_invoice; ?>" class="<?= strtolower($order); ?>">
											<?= $column_invoice; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_invoice; ?>">
											<?= $column_invoice; ?>
										</a>
										<?php } ?>
									</td>
									<td class="text-right">
										<?php if ($sort == 'total') { ?>
										<a href="<?= $sort_total; ?>" class="<?= strtolower($order); ?>">
											<?= $column_total; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_total; ?>">
											<?= $column_total; ?>
										</a>
										<?php } ?>
									</td>
									<td>
										<?php if ($sort == 'customer_id') { ?>
										<a href="<?= $sort_customer_id; ?>" class="<?= strtolower($order); ?>">
											<?= $column_customer_id; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_customer_id; ?>">
											<?= $column_customer_id; ?>
										</a>
										<?php } ?>
									</td>
									<td>
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
									<td>
										<?php if ($sort == 'account') { ?>
										<a href="<?= $sort_account; ?>" class="<?= strtolower($order); ?>">
											<?= $column_account; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_account; ?>">
											<?= $column_account; ?>
										</a>
										<?php } ?>
									</td>
									<td>
										<?php if ($sort == 'date_added') { ?>
										<a href="<?= $sort_date_added; ?>" class="<?= strtolower($order); ?>">
											<?= $column_date_added; ?>
										</a>
										<?php } else { ?>
										<a href="<?= $sort_date_added; ?>">
											<?= $column_date_added; ?>
										</a>
										<?php } ?>
									</td>
								</tr>
							</thead>
							<tbody>
								<?php if ($collections) { ?>
								<?php foreach ($collections as $collection) { ?>
								<tr>
									<td class="text-center">
										<?php if (in_array($collection['collection_id'], $selected)) { ?>
										<input type="checkbox" name="selected[]" value="<?= $collection['collection_id']; ?>"
											checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?= $collection['collection_id']; ?>" />
										<?php } ?>
									</td>
									<td>
										<?= $collection['invoice']; ?>
									</td>
									<td class="text-right">
										<?= $collection['total']; ?>
									</td>
									<td>
										<?= $collection['customer_id']; ?>
									</td>
									<td>
										<?= $collection['name']; ?>
									</td>
									<td>
										<?= $collection['account']; ?>
									</td>
									<td>
										<?= $collection['date_added']; ?>
									</td>
									<?php } ?>
									<?php } else { ?>
								<tr>
									<td class="text-center" colspan="7">
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
			let url = 'index.php?route=marketing/collection&token=<?= $token; ?>';
			let field_data = JSON.parse('<?= $json_field_data; ?>');
			let filter;

			for (let i = 0; i < field_data.length; i++) {
				filter = $('input[name=\'filter_' + field_data[i] + '\']').val();

				if (filter) {
					url += '&filter_' + field_data[i] + '=' + encodeURIComponent(filter);
				}
			}

			location = url;
		});

		$('.date').datetimepicker({
			pickTime: false
		});
	</script>
</div>
<?= $footer; ?>