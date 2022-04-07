<?= $header; ?><?= $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-mylivechat" data-toggle="tooltip" title="<?= $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?= $cancel; ?>" data-toggle="tooltip" title="<?= $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?= $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?= $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-mylivechat" class="form-horizontal">
          <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?= $text_signup; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-code"><?= $entry_code; ?></label>
            <div class="col-sm-10">
              <textarea name="mylivechat_code" rows="5" placeholder="<?= $entry_code; ?>" id="input-code" class="form-control"><?= $mylivechat_code; ?></textarea>
              <?php if ($error_code) { ?>
              <div class="text-danger"><?= $error_code; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-position"><?= $entry_position; ?></label>
            <div class="col-sm-10">
              <select name="mylivechat_position" id="input-position" class="form-control">
                <?php if ($mylivechat_position !== 'footer') { ?>
                <option value="header" selected="selected"><?= $text_header; ?></option>
                <option value="footer"><?= $text_footer; ?></option>
                <?php } else { ?>
                <option value="header"><?= $text_header; ?></option>
                <option value="footer" selected="selected"><?= $text_footer; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?= $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="mylivechat_status" id="input-status" class="form-control">
                <?php if ($mylivechat_status) { ?>
                <option value="1" selected="selected"><?= $text_enabled; ?></option>
                <option value="0"><?= $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?= $text_enabled; ?></option>
                <option value="0" selected="selected"><?= $text_disabled; ?></option>
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