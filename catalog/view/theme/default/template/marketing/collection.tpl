<?= $header; ?>
<div class="container">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?= $breadcrumb['href']; ?>">
				<?= $breadcrumb['text']; ?>
			</a></li>
		<?php } ?>
	</ul>
	<?php if ($error_warning) { ?>
	<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
		<?= $error_warning; ?>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</div>
	<?php } ?>
	<div class="row">
		<?= $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-sm-9'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?= $class; ?>">
			<?= $content_top; ?>
			<h1>
				<?= $heading_title; ?>
			</h1>
			<h3>
				<?= $text_subtitle; ?>
			</h3>
			<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-collection"
				class="form-horizontal">
				<fieldset>
					<legend>
						<?= $text_welcome; ?><br>
						<?= $text_confirmation; ?>
					</legend>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-name">
							<?= $entry_name; ?>
						</label>
						<div class="col-sm-10">
							<input type="text" name="name" value="<?= $name; ?>" id="input-name" class="form-control" readonly />
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-customer-id">
							<?= $entry_customer_id; ?>
						</label>
						<div class="col-sm-10">
							<input type="text" name="customer_id" value="<?= $customer_id; ?>" id="input-customer-id"
								class="form-control" readonly />
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-invoice">
							<?= $entry_invoice; ?>
						</label>
						<div class="col-sm-10">
							<input type="text" name="invoice" value="<?= $invoice; ?>" id="input-invoice" class="form-control"
								readonly />
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-total">
							<?= $entry_total; ?>
						</label>
						<div class="col-sm-10">
							<input type="text" name="total" value="<?= $total; ?>" id="input-total" class="form-control" readonly />
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-account">
							<?= $entry_account; ?>
						</label>
						<div class="col-sm-10">
							<input type="text" name="account" value="<?= $account; ?>" id="input-account" class="form-control"
								placeholder="<?= $entry_account; ?>" />
							<?php if ($error_account) { ?>
							<div class="text-danger">
								<?= $error_account; ?>
							</div>
							<?php } ?>
						</div>
					</div>
					<?= $captcha; ?>
				</fieldset>
				<div class="buttons">
					<div class="pull-right">
						<input class="btn btn-success" type="submit" value="<?= $button_submit; ?>" />
					</div>
				</div>
			</form>
			<?= $content_bottom; ?>
		</div>
		<?= $column_right; ?>
	</div>
</div>
<?= $footer; ?>