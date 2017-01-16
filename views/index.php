<?php include('content/themes/' . THEME . '/includes/header.php'); ?>

<div class="container">
	<br/>
	<h2 class="form-signin-heading"><i class="fa fa-phone"></i> Contact Us</h2>

	<div id="signup-form" style="margin-top:0px;">
		<p><?php if(isset($plugin_data->email)) echo "<b>Email:</b> " . $plugin_data->email;  if(isset($plugin_data->phone)) echo " <b>Phone:</b> " .$plugin_data->phone; if(isset($plugin_data->address)) echo " <b>Address:</b> " .$plugin_data->address;?></p>

	<div class="row" id="contact-form" style="margin-top:0px;">

	  <form method="POST" action="<?= ($settings->enable_https) ? secure_url('contact_send') : URL::to('contact_send');  ?>" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="contact-form">
			<input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
	      <div class="panel panel-default">

	        <div class="panel-heading">

	          <div class="row">
	                  <h1 class="panel-title col-lg-12 col-md-12"><?php if(isset($plugin_data->header_text)) echo $plugin_data->header_text; ?></h1>
	          </div>

	        </div><!-- .panel-heading -->

	        <div class="panel-body">

	          <fieldset>

	            <?php if (!empty($errors) && !empty($errors->first('fullname'))): ?>
	                <div class="alert alert-danger"><?= $errors->first('fullname'); ?></div>
	            <?php endif; ?>
	            <!-- Text input-->
	            <div class="form-group row">
	                <label class="col-md-4 control-label" for="fullname">Full Name</label>

	                <div class="col-md-8">
	                  <input type="text" class="form-control" id="fullname" name="fullname" value="<?= old('fullname'); ?>" />
	                </div>
	            </div>



	            <?php if (!empty($errors) && !empty($errors->first('email'))): ?>
	                <div class="alert alert-danger"><?= $errors->first('email'); ?></div>
	            <?php endif; ?>
	            <!-- Text input-->
	            <div class="form-group row">
	                <label class="col-md-4 control-label" for="email">Email Address</label>

	                <div class="col-md-8">
	                    <input type="text" class="form-control" id="email" name="email" value="<?= old('email'); ?>">
	                </div>
	            </div>
							<?php if (!empty($errors) && !empty($errors->first('subject'))): ?>
									<div class="alert alert-danger"><?= $errors->first('subject'); ?></div>
							<?php endif; ?>
							<div class="form-group row">
									<label class="col-md-4 control-label" for="subject">Subject</label>

									<div class="col-md-8">
											<input type="text" class="form-control" id="subject" name="subject" value="<?= old('subject'); ?>">
									</div>
							</div>

	            <?php if (!empty($errors) && !empty($errors->first('message'))): ?>
	                <div class="alert alert-danger"><?= $errors->first('message'); ?></div>
	            <?php endif; ?>
	            <!-- Text Area-->
	            <div class="form-group row">
	                <label class="col-md-4 control-label" for="message">Message</label>

	                <div class="col-md-8">
	                    <textarea rows="5" class="form-control" id="message" name="message"></textarea>
	                </div>
	            </div>

	        </fieldset>
	      </div><!-- .panel-body -->

	      <div class="panel-footer clearfix">
	        <div class="pull-left col-md-7 terms" style="padding-left: 0;"></div>

	          <div class="pull-right sign-up-buttons">
	            <button class="btn btn-primary" type="submit" name="send_mail" id="send_mail">Send Mail</button>
	          </div>


	      </div><!-- .panel-footer -->

	    </div><!-- .panel -->

	  </form>


	</div><!-- #signup-form -->
	<br />
</div>
</div>

<?php include('content/themes/' . THEME . '/includes/footer.php'); ?>

	  <script type="text/javascript">

		jQuery(function($) {
				var send_mail = $('#send_mail');
				send_mail.click(function(e) {
						e.preventDefault();

						$.ajax({
								url: '/contact_send',
								method: 'post',
								data: 'fullname=' + $('#fullname').val() + '&email=' + $('#email').val() + '&subject=' + $('#subject').val() + '&message=' + $('#message').val()+ '&_token=' + $('input[name="_token"]').val(),
								context: this,
								beforeSend: function() {
										send_mail.attr('disabled', 'disabled');
								},
								success: function(r) {
										var m, x, note = '', fields = ['note', 'fullname', 'email', 'subject', 'message'];

										try {
												m = $.parseJSON(r);
										}
										catch (e) {
												noty({text: 'Sorry, there was an error sending your mail.', layout: 'top', type: 'error', timeout:1300 });
												return false;
										}

										if(m.note_type == 'error') { // compares with first element
												for(x in fields)
														if(fields[x] in m)
																note += '<br>' + m[fields[x]][0];

												noty({text: note, layout: 'top', type: 'error', timeout:2500 });
												return false;
										}else{
											// Clear the form.
											$('#fullname').val('');
											$('#email').val('');
											$('#message').val('');
											$('#subject').val('');
											noty({text: m.note, layout: 'top', type: 'success', timeout:2500 });
											return false;
										}

										var custom = document.createElement('input');
										custom.type = 'hidden';
										custom.name = 'custom';
										custom.value = m; // parseJSON parses INTs
										$(this).before(custom);
										this.closest('form').submit();
								},
								complete: function() {
										send_mail.removeAttr('disabled');
								}
						});

				});
		});
	    // ...
	  </script>
