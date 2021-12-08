<?= $header; ?>
<?= $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-pp-login" data-toggle="tooltip" title="<?= $button_save; ?>"
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
		<?php if (isset($error['error_warning'])) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
			<?= $error['error_warning']; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i>
					<?= $heading_title; ?>
				</h3>
			</div>
			<div class="panel-body">
				<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-pp-login"
					class="form-horizontal">
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="entry-client_id">
							<?= $entry_client_id; ?>
						</label>
						<div class="col-sm-10">
							<input type="text" name="google_login_client_id" value="<?= $google_login_client_id; ?>"
								placeholder="<?= $entry_client_id; ?>" id="entry-client_id" class="form-control" />
							<?php if ($error_client_id) { ?>
							<div class="text-danger">
								<?= $error_client_id; ?>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="entry-secret">
							<?= $entry_secret; ?>
						</label>
						<div class="col-sm-10">
							<input type="text" name="google_login_secret" value="<?= $google_login_secret; ?>"
								placeholder="<?= $entry_secret; ?>" id="entry-secret" class="form-control" />
							<?php if ($error_secret) { ?>
							<div class="text-danger">
								<?= $error_secret; ?>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="entry-redirect-uri"><span data-toggle="tooltip"
								title="<?= $help_redirect_uri; ?>">
								<?= $entry_redirect_uri; ?>
							</span></label>
						<div class="col-sm-10">
							<input type="text" name="google_login_redirect_uri" value="<?= $google_login_redirect_uri; ?>"
								placeholder="<?= $entry_redirect_uri; ?>" id="entry-redirect-uri" class="form-control" />
							<?php if ($error_redirect_uri) { ?>
							<div class="text-danger">
								<?= $error_redirect_uri; ?>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><?= $entry_button_image; ?></label>
						<div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?= $thumb; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a>
							<input type="hidden" name="google_login_button_image" value="<?= $google_login_button_image; ?>" id="entry-button-image" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status">
							<?= $entry_status; ?>
						</label>
						<div class="col-sm-10">
							<select name="google_login_status" id="input-status" class="form-control">
								<?php if ($google_login_status) { ?>
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
				</form>
			</div>
		</div>
	</div>
</div>
<?= $footer; ?>