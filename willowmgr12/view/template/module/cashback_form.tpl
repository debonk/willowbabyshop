<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cashback" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cashback" class="form-horizontal">
		  <div class="form-group">
			<label class="col-sm-2 control-label" for="input-discount"><?php echo $entry_discount; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="cashback_discount" value="<?php echo $discount; ?>" placeholder="<?php echo $entry_discount; ?>" id="input-discount" class="form-control" />
                <?php if ($error_discount) { ?>
                <div class="text-danger"><?php echo $error_discount; ?></div>
                <?php } ?>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 control-label" for="input-min-total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
			<div class="col-sm-10">
			  <input type="text" name="cashback_min_total" value="<?php echo $min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-min-total" class="form-control" />
                <?php if ($error_min_total) { ?>
                <div class="text-danger"><?php echo $error_min_total; ?></div>
                <?php } ?>
			</div>
		  </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-max-total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="cashback_max_total" value="<?php echo $max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-max-total" class="form-control" />
                <?php if ($error_max_total) { ?>
                <div class="text-danger"><?php echo $error_max_total; ?></div>
                <?php }  ?>
            </div>
          </div>
		  <div class="form-group">
			<label class="col-sm-2 control-label" for="input-valid"><span data-toggle="tooltip" title="<?php echo $help_valid; ?>"><?php echo $entry_valid; ?></span></label>
			<div class="col-sm-10">
			  <input type="text" name="cashback_valid" value="<?php echo $valid; ?>" placeholder="<?php echo $entry_valid; ?>" id="input-valid" class="form-control" />
                <?php if ($error_valid) { ?>
                <div class="text-danger"><?php echo $error_valid; ?></div>
                <?php } ?>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 control-label" for="input-date-start"><?php echo $entry_date_start; ?></label>
			<div class="col-sm-3">
			  <div class="input-group date">
				<input type="text" name="cashback_date_start" value="<?php echo $date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
				<span class="input-group-btn">
				<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				</span></div>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 control-label" for="input-theme"><?php echo $entry_theme; ?></label>
			<div class="col-sm-10">
			  <select name="cashback_voucher_theme_id" id="input-theme" class="form-control">
				<?php foreach ($voucher_themes as $voucher_theme) { ?>
				<?php if ($voucher_theme['voucher_theme_id'] == $cashback_voucher_theme_id) { ?>
				<option value="<?php echo $voucher_theme['voucher_theme_id']; ?>" selected="selected"><?php echo $voucher_theme['name']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $voucher_theme['voucher_theme_id']; ?>"><?php echo $voucher_theme['name']; ?></option>
				<?php } ?>
				<?php } ?>
			  </select>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
			<div class="col-sm-10">
			  <select name="cashback_status" id="input-status" class="form-control">
				<?php if ($status) { ?>
				<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				<option value="0"><?php echo $text_disabled; ?></option>
				<?php } else { ?>
				<option value="1"><?php echo $text_enabled; ?></option>
				<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				<?php } ?>
			  </select>
			</div>
		  </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>
</div>
<?php echo $footer; ?> 