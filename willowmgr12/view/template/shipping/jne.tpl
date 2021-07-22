<?php
/**********************************************
*                                             *
*    JNE SHIPPING BASED ON POST / ZIP CODE    *
*        Copyright 2015 by Bestariweb         *
*    Webdesign:  http://www.bestariweb.com    *
*  Webdesign:  http://www.bestariwebhost.com  *
*                                             *
**********************************************/

?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-jne" onclick="$('#form').submit();" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
      <!-- Navigasi TAB /-->
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <ul class="nav nav-tabs main">
          <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
          <?php foreach ($geo_zones as $geo_zone) { ?>
          <li><a href="#tab-geo-zone<?php echo $geo_zone['geo_zone_id']; ?>" data-toggle="tab"><?php echo $geo_zone['name']; ?></a></li>
          <?php } ?>
        </ul>
      <!-- End Of Navigasi TAB /-->

        <div class="tab-content" >
          <div id="tab-general" class="tab-pane active">
            <div class="row">
            <div class="col-sm-6 form-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><?php echo $tab_general." Setting"; ?></h3>
              </div>
            <div class="panel-body">
             
                <label class="control-label"><?php echo $entry_tax_class; ?></label>
                <select name="jne_tax_class_id" class="form-control">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php foreach ($tax_classes as $tax_class) { ?>
                    <?php if ($tax_class['tax_class_id'] == $jne_tax_class_id) { ?>
                    <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
              
              
                <label class="control-label"><?php echo $entry_status; ?></label>
                <select name="jne_status" class="form-control">
                    <?php if ($jne_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
              
              
                <label class="control-label"><?php echo $entry_sort_order; ?></label>
                <input class="form-control" type="text" name="jne_sort_order" value="<?php echo $jne_sort_order; ?>" size="1" />
          </div></div>
          </div>
            <div class="col-sm-6 text-center">
              <div class="col-sm-12" style="margin-bottom:35px;"><img src="<?php echo HTTP_CATALOG."/image/logo-jne.png";?>" height="auto" width="300"></div>
              <div class="col-sm-12" style="border-top:2px solid #00a;padding-top:5px;"><img src="<?php echo HTTP_CATALOG."/image/logo-bestariweb.png";?>" height="73" width="auto"></div>
              <div class="col-sm-12">Copyright &copy; 2015 by <a href="https://www.bestariweb.com">Bestariweb Studio</a></div>

            </div>
          </div>
          </div>
          <?php foreach ($geo_zones as $geo_zone) { ?>
          <div id="tab-geo-zone<?php echo $geo_zone['geo_zone_id']; ?>" class="tab-pane">
            <div class="row"><div class="col-sm-6 form-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><?php echo $geo_zone['name']; ?> - Rate Setting</h3>
              </div>
            <div class="panel-body">

                <label class="control-label"><?php echo $entry_rate; ?></label>
                <textarea class="form-control" name="jne_<?php echo $geo_zone['geo_zone_id']; ?>_rate" cols="40" rows="5"><?php echo ${'jne_' . $geo_zone['geo_zone_id'] . '_rate'}; ?></textarea>
              
                <label class="control-label"><?php echo $entry_status; ?></label>
                <select class="form-control" name="jne_<?php echo $geo_zone['geo_zone_id']; ?>_status">
                    <?php if (${'jne_' . $geo_zone['geo_zone_id'] . '_status'}) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
              </div></div></div></div>
          </div>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="col-sm-12 text-center" >Copyright &copy;2015 by <a href="https://www.bestariwebhost.com"><b>Bestari</b>web | Web Design - Web Hosting - VPS</a></div>

</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<?php echo $footer; ?> 