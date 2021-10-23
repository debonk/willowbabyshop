<?= $header; ?>
<?= $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-backup" data-toggle="tooltip" title="<?= $button_export; ?>"
					class="btn btn-default"><i class="fa fa-upload"></i></button>
				<button type="submit" form="form-restore" data-toggle="tooltip" title="<?= $button_import; ?>"
					class="btn btn-default"><i class="fa fa-download"></i></button>
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
			<button type="button" form="form-backup" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-exchange"></i>
					<?= $heading_title; ?>
				</h3>
			</div>
			<div class="panel-body">
				<form action="<?= $import; ?>" method="post" enctype="multipart/form-data" id="form-restore"
					class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-new-product">
							<?= $entry_new_product; ?>
						</label>
						<div class="col-sm-10">
							<input type="file" name="new_product" id="input-new-product" />
						</div>
					</div>
				</form>
				<form action="<?= $backup; ?>" method="post" enctype="multipart/form-data" id="form-backup"
					class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label">
							<?= $entry_export; ?>
						</label>
						<div class="col-sm-10">
							<label for="export1"><input type="checkbox" name="export1" value="export1" id="export1"
									checked="checked" />
								<?= $text_export1; ?>
							</label>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
<?= $footer; ?>