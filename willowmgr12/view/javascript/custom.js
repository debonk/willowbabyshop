/* function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
} */

$(document).ready(function () {
	// Image Manager
	$(document).delegate('a[data-toggle=\'image\']', 'click', function (e) {
		var node = this;

		// let input_image_html = '<div class="input-group"><input type="text" name="image_url" value="" placeholder="Url" id="input-image-url" class="form-control"> <div class="input-group-btn"><button class="btn btn-default" type="button" id="button-image-url"><i class="fa fa-check"></i></button></div></div>';
		let html = ' <button class="btn btn-primary" type="button" id="button-get-url"><i class="fa fa-pencil-square-o"></i></button>';

		$('.popover-content').append(html);
		console.log(node);

		// var node = this;
		$('#button-get-url').on('click', function () {
			let input_html = '<div class="input-group"><input type="text" name="image_url" value="" placeholder="Url" id="input-image-url" class="form-control"> <div class="input-group-btn"><button class="btn btn-success" type="button" id="button-image-url"><i class="fa fa-check"></i></button></div></div>';

			$('.popover-content').html(input_html);


			// $('#button-image-url').on('click', function() {
			// let image_url = encodeURIComponent($('#input-image-url').val());

			console.log(image_url);

			// $(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));

				// $(element).parent().find('input').attr('value', '');

				// $(element).popover('hide', function() {
				// 	$('.popover').remove();
				// });
			// });

			// $.ajax({
			// 	url: 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
			// 	dataType: 'html',
			// 	beforeSend: function () {
			// 		$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
			// 		$('#button-image').prop('disabled', true);
			// 	},
			// 	complete: function () {
			// 		$('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
			// 		$('#button-image').prop('disabled', false);
			// 	},
			// 	success: function (html) {
			// 		$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

			// 		$('#modal-image').modal('show');
			// 	}
			// });
			// });

			// $(node).popover('hide', function() {
			// 	$('.popover').remove();
			// });
			// });


			// $('.popover-content button').on('click', function () {
			// 	var node = this;
			// 	console.log($(node).parent().find('input').attr('id'));

			// $('.popover-content #input-image-url').remove();
		});

	});


	// tooltips on hover
	// $('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

	// Makes tooltips work on ajax generated content
	// $(document).ajaxStop(function() {
	// 	$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	// });

	// https://github.com/opencart/opencart/issues/2595
	// $.event.special.remove = {
	// 	remove: function(o) {
	// 		if (o.handler) {
	// 			o.handler.apply(this, arguments);
	// 		}
	// 	}
	// }

	// $('[data-toggle=\'tooltip\']').on('remove', function() {
	// 	$(this).tooltip('destroy');
	// });
});
