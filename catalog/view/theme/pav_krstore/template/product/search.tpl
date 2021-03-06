
<?php echo $header; ?>
<?php require( ThemeControlHelper::getLayoutPath( 'common/mass-header.tpl' )  ); ?>
<div class="container">
	<div class="row">
		<?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-sm-9'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-10 u-center-block'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?>">
			<?php echo $content_top; ?>
			<div class="criteria">
				<div class="panel-heading space-10">
					<h1 class="panel-title panel-v2"><?php echo $heading_title; ?></h1>
				</div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 space-20">
						<label class="control-label text-refine" for="input-search"><?php echo $entry_search; ?></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
					</div>
<!-- Bonk -->
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<p>
							<label class="checkbox-inline">
								<?php if ($sub_category) { ?>
									<input type="checkbox" name="sub_category" value="1" checked="checked" />
								<?php } else { ?>
									<input type="checkbox" name="sub_category" value="1" />
								<?php } ?>
								<?php echo $text_sub_category; ?>
							</label>
						</p>
						<p>
							<label class="checkbox-inline">
								<?php if ($description) { ?>
									<input type="checkbox" name="description" value="1" id="description" checked="checked" />
								<?php } else { ?>
									<input type="checkbox" name="description" value="1" id="description" />
								<?php } ?>
								<?php echo $entry_description; ?>
							</label>
						</p>
					</div>

					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="select-wrap">
							<select id="category-search" name="category_id" class="form-control">
								<option value="0"><?php echo $text_category; ?></option>
								<?php foreach ($categories as $category_1) { ?>
									<?php if ($category_1['category_id'] == $category_id) { ?>
										<option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
									<?php } ?>
									<?php foreach ($category_1['children'] as $category_2) { ?>
										<?php if ($category_2['category_id'] == $category_id) { ?>
											<option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
										<?php } ?>
										<?php foreach ($category_2['children'] as $category_3) { ?>
											<?php if ($category_3['category_id'] == $category_id) { ?>
												<option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
						<input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary btn-v1" />
					</div>

				</div>
<!--				<p>
					<label class="checkbox-inline">
						<?php if ($sub_category) { ?>
							<input type="checkbox" name="sub_category" value="1" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="sub_category" value="1" />
						<?php } ?>
						<?php echo $text_sub_category; ?>
					</label>
				</p>
				<p>
					<label class="checkbox-inline">
						<?php if ($description) { ?>
							<input type="checkbox" name="description" value="1" id="description" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="description" value="1" id="description" />
						<?php } ?>
						<?php echo $entry_description; ?>
					</label>
				</p>
				<input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary btn-v1 space-top-20" />
-->			</div>
			<div class="panel-heading space-20">
				<h2 class="panel-title panel-v2"><?php echo $text_search; ?></h2>
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
				<p class="space-30"><?php echo $text_empty; ?></p>
			<?php } ?>
			<?php echo $content_bottom; ?>
		</div>
		<?php echo $column_right; ?>
	</div>
</div>

<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';
	// url = 'search'; //Bonk: search seo url

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('select[name=\'category_id\']').trigger('change');
--></script>
<?php echo $footer; ?>