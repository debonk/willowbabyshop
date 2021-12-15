<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title"><a href="#collapse-reward" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><?php echo $heading_title; ?> <i class="fa fa-caret-down"></i></a></h4>
  </div>
  <div id="collapse-reward" class="panel-collapse collapse">
    <div class="panel-body">
      <label class="col-sm-2 control-label" for="input-reward"><?php echo $entry_reward; ?></label>
			<!--Bonk-->	  
			<div class="col-sm-10 form-group">
				<select name="reward" id="input-reward" class="form-control">
					<?php foreach ($set_rewards as $set_reward) { ?>
									<?php if ($set_reward == $reward) { ?>
										<option value="<?php echo $set_reward; ?>" selected="selected"><?php echo $set_reward; ?></option>
									<?php } else { ?>
										<option value="<?php echo $set_reward; ?>"><?php echo $set_reward; ?></option> 
									<?php } ?>
			<?php } ?>
			</select>

		</div>
		<div>   
			 <input type="submit" value="<?php echo $button_reward; ?>" id="button-reward" data-loading-text="<?php echo $text_loading; ?>"  class="btn btn-primary" />
			</div>
      <script type="text/javascript">
$('#button-reward').on('click', function() {
	$.ajax({
		url: 'index.php?route=total/reward/reward',
		type: 'post',
		data: 'reward=' + encodeURIComponent($('select[name=\'reward\']').val()),
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward').button('loading');
		},
		complete: function() {
			$('#button-reward').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('.breadcrumb').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}

			if (json['redirect']) {
				location = json['redirect'];
			}
		}
	});
});
</script>
    </div>
  </div>
</div>