<div class="<?php echo str_replace('_','-',$blockid); ?> <?php echo $blockcls;?>" id="pavo-<?php echo str_replace('_','-',$blockid); ?>">
	<div class="container">
		<div class="row">
			<div class="col-left col-lg-3 col-md-3 col-sm-4 col-xs-12">
<!--				<div class="logo-footer space-15 space-top-15">
					<img src="catalog/view/theme/pav_krstore/image/logo.png" title="" alt="" />
				</div>
-->				<div class="space-15 space-top-15">
					<?php
						if($content=$helper->getLangConfig('widget_about_us')){
							echo $content;
						}
					?>
				</div>
				<div class="space-15 space-top-15">
					<?php
						if($content=$helper->getLangConfig('widget_business_hours')){
							echo $content;
						}
					?>
				</div>
			</div>
			<div class="col-right col-lg-9 col-md-9 col-sm-8 col-xs-12">
				<div class="row">
					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title"><?php echo $text_extra; ?></h4>
						</div>
						<ul class="list-unstyled">
						  <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
						  <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
<!--						  <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
-->						  <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
						</ul>
					</div>
					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title"><?php echo $text_account; ?></h4>
						</div>
						<ul class="list-unstyled">
							<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
							<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
							<li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
<!--							<li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
							<li><br></li>
-->						</ul>
					</div>
					<?php if ($informations) { ?>
						<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
							<div class="panel-heading">
								<h4 class="panel-title"><?php echo $text_information; ?></h4>
							</div>
							<ul class="list-unstyled">
								<?php foreach ($informations as $information) { ?>
									<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
								<?php } ?>
								<li><a href="<?php echo $blogs; ?>"><?php echo $text_blogs; ?></a></li> <!-- Bonk: Blog Button -->
								<li><a href="<?php echo $career; ?>"><?php echo $text_career; ?></a></li> <!-- Bonk: Career Button -->
							</ul>
						</div>
					<?php } ?>
					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title"><?php echo $text_service; ?></h4>
						</div>
						<ul class="list-unstyled">
							<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
<!--							<li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
-->							<li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
						</ul>
					</div>
				</div>
				<div class="copyright col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix space-top-10">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<p>
								<?php if( $helper->getConfig('enable_custom_copyright', 0) ) { ?>
									<?php echo html_entity_decode($helper->getConfig('copyright')); ?>
								<?php } 
								else { ?>
									<?php echo $powered; ?>. 
								<?php } ?>
							</p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
						
						<!-- Bonk: Social Icon List -->
						    <div class="list-inline">
								<a href="<?php echo $link_instagram; ?>" target="_blank" rel="nofollow"><i class="user-social-icon-list instagram"><i class="fa fa-instagram"></i></i></a>
								<a href="<?php echo $link_facebook; ?>" target="_blank" rel="nofollow"><i class="user-social-icon-list facebook"><i class="fa fa-facebook"></i></i></a>
								<a href="<?php echo $link_twitter; ?>" target="_blank" rel="nofollow"><i class="user-social-icon-list twitter"><i class="fa fa-twitter"></i></i></a>
								<a href="<?php echo $link_gplus; ?>" target="_blank" rel="nofollow"><i class="user-social-icon-list googleplus"><i class="fa fa-google-plus"></i></i></a>
							</div>

<!--							<img alt="" src="image/catalog/demo/payment.png" />
-->						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
