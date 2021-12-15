<?php echo $header; ?>
<div class="container">
	<ul class="breadcrumb space-30">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
		<?php $class = 'col-sm-10 u-center-block'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
		<div class="panel-heading space-20">
			<h1 class="panel-title panel-v2"><?php echo $heading_title; ?></h1>
		</div>
		<?php if ($products) { ?>
      <?php   require( ThemeControlHelper::getLayoutPath( 'product/product_filter.tpl' ) );   ?>
       <?php require( ThemeControlHelper::getLayoutPath( 'common/product_collection.tpl' ) );  ?>
				<!-- Bonk: add pagination -->
				<div class="paging row">
					<div class="col-sm-4 text-left space-top-10"><?php echo $results; ?></div>
					<div class="col-sm-8 text-right"><?php echo $pagination; ?></div>
				</div>
				
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>