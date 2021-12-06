<?= $header; ?>
<div class="container">
	<ul class="breadcrumb space-30">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?= $breadcrumb['href']; ?>">
				<?= $breadcrumb['text']; ?>
			</a></li>
		<?php } ?>
	</ul>
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
			<div class="panel-heading space-25">
				<h1 class="panel-title panel-v1">
					<?= $heading_title; ?>
				</h1>
			</div>
			<?= $text_message; ?>
			<?php if (isset($text_account_info)) { ?>
				<br>
			<?= $text_account_info ?>
			<?php } ?>
			<div class="buttons space-top-20 space-30 clearfix">
				<div class="pull-right"><a href="<?= $continue; ?>" class="btn btn-primary btn-v1">
						<?= $button_continue; ?>
					</a></div>
			</div>
			<?= $content_bottom; ?>
		</div>
		<?= $column_right; ?>
	</div>
</div>
<?= $footer; ?>