<div id="pmpro_level-<?php echo $pmpro_level->id; ?>">
	<form id="pmpro_form" class="pmpro_form" action="" method="post">

		<input type="hidden" id="checkjavascript" name="checkjavascript" value="1" />

		<table id="pmpro_billing_address_fields" class="pmpro_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0" >
		<thead>

			<tr>
				<th><?php _e('Billing Address', 'pmpro');?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<div>
						<label for="customamount"><?php _e('Guest Amount', 'pmpro');?>*</label>
						<input id="customamount" name="customamount" type="text" class="input " size="30" value="<?php echo esc_attr($customamount)?>" />
					</div>
					<div>
						<label for="bfirstname"><?php _e('First Name', 'pmpro');?>*</label>
						<input id="bfirstname" name="bfirstname" type="text" class="input " size="30" value="<?php echo esc_attr($bfirstname)?>"  />
					</div>
					<div>
						<label for="blastname"><?php _e('Last Name', 'pmpro');?>*</label>
						<input id="blastname" name="blastname" type="text" class="input " size="30" value="<?php echo esc_attr($blastname)?>"  />
					</div>
					<div>
						<label for="baddress1"><?php _e('Address 1', 'pmpro');?></label>
						<input id="baddress1" name="baddress1" type="text" class="input " size="30" value="<?php echo esc_attr($baddress1)?>" />
					</div>
					<div>
						<label for="baddress2"><?php _e('Address 2', 'pmpro');?></label>
						<input id="baddress2" name="baddress2" type="text" class="input " size="30" value="<?php echo esc_attr($baddress2)?>" />
					</div>

				
						<div>
							<label for="bcity"><?php _e('City', 'pmpro');?></label>
							<input id="bcity" name="bcity" type="text" class="input " size="30" value="<?php echo esc_attr($bcity)?>" />
						</div>
						<div>
							<label for="bstate"><?php _e('State', 'pmpro');?></label>
							<input id="bstate" name="bstate" type="text" class="input " size="30" value="<?php echo esc_attr($bstate)?>" />
						</div>
						<div>
							<label for="bzipcode"><?php _e('Postal Code', 'pmpro');?></label>
							<input id="bzipcode" name="bzipcode" type="text" class="input " size="30" value="<?php echo esc_attr($bzipcode)?>" />
						</div>
					

					<?php
						$show_country = apply_filters("pmpro_international_addresses", true);
						if($show_country)
						{
					?>
					<div>
						<label for="bcountry"><?php _e('Country', 'pmpro');?></label>
						<select name="bcountry" class=" <?php echo pmpro_getClassForField("bcountry");?>">
							<?php
								global $pmpro_countries, $pmpro_default_country;
								if(!$bcountry)
									$bcountry = $pmpro_default_country;
								foreach($pmpro_countries as $abbr => $country)
								{
								?>
								<option value="<?php echo $abbr?>" <?php if($abbr == $bcountry) { ?>selected="selected"<?php } ?>><?php echo $country?></option>
								<?php
								}
							?>
						</select>
					</div>
					<?php
						}
						else
						{
						?>
							<input type="hidden" name="bcountry" value="US" />
						<?php
						}
					?>
					<div>
						<label for="bphone"><?php _e('Phone', 'pmpro');?></label>
						<input id="bphone" name="bphone" type="text" class="input " size="30" value="<?php echo esc_attr(formatPhone($bphone))?>" />
					</div>
					
					<div>
						<label for="bemail"><?php _e('E-mail Address', 'pmpro');?>*</label>
						<input id="bemail" name="bemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input " size="30" value="<?php echo esc_attr($bemail)?>"  />
					</div>
				
				</td>
			</tr>
		</tbody>
		</table>
	
			

		<div class="pmpro_submit">
			
			<span id="pmpro_submit_span">
				<input type="hidden" name="submit-checkout" value="1" />
				<input type="submit" name="save_payment" class="pmpro_btn pmpro_btn-submit-checkout" value="Go For Payment"/>
			</span>
			
			<span id="pmpro_processing_message" style="visibility: hidden;">
				<?php
					$processing_message = apply_filters("pmpro_processing_message", __("Processing...", "pmpro"));
					echo $processing_message;
				?>
			</span>
		</div>

	</form>

</div> <!-- end payment form  -->

<script>

	// Find ALL <form> tags on your page
	jQuery('form').submit(function(){
		// On submit disable its submit button
		jQuery('input[type=submit]', this).attr('disabled', 'disabled');
		jQuery('input[type=image]', this).attr('disabled', 'disabled');
		jQuery('#pmpro_processing_message').css('visibility', 'visible');
	});

	//unhighlight error fields when the user edits them
	jQuery('.pmpro_error').bind("change keyup input", function() {
		jQuery(this).removeClass('pmpro_error');
	});


	//add javascriptok hidden field to checkout
	jQuery("input[name=submit-checkout]").after('<input type="hidden" name="javascriptok" value="1" />');
	
</script>