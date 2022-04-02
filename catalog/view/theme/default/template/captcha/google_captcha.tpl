<style>
	.grecaptcha-badge {
		visibility: hidden;
	}
</style>
<input type="hidden" name="g-recaptcha-response" value="" id="grecaptcha">
<div><small><i>
			<?= $text_grecaptcha; ?>
		</i></small></div>
<?php if ($error_captcha) { ?>
<div class="text-danger">
	<?= $error_captcha; ?>
</div>
<?php } ?>
<script>
	let form = $('form');
	let button_id

	if (typeof $(form).attr('action') === 'undefined') {
		$(document).ready(function () {
			button_id = $(form).attr('id').replace('form', 'button');

			html = '<button type="button" id="button-grecaptcha" class="btn btn-v1"><?= $button_continue; ?></button>';

			$('#grecaptcha').after(html);

			$('button[id="' + button_id + '"').hide();
		})
	}

	grecaptcha.ready(function () {
		if (button_id) {
			$('#button-grecaptcha').on('click', function () {
				grecaptcha.execute('<?= $site_key; ?>', { action: 'form' }).then(function (token) {

					$('input[name=\'g-recaptcha-response\']').val(token);

					$('button[id="' + button_id + '"').trigger('click');
				});
			});
		} else {
			grecaptcha.execute('<?= $site_key; ?>', { action: 'form' }).then(function (token) {
				$(form).submit(function () {
					$('input[name=\'g-recaptcha-response\']').val(token);
				});
			});
		}
	});
</script>