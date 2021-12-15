<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-reward" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-reward" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-percent-gain"><span data-toggle="tooltip" title="<?php echo $help_percent_gain; ?>"><?php echo $entry_percent_gain; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="reward_percent_gain" value="<?php echo $reward_percent_gain; ?>" placeholder="<?php echo $entry_percent_gain; ?>" id="input-percent-gain" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_sub_calc; ?>"><?php echo $entry_sub_calc; ?></span></label>
            <div class="col-sm-10">
				<?php if ($reward_sub_calc) { ?>
				   <input type="checkbox" name="reward_sub_calc"  checked="checked" class="form-control" />
				<?php } else { ?>
				   <input type="checkbox" name="reward_sub_calc"  class="form-control" />
				<?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-max-subtotal"><span data-toggle="tooltip" title="<?php echo $help_max_subtotal; ?>"><?php echo $entry_max_subtotal; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="reward_max_subtotal" value="<?php echo $reward_max_subtotal; ?>" placeholder="<?php echo $entry_max_subtotal; ?>" id="input-max-subtotal" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-interval"><span data-toggle="tooltip" title="<?php echo $help_interval; ?>"><?php echo $entry_interval; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="reward_interval" value="<?php echo $reward_interval; ?>" placeholder="<?php echo $entry_interval; ?>" id="input-interval" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="reward_status" id="input-status" class="form-control">
                <?php if ($reward_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="reward_sort_order" value="<?php echo $reward_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>