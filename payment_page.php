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
						<label for="subtotal"><?php _e('Guest Amount', 'pmpro');?>*</label>
						<input id="subtotal" name="subtotal" type="text" class="input " size="30" value="" />
					</div>
					<div>
						<label for="bfirstname"><?php _e('First Name', 'pmpro');?>*</label>
						<input id="bfirstname" name="bfirstname" type="text" class="input " size="30" value="" />
					</div>
					<div>
						<label for="blastname"><?php _e('Last Name', 'pmpro');?>*</label>
						<input id="blastname" name="blastname" type="text" class="input " size="30" value=""  />
					</div>
					<div>
						<label for="baddress1"><?php _e('Address 1', 'pmpro');?></label>
						<input id="baddress1" name="baddress1" type="text" class="input " size="30" value="" />
					</div>
					<div>
						<label for="baddress2"><?php _e('Address 2', 'pmpro');?></label>
						<input id="baddress2" name="baddress2" type="text" class="input " size="30" value="" />
					</div>

				
						<div>
							<label for="bcity"><?php _e('City', 'pmpro');?></label>
							<input id="bcity" name="bcity" type="text" class="input " size="30" value="" />
						</div>
						<div>
							<label for="bstate"><?php _e('State', 'pmpro');?></label>
							<input id="bstate" name="bstate" type="text" class="input " size="30" value="" />
						</div>
						<div>
							<label for="bzipcode"><?php _e('Postal Code', 'pmpro');?></label>
							<input id="bzipcode" name="bzipcode" type="text" class="input " size="30" value="" />
						</div>
					

					<?php
						$show_country = apply_filters("pmpro_international_addresses", true);
						if($show_country)
						{
					?>
					<div>
						<label for="bcountry"><?php _e('Country', 'pmpro');?></label>
						<select name="bcountry" class="input select">
							<?php
								global $countries, $default_country;
								if(!$bcountry)
									$bcountry = $default_country;
								foreach($countries as $abbr => $country)
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
						<input id="bphone" name="bphone" type="text" class="input " size="30" value="" />
					</div>
					
					<div>
						<label for="bemail"><?php _e('E-mail Address', 'pmpro');?>*</label>
						<input id="bemail" name="bemail" type="email" class="input " size="30" value=""  />
					</div>
				
				</td>
			</tr>
		</tbody>
		</table>
	
			

		<div class="submit">
			
			<span id="submit_span">
				<input type="hidden" name="submit-checkout" value="1" />
				<input type="submit" name="save_payment" class="btn btn-submit" value="Go For Payment"/>
			</span>
			
			<span id="processing_message" style="visibility: hidden;">
				<?php
					$processing_message = apply_filters("processing_message", __("Processing...", "pmpro"));
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
		jQuery('#processing_message').css('visibility', 'visible');
	});

	//add javascriptok hidden field to checkout
	jQuery("input[name=submit-checkout]").after('<input type="hidden" name="javascriptok" value="1" />');
	
</script>