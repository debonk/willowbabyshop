<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="all" />
</head>
<body>
<div class="container">
  <div style="page-break-after: always;">
     <h1><?php echo $text_report; ?></h1>
      <div class="pull-right"><?php echo $filtered; ?></div>
   <table class="table table-bordered">
      <thead>
		  <tr>
			  <td class="text-right"><?php echo $column_order_id; ?></td>
			  <td class="text-left"><?php echo $column_customer; ?></td>
			  <td class="text-left"><?php echo $column_status; ?></td>
			  <td class="text-right"><?php echo $column_total; ?></td>
			  <td class="text-left"><?php echo $column_date_added; ?></td>
			  <td class="text-left"><?php echo $column_code; ?></td>
			  <td class="text-right"><?php echo $column_amount; ?></td>
			  <td class="text-left"><?php echo $column_date_expired; ?></td>
			  <td class="text-left"><?php echo $column_cashback_status; ?></td>
			  <td class="text-right"><?php echo $column_used_order_id; ?></td>
		  </tr>
      </thead>
      <tbody>
		  <?php if ($orders) { ?>
		  <?php foreach ($orders as $order) { ?>
		  <tr>
			  <td class="text-right"><?php echo $order['order_id']; ?></td>
			  <td class="text-left"><?php echo $order['customer']; ?></td>
			  <td class="text-left"><?php echo $order['order_status']; ?></td>
			  <td class="text-right"><?php echo $order['total']; ?></td>
			  <td class="text-left"><?php echo $order['date_added']; ?></td>
			  <td class="text-left"><?php echo $order['code']; ?></td>
			  <td class="text-right"><?php echo $order['amount']; ?></td>
			  <td class="text-left"><?php echo $order['date_expired']; ?></td>
			  <td class="text-left"><?php echo $order['cashback_status']; ?></td>
			  <td class="text-right"><?php echo $order['used_order_id']; ?></td>
		</tr>
		  <?php } ?>
		  <?php } else { ?>
		  <tr>
			<td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
		  </tr>
		  <?php } ?>
      </tbody>
    </table>
	<div class="row">
	  <div class="col-sm-12 text-right"><?php echo $results; ?></div>
	</div>
  </div>
</div>
</body>
</html>