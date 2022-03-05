<h5><?php echo $text_greeting;?></h5>
<?php if ($user_point_status) { ?>
	<div class="user-point">
		<table>
			<?php if ($reward_status) { ?>
				<tr><td class="text-left"><a href="<?php echo $reward; ?>"><?php echo $text_reward;?></a></td><td class="text-right"><?php echo $poin_reward;?></td></tr>
			<?php } ?>
			<?php if ($balance_status) { ?>
				<tr><td class="text-left"><a href="<?php echo $balance; ?>"><?php echo $text_balance;?></a></td><td class="text-right"><?php echo $poin_balance;?></td></tr>
			<?php } ?>
			<?php if ($cashback_status) { ?>
				<tr><td class="text-left"><span data-toggle="tooltip" title="<?php echo $help_cashback; ?>"><?php echo $text_cashback;?></span></td><td class="text-right price"><?php echo $poin_cashback;?></td></tr>
			<?php } ?>
		</table>
	</div>
<?php } else { ?>
	<?php if ($google_login) { ?>
		<div class="pl-10">
			<a href="<?= $login; ?>">
				<img src="<?= $google_button; ?>" alt="google_button" class="img-responsive btn-image w-70">
			</a>
			<small><?php echo $text_sign_in;?></small>
		</div>
		<?php } ?>
	<?php } ?>
