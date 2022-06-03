<?= $header; ?>
<?= $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart"></i>
					<?= $text_list; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="well">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="input-date-start">
									<?= $entry_date_start; ?>
								</label>
								<div class="input-group date">
									<input type="text" name="filter_date_start" value="<?= $filter_date_start; ?>"
										placeholder="<?= $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start"
										class="form-control" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label" for="input-date-end">
									<?= $entry_date_end; ?>
								</label>
								<div class="input-group date">
									<input type="text" name="filter_date_end" value="<?= $filter_date_end; ?>"
										placeholder="<?= $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end"
										class="form-control" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
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
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="input-status">
									<?= $entry_status; ?>
								</label>
								<select name="filter_order_status_id" id="input-status" class="form-control">
									<option value="0">
										<?= $text_all_status; ?>
									</option>
									<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
									<option value="<?= $order_status['order_status_id']; ?>" selected="selected">
										<?= $order_status['name']; ?>
									</option>
									<?php } else { ?>
									<option value="<?= $order_status['order_status_id']; ?>">
										<?= $order_status['name']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
							<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i>
								<?= $button_filter; ?>
							</button>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered text-left">
						<thead>
							<tr>
								<td>
									<?php if ($sort == 'op.name') { ?>
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
									<?php if ($sort == 'op.model') { ?>
									<a href="<?= $sort_model; ?>" class="<?= strtolower($order); ?>">
										<?= $column_model; ?>
									</a>
									<?php } else { ?>
									<a href="<?= $sort_model; ?>">
										<?= $column_model; ?>
									</a>
									<?php } ?>
								</td>
								<td class="text-right">
									<?php if ($sort == 'quantity') { ?>
									<a href="<?= $sort_quantity; ?>" class="<?= strtolower($order); ?>">
										<?= $column_quantity; ?>
									</a>
									<?php } else { ?>
									<a href="<?= $sort_quantity; ?>">
										<?= $column_quantity; ?>
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
							</tr>
						</thead>
						<tbody>
							<?php if ($products) { ?>
							<?php foreach ($products as $product) { ?>
							<tr>
								<td>
									<?= $product['name']; ?>
									<?php if ($product['option']) { ?>
									<small>
										<?= ' - ' . $product['option']; ?>
									</small>
									<?php } ?>
								</td>
								<td>
									<?= $product['model']; ?>
								</td>
								<td class="text-right">
									<?= $product['quantity']; ?>
								</td>
								<td class="text-right">
									<?= $product['total']; ?>
								</td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td class="text-center" colspan="4">
									<?= $text_no_results; ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
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
			url = 'index.php?route=report/product_purchased&token=<?= $token; ?>';

			var filter_date_start = $('input[name=\'filter_date_start\']').val();

			if (filter_date_start) {
				url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
			}

			var filter_date_end = $('input[name=\'filter_date_end\']').val();

			if (filter_date_end) {
				url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
			}

			var filter_name = $('input[name=\'filter_name\']').val();

			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}

			var filter_model = $('input[name=\'filter_model\']').val();

			if (filter_model) {
				url += '&filter_model=' + encodeURIComponent(filter_model);
			}

			var filter_order_status_id = $('select[name=\'filter_order_status_id\']').val();

			if (filter_order_status_id != 0) {
				url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
			}

			location = url;
		});
	</script>
	<script type="text/javascript">
		$('.date').datetimepicker({
			pickTime: false
		});
	</script>
</div>
<?= $footer; ?>