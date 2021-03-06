<?php  echo $header; ?>
<?php require( ThemeControlHelper::getLayoutPath( 'common/mass-header.tpl' )  ); ?>
<?php  
    $config = $sconfig;
    $theme  = $themename;
      $themeConfig = (array)$config->get('themecontrol');
  ?>

<div class="main-columns container">
	<?php require( ThemeControlHelper::getLayoutPath( 'common/mass-container.tpl' )  ); ?>
	<div class="row">
		<?php if( $SPAN[0] ): ?>
		<aside id="sidebar-left" class="col-md-<?php echo $SPAN[0];?>">
			<?php echo $column_left; ?>
		</aside>
		<?php endif; ?> 
		<div id="sidebar-main" class="col-md-<?php echo $SPAN[1];?>">
			<div id="content">
				<?php echo $content_top; ?>
				<div id="contact-map" class="contact-location col-lg-12 col-md-12 col-sm-12 hidden-xs"></div>
				<?php if ($locations) { ?>
					<h3><?php echo $text_store; ?></h3>
					<div class="panel-group" id="accordion">
						<?php foreach ($locations as $location) { ?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#collapse-location<?php echo $location['location_id']; ?>" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><?php echo $location['name']; ?> <i class="fa fa-caret-down"></i></a></h4>
								</div>
								<div class="panel-collapse collapse" id="collapse-location<?php echo $location['location_id']; ?>">
									<div class="panel-body">
										<div class="row">
											<?php if ($location['image']) { ?>
												<div class="col-sm-3"><img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>" title="<?php echo $location['name']; ?>" class="img-thumbnail" /></div>
											<?php } ?>
											<div class="col-sm-3">
												<strong><?php echo $location['name']; ?></strong><br />
												<address>
													<?php echo $location['address']; ?>
												</address>
												<?php if ($location['geocode']) { ?>
													<a href="https://maps.google.com/maps?q=<?php echo urlencode($location['geocode']); ?>&hl=en&t=m&z=15" target="_blank" class="btn btn-info"><i class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
												<?php } ?>
											</div>
											<div class="col-sm-3">
												<strong><?php echo $text_telephone; ?></strong><br>
												<?php echo $location['telephone']; ?><br />
												<br />
												<?php if ($location['fax']) { ?>
													<strong><?php echo $text_fax; ?></strong><br>
													<?php echo $location['fax']; ?>
												<?php } ?>
											</div>
											<div class="col-sm-3">
												<?php if ($location['open']) { ?>
													<strong><?php echo $text_open; ?></strong><br />
													<?php echo $location['open']; ?><br />
													<br />
												<?php } ?>
												<?php if ($location['comment']) { ?>
													<strong><?php echo $text_comment; ?></strong><br />
													<?php echo $location['comment']; ?>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal space-50 content-contact" id="form-contact">
        <div class="row">
              <?php 
                $html = html_entity_decode($themeConfig['contact_customhtml'][$config->get('config_language_id')]);
                $c = 0;
                $c2 = 8;
              
              ?>
              <fieldset class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
					<h3 class="title-form">
						<?php echo $text_contact; ?>
					</h3>
                <div class="form-group required">
                  <label class="col-sm-3 control-label" for="input-name"><?php echo $entry_name; ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
                    <?php if ($error_name) { ?>
                    <div class="text-danger"><?php echo $error_name; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label" for="input-email"><?php echo $entry_email; ?></label>
                  <div class="col-sm-9">
                    <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
                    <?php if ($error_email) { ?>
                    <div class="text-danger"><?php echo $error_email; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
                  <div class="col-sm-9">
                    <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
                    <?php if ($error_enquiry) { ?>
                    <div class="text-danger"><?php echo $error_enquiry; ?></div>
                    <?php } ?>
                  </div>
                </div>
<?php echo $captcha; ?>
                 <div class="buttons">
                  <div class="pull-right">
                    <input class="btn btn-v1" type="submit" value="<?php echo $button_submit; ?>" id="button-contact" />
										<!-- <button class="g-recaptcha btn btn-v1" data-sitekey="6LeF4gIfAAAAAByA227JIy95iATZ_pgALw4TN9dA" data-callback='onSubmit' data-action='submit'>Submit</button> -->

                  </div>
                </div>
              </fieldset>

              <fieldset class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<h3 class="title-us"><?php echo $heading_title; ?></h3>
                    <div class="contact-customhtml">
                      <div class="content">
                          
                          <div class="panel-contact-info">
                            <div class="col-sm-12 space-30">
                                <?php if ($image) { ?>
                                <div class="text-center"><img src="<?php echo $image; ?>" alt="<?php echo $store; ?>" title="<?php echo $store; ?>" class="img-thumbnail" /></div>
                                <?php } ?>
                     
                                    <div class="media">
                                      <div class="media-icon pull-left"><span class="fa fa-home fa-2x"></span></div>
                                      <div class="media-body">
                                        <h4 class="media-heading"><?php echo $store; ?></h4>
                                             <address>
                                            <?php echo $address; ?>
                                            </address>
                                            <?php if ($geocode) { ?>
                                            <a href="https://maps.google.com/maps?q=<?php echo urlencode($geocode); ?>&hl=en&t=m&z=15" target="_blank" class="btn btn-info"><i class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
                                            <?php } ?>
                                      </div>
                                    </div>

                                   <?php if ($open) { ?>
                                    <div class="media">
                                      <div class="media-icon pull-left"><span class="fa fa-clock-o fa-2x"></span></div>
                                      <div class="media-body">
                                        <h4 class="media-heading"><?php echo $text_open; ?></h4>
                                            <?php echo $open; ?>
                                      </div>
                                    </div>
                                    <?php } ?>
                                    <div class="media">
                                      <div class="media-icon pull-left"><span class="fa fa-phone fa-2x"></span></div>
                                      <div class="media-body">
                                        <h4 class="media-heading"><?php echo $text_telephone; ?></h4>
                                            <?php echo $telephone; ?>
                                      </div>
                                    </div>
                                    <div class="media">
                                      <div class="media-icon pull-left"><span class="fa fa-fax fa-2x"></span></div>
                                      <div class="media-body">
                                        <h4 class="media-heading"><?php echo $text_fax; ?></h4>
                                            <?php echo $fax; ?>
                                      </div>
                                    </div>
                             <!-- Bonk: Additional Contact Info -->
                                    <div class="media">
                                      <div class="media-icon pull-left"><span class="fa fa-whatsapp fa-2x"></span></div>
                                      <div class="media-body">
                                        <h4 class="media-heading"><?php echo $text_wa; ?></h4>
                                            <?php echo $wa; ?>
                                      </div>
                                    </div>

									<?php if ($comment) { ?>
                                    <div class="media">
                                      <div class="media-icon pull-left"><span class="fa fa-phone fa-2x"></span></div>
                                      <div class="media-body">
                                        <h4 class="media-heading"><?php echo $text_comment; ?></h4>
                                            <?php echo $comment; ?>
                                      </div>
                                    </div>
                                    <?php } ?>
                            </div>
                          </div>
                        
                          <?php if( !empty($html) ) { ?>
                           <div class="panel-contact-custom">  
                            <?php echo $html; ?>
                           </div>
                          <?php } ?> 

                      </div>
                    </div>
              </fieldset>
			  
        </div>      
       
      </form>
      <?php echo $content_bottom; ?></div>
   </div> 
<?php if( $SPAN[2] ): ?>
	<aside id="sidebar-right" class="col-md-<?php echo $SPAN[2];?>">	
		<?php echo $column_right; ?>
	</aside>
<?php endif; ?></div>
</div>
<!-- <script>
	function onSubmit(token) {
		document.getElementById('form-contact').submit();
	}
</script>
  -->
<?php echo $footer; ?>
