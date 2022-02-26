<?= $header; ?><?= $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?= $invoice; ?>" target="_blank" data-toggle="tooltip" title="<?= $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></a> <a href="<?= $shipping; ?>" target="_blank" data-toggle="tooltip" title="<?= $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></a> <a href="<?= $edit; ?>" data-toggle="tooltip" title="<?= $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?= $cancel; ?>" data-toggle="tooltip" title="<?= $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?= $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> <?= $text_order_detail; ?></h3>
          </div>
          <table class="table">
            <tbody>
              <tr>
                <td style="width: 1%;"><button data-toggle="tooltip" title="<?= $text_store; ?>" class="btn btn-info btn-xs"><i class="fa fa-shopping-cart fa-fw"></i></button></td>
                <td><a href="<?= $store_url; ?>" target="_blank"><?= $store_name; ?></a></td>
              </tr>
              <tr>
                <td><button data-toggle="tooltip" title="<?= $text_date_added; ?>" class="btn btn-info btn-xs"><i class="fa fa-calendar fa-fw"></i></button></td>
                <td><?= $date_added; ?></td>
              </tr>
              <tr>
                <td><button data-toggle="tooltip" title="<?= $text_payment_method; ?>" class="btn btn-info btn-xs"><i class="fa fa-credit-card fa-fw"></i></button></td>
                <td><?= $payment_method; ?></td>
              </tr>
              <?php if ($shipping_method) { ?>
              <tr>
                <td><button data-toggle="tooltip" title="<?= $text_shipping_method; ?>" class="btn btn-info btn-xs"><i class="fa fa-truck fa-fw"></i></button></td>
                <td><?= $shipping_method; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> <?= $text_customer_detail; ?></h3>
          </div>
          <table class="table">
            <tr>
              <td style="width: 1%;"><button data-toggle="tooltip" title="<?= $text_customer; ?>" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i></button></td>
              <td><?php if ($customer) { ?>
                <a href="<?= $customer; ?>" target="_blank"><?= $firstname; ?> <?= $lastname; ?></a>
                <?php } else { ?>
                <?= $firstname; ?> <?= $lastname; ?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><button data-toggle="tooltip" title="<?= $text_customer_group; ?>" class="btn btn-info btn-xs"><i class="fa fa-group fa-fw"></i></button></td>
              <td><?= $customer_group; ?></td>
            </tr>
            <tr>
              <td><button data-toggle="tooltip" title="<?= $text_email; ?>" class="btn btn-info btn-xs"><i class="fa fa-envelope-o fa-fw"></i></button></td>
              <td><a href="mailto:<?= $email; ?>"><?= $email; ?></a></td>
            </tr>
            <tr>
              <td><button data-toggle="tooltip" title="<?= $text_telephone; ?>" class="btn btn-info btn-xs"><i class="fa fa-phone fa-fw"></i></button></td>
              <td><?= $telephone; ?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cog"></i> <?= $text_option; ?></h3>
          </div>
          <table class="table">
            <tbody>
              <tr>
                <td><?= $text_invoice; ?></td>
				<td id="invoice" class="text-right">
                <?php if ($invoice_no) { ?>
				  <?= $invoice_prefix . $invoice_no; ?>
				<?php } ?></td>
                <td style="width: 1%;" class="text-center">
				  <button id="button-invoice" data-loading-text="<?= $text_loading; ?>" data-toggle="tooltip" title="<?= $button_edit; ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>
                </td>
              </tr>
              <tr>
                <td><?= $text_reward; ?></td>
                <td class="text-right"><?= $reward; ?></td>
                <td class="text-center"><?php if ($customer && $reward) { ?>
                  <?php if (!$reward_total) { ?>
					<!--Bonk05-->
					<?php if ($complete_status) { ?>
					  <button id="button-reward-add" data-loading-text="<?= $text_loading; ?>" data-toggle="tooltip" title="<?= $button_reward_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
					<?php } else { ?>
					  <button disabled="disabled" data-toggle="tooltip" title="<?= $button_uncomplete_status; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
					<?php } ?>
                  <?php } else { ?>
                    <button id="button-reward-remove" data-loading-text="<?= $text_loading; ?>" data-toggle="tooltip" title="<?= $button_reward_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>
                  <?php } ?>
                <?php } else { ?>
                  <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                <?php } ?></td>
              </tr>
			  <!--Bonk04-->
              <?php if ($cashback_status) { ?>
              <tr>
                <td><?= $text_cashback; ?></td>
                <td class="text-right"><?= $cashback; ?>
					<?php if ($error_cashback) { ?>
					  <span class="text-danger"><?= $error_cashback; ?></span>
					<?php } ?>
				</td>
                <td class="text-center"><?php if ($customer && $cashback_point) { ?>
                  <?php if (!$cashback_total) { ?>
					<?php if ($complete_status) { ?>
					  <button id="button-cashback-add" data-loading-text="<?= $text_loading; ?>" data-toggle="tooltip" title="<?= $button_cashback_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
					<?php } else { ?>
					  <button disabled="disabled" data-toggle="tooltip" title="<?= $button_uncomplete_status; ?>" class="btn btn-success btn-xs"><i class="fa fa-minus-circle"></i></button>
					<?php } ?>
                  <?php } else { ?>
                    <button disabled="disabled" id="button-cashback-remove" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>
                  <?php } ?>
                <?php } else { ?>
                  <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                <?php } ?></td>
              </tr>
              <?php } ?>
			  <!--Bonk04:End-->
              <tr>
                <td><?= $text_affiliate; ?>
                  <?php if ($affiliate) { ?>
                  (<a href="<?= $affiliate; ?>"><?= $affiliate_firstname; ?> <?= $affiliate_lastname; ?></a>)
                  <?php } ?></td>
                <td class="text-right"><?= $commission; ?></td>
                <td class="text-center"><?php if ($affiliate) { ?>
                  <?php if (!$commission_total) { ?>
                  <button id="button-commission-add" data-loading-text="<?= $text_loading; ?>" data-toggle="tooltip" title="<?= $button_commission_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                  <?php } else { ?>
                  <button id="button-commission-remove" data-loading-text="<?= $text_loading; ?>" data-toggle="tooltip" title="<?= $button_commission_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>
                  <?php } ?>
                  <?php } else { ?>
                  <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                  <?php } ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle"></i> <?= $text_order; ?></h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td style="width: 50%;" class="text-left"><?= $text_payment_address; ?></td>
              <?php if ($shipping_method) { ?>
              <td style="width: 50%;" class="text-left"><?= $text_shipping_address; ?>
                <?php } ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left"><?= $payment_address; ?></td>
              <?php if ($shipping_method) { ?>
              <td class="text-left"><?= $shipping_address; ?></td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td class="text-left"><?= $column_product; ?></td>
              <td class="text-left"><?= $column_model; ?></td>
              <td class="text-right"><?= $column_quantity; ?></td>
              <td class="text-right"><?= $column_price; ?></td>
              <td class="text-right"><?= $column_total; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-left"><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                <?php if ($option['type'] != 'file') { ?>
                &nbsp;<small> - <?= $option['name']; ?>: <?= $option['value']; ?></small>
                <?php } else { ?>
                &nbsp;<small> - <?= $option['name']; ?>: <a href="<?= $option['href']; ?>"><?= $option['value']; ?></a></small>
                <?php } ?>
                <?php } ?></td>
              <td class="text-left"><?= $product['model']; ?></td>
              <td class="text-right"><?= $product['quantity']; ?></td>
              <td class="text-right"><?= $product['price']; ?></td>
              <td class="text-right"><?= $product['total']; ?></td>
            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><a href="<?= $voucher['href']; ?>"><?= $voucher['description']; ?></a></td>
              <td class="text-left"></td>
              <td class="text-right">1</td>
              <td class="text-right"><?= $voucher['amount']; ?></td>
              <td class="text-right"><?= $voucher['amount']; ?></td>
            </tr>
            <?php } ?>
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td colspan="4" class="text-right"><?= $total['title']; ?></td>
              <td class="text-right"><?= $total['text']; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php if ($comment) { ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td><?= $text_comment; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= $comment; ?></td>
            </tr>
          </tbody>
        </table>
        <?php } ?>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-comment-o"></i> <?= $text_history; ?></h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-history" data-toggle="tab"><?= $tab_history; ?></a></li>
          <li><a href="#tab-additional" data-toggle="tab"><?= $tab_additional; ?></a></li>
          <?php foreach ($tabs as $tab) { ?>
          <li><a href="#tab-<?= $tab['code']; ?>" data-toggle="tab"><?= $tab['title']; ?></a></li>
          <?php } ?>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-history">
            <div id="history"></div>
            <br />
            <fieldset>
              <legend><?= $text_history_add; ?></legend>
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-order-status"><?= $entry_order_status; ?></label>
                  <div class="col-sm-10">
                    <select name="order_status_id" id="input-order-status" class="form-control">
                      <?php foreach ($order_statuses as $order_statuses) { ?>
                      <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
                      <option value="<?= $order_statuses['order_status_id']; ?>" selected="selected"><?= $order_statuses['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?= $order_statuses['order_status_id']; ?>"><?= $order_statuses['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-override"><span data-toggle="tooltip" title="<?= $help_override; ?>"><?= $entry_override; ?></span></label>
                  <div class="col-sm-10">
                    <input type="checkbox" name="override" value="1" id="input-override" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-notify"><?= $entry_notify; ?></label>
                  <div class="col-sm-10">
                    <input type="checkbox" name="notify" value="1" id="input-notify" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-comment"><?= $entry_comment; ?></label>
                  <div class="col-sm-10">
                    <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                  </div>
                </div>
              </form>
            </fieldset>
            <div class="text-right">
              <button id="button-history" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?= $button_history_add; ?></button>
            </div>
          </div>
          <div class="tab-pane" id="tab-additional">
            <?php if ($account_custom_fields) { ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?= $text_account_custom_field; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($account_custom_fields as $custom_field) { ?>
                <tr>
                  <td><?= $custom_field['name']; ?></td>
                  <td><?= $custom_field['value']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <?php if ($payment_custom_fields) { ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?= $text_payment_custom_field; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($payment_custom_fields as $custom_field) { ?>
                <tr>
                  <td><?= $custom_field['name']; ?></td>
                  <td><?= $custom_field['value']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <?php if ($shipping_method && $shipping_custom_fields) { ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?= $text_shipping_custom_field; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($shipping_custom_fields as $custom_field) { ?>
                <tr>
                  <td><?= $custom_field['name']; ?></td>
                  <td><?= $custom_field['value']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?= $text_browser; ?></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?= $text_ip; ?></td>
                  <td><?= $ip; ?></td>
                </tr>
                <?php if ($forwarded_ip) { ?>
                <tr>
                  <td><?= $text_forwarded_ip; ?></td>
                  <td><?= $forwarded_ip; ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td><?= $text_user_agent; ?></td>
                  <td><?= $user_agent; ?></td>
                </tr>
                <tr>
                  <td><?= $text_accept_language; ?></td>
                  <td><?= $accept_language; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <?php foreach ($tabs as $tab) { ?>
          <div class="tab-pane" id="tab-<?= $tab['code']; ?>"><?= $tab['content']; ?></div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
$(document).delegate('#button-ip-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=user/api/addip&token=<?= $token; ?>&api_id=<?= $api_id; ?>',
		type: 'post',
		data: 'ip=<?= $api_ip; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-ip-add').button('loading');
		},
		complete: function() {
			$('#button-ip-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

//Bonk11
$(document).delegate('#button-invoice', 'click', function() {
	$('#invoice').html('<?= $invoice_prefix; ?><input type="text" name="set_invoice_no" value="<?= $invoice_no; ?>" size="10" />');
	
	$('#button-invoice').replaceWith('<button id="button-set-invoice" data-loading-text="<?= $text_loading; ?>" data-toggle="tooltip" title="<?= $button_save; ?>" class="btn btn-success btn-xs"><i class="fa fa-floppy-o"></i></button>');
});

$(document).delegate('#button-set-invoice', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/setinvoiceno&token=<?= $token; ?>&order_id=<?= $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'set_invoice_no=' + encodeURIComponent($('input[name=\'set_invoice_no\']').val()),
		beforeSend: function() {
			$('#button-invoice').button('loading');
		},
		complete: function() {
			$('#button-invoice').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['invoice_no']) {
				$('#invoice').html(json['invoice_no']);

				$('#button-set-invoice').replaceWith('<button id="button-invoice" data-loading-text="<?= $text_loading; ?>" data-toggle="tooltip" title="<?= $button_edit; ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
	
});

$(document).delegate('#button-reward-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addreward&token=<?= $token; ?>&order_id=<?= $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-add').button('loading');
		},
		complete: function() {
			$('#button-reward-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-reward-add').replaceWith('<button id="button-reward-remove" data-toggle="tooltip" title="<?= $button_reward_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-reward-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removereward&token=<?= $token; ?>&order_id=<?= $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-remove').button('loading');
		},
		complete: function() {
			$('#button-reward-remove').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-reward-remove').replaceWith('<button id="button-reward-add" data-toggle="tooltip" title="<?= $button_reward_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

//Bonk04
$(document).delegate('#button-cashback-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addcashback&token=<?= $token; ?>&order_id=<?= $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-cashback-add').button('loading');
		},
		complete: function() {
			$('#button-cashback-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-cashback-add').replaceWith('<button disabled="disabled" id="button-cashback-remove" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addcommission&token=<?= $token; ?>&order_id=<?= $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-add').button('loading');
		},
		complete: function() {
			$('#button-commission-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-commission-add').replaceWith('<button id="button-commission-remove" data-toggle="tooltip" title="<?= $button_commission_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removecommission&token=<?= $token; ?>&order_id=<?= $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-remove').button('loading');
		},
		complete: function() {
			$('#button-commission-remove').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-commission-remove').replaceWith('<button id="button-commission-add" data-toggle="tooltip" title="<?= $button_commission_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

var token = '';

// Login to the API
$.ajax({
	url: '<?= $store_url; ?>index.php?route=api/login',
	type: 'post',
	dataType: 'json',
	data: 'key=<?= $api_key; ?>',
	crossDomain: true,
	success: function(json) {
		$('.alert').remove();

        if (json['error']) {
    		if (json['error']['key']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['key'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		}

            if (json['error']['ip']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['ip'] + ' <button type="button" id="button-ip-add" data-loading-text="<?= $text_loading; ?>" class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> <?= $button_ip_add; ?></button></div>');
    		}
        }

        if (json['token']) {
			token = json['token'];
		}
	},
	error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}
});

$('#history').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#history').load(this.href);
});

$('#history').load('index.php?route=sale/order/history&token=<?= $token; ?>&order_id=<?= $order_id; ?>');

$('#button-history').on('click', function() {
	if (typeof verifyStatusChange == 'function'){
		if (verifyStatusChange() == false){
			return false;
		} else{
			addOrderInfo();
		}
	} else{
		addOrderInfo();
	}

	$.ajax({
		url: '<?= $store_url; ?>index.php?route=api/order/history&token=' + token + '&order_id=<?= $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&override=' + ($('input[name=\'override\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val())  + '&user_id=<?= $user_id; ?>',//Bonk01
		beforeSend: function() {
			$('#button-history').button('loading');
		},
		complete: function() {
			$('#button-history').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#history').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#history').load('index.php?route=sale/order/history&token=<?= $token; ?>&order_id=<?= $order_id; ?>');

				$('#history').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('textarea[name=\'comment\']').val('');

			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function changeStatus(){
	var status_id = $('select[name="order_status_id"]').val();

	$('#openbay-info').remove();

	$.ajax({
		url: 'index.php?route=extension/openbay/getorderinfo&token=<?= $token; ?>&order_id=<?= $order_id; ?>&status_id=' + status_id,
		dataType: 'html',
		success: function(html) {
			$('#history').after(html);
		}
	});
}

function addOrderInfo(){
	var status_id = $('select[name="order_status_id"]').val();

	$.ajax({
		url: 'index.php?route=extension/openbay/addorderinfo&token=<?= $token; ?>&order_id=<?= $order_id; ?>&status_id=' + status_id,
		type: 'post',
		dataType: 'html',
		data: $(".openbay-data").serialize()
	});
}

$(document).ready(function() {
	changeStatus();
});

$('select[name="order_status_id"]').change(function(){
	changeStatus();
});
</script> 
</div>
<?= $footer; ?> 