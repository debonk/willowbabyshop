<div class="<?= str_replace('_','-',$blockid); ?> <?= $blockcls;?>" id="pavo-<?= str_replace('_','-',$blockid); ?>">
	<div class="container">
		<div class="row">
			<div class="col-left col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<div class="space-15 space-top-15">
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
							<h4 class="panel-title">
								<?= $text_extra; ?>
							</h4>
						</div>
						<ul class="list-unstyled">
							<li><a href="<?= $manufacturer; ?>">
									<?= $text_manufacturer; ?>
								</a></li>
							<li><a href="<?= $voucher; ?>">
									<?= $text_voucher; ?>
								</a></li>
							<!--						  <li><a href="<?= $affiliate; ?>"><?= $text_affiliate; ?></a></li>
-->
							<li><a href="<?= $special; ?>">
									<?= $text_special; ?>
								</a></li>
						</ul>
					</div>
					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title">
								<?= $text_account; ?>
							</h4>
						</div>
						<ul class="list-unstyled">
							<li><a href="<?= $account; ?>">
									<?= $text_account; ?>
								</a></li>
							<li><a href="<?= $order; ?>">
									<?= $text_order; ?>
								</a></li>
							<li><a href="<?= $wishlist; ?>">
									<?= $text_wishlist; ?>
								</a></li>
							<!--							<li><a href="<?= $newsletter; ?>"><?= $text_newsletter; ?></a></li>
							<li><br></li>
-->
						</ul>
					</div>
					<?php if ($informations) { ?>
					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title">
								<?= $text_information; ?>
							</h4>
						</div>
						<ul class="list-unstyled">
							<?php foreach ($informations as $information) { ?>
							<li><a href="<?= $information['href']; ?>">
									<?= $information['title']; ?>
								</a></li>
							<?php } ?>
							<li><a href="<?= $blogs; ?>">
									<?= $text_blogs; ?>
								</a></li>
						</ul>
					</div>
					<?php } ?>
					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title">
								<?= $text_service; ?>
							</h4>
						</div>
						<ul class="list-unstyled">
							<li><a href="<?= $contact; ?>">
									<?= $text_contact; ?>
								</a></li>
							<!--							<li><a href="<?= $return; ?>"><?= $text_return; ?></a></li>
-->
							<li><a href="<?= $sitemap; ?>">
									<?= $text_sitemap; ?>
								</a></li>
						</ul>
					</div>
				</div>
				<div class="copyright col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix space-top-10">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right text-right">
							<div class="list-inline">
								<?php foreach($media_list as $media) { ?>
								<a href="<?= $media['link']; ?>" target="_blank" rel="nofollow"><i class="user-social-icon-list"><img
											src="<?= $media['image']; ?>" alt="<?= $media['alt']; ?>"></i></a>
								<?php } ?>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<p>
								<?php if( $helper->getConfig('enable_custom_copyright', 0) ) { ?>
								<?= html_entity_decode($helper->getConfig('copyright')); ?>
								<?php } 
								else { ?>
								<?= $powered; ?>.
								<?php } ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>