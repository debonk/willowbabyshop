<?= $header; ?>
<?= $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-link" data-toggle="tooltip" title="<?= $button_save; ?>"
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
					<?= $text_edit; ?>
				</h3>
			</div>
			<div class="panel-body">
				<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-payment-link"
					class="form-horizontal">
					<?php foreach ($languages as $language) { ?>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-instruction<?= $language['language_id']; ?>">
							<?= $entry_instruction; ?>
						</label>
						<div class="col-sm-10">
							<div class="input-group"><span class="input-group-addon"><img
										src="language/<?= $language['code']; ?>/<?= $language['code']; ?>.png"
										title="<?= $language['name']; ?>" /></span>
								<textarea name="link_instruction<?= $language['language_id']; ?>" cols="80" rows="10"
									placeholder="<?= $entry_instruction; ?>" id="input-instruction<?= $language['language_id']; ?>"
									class="form-control"><?= isset(${'link_instruction' . $language['language_id']}) ? ${'link_instruction' . $language['language_id']} : ''; ?></textarea>
							</div>
							<?php if (${'error_instruction' . $language['language_id']}) { ?>
							<div class="text-danger">
								<?= ${'error_instruction' . $language['language_id']}; ?>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip"
								title="<?= $help_total; ?>">
								<?= $entry_total; ?>
							</span></label>
						<div class="col-sm-10">
							<input type="text" name="link_total" value="<?= $link_total; ?>" placeholder="<?= $entry_total; ?>"
								id="input-total" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-order-status">
							<?= $entry_order_status; ?>
						</label>
						<div class="col-sm-10">
							<select name="link_order_status_id" id="input-order-status" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
								<?php if ($order_status['order_status_id'] == $link_order_status_id) { ?>
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
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-geo-zone">
							<?= $entry_geo_zone; ?>
						</label>
						<div class="col-sm-10">
							<select name="link_geo_zone_id" id="input-geo-zone" class="form-control">
								<option value="0">
									<?= $text_all_zones; ?>
								</option>
								<?php foreach ($geo_zones as $geo_zone) { ?>
								<?php if ($geo_zone['geo_zone_id'] == $link_geo_zone_id) { ?>
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
							<select name="link_status" id="input-status" class="form-control">
								<?php if ($link_status) { ?>
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
							<input type="text" name="link_sort_order" value="<?= $link_sort_order; ?>"
								placeholder="<?= $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?= $footer; ?>