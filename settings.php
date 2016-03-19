<?php

/**
 *These settings are used for all of the example files.
 */
 
$testMode = true;
/**If true, test environment will be called for all method.
 *Note that a combination of account number and encryption key only exist in either test mode or production mode.
 */
$options = get_option( 'payex_settings'); 
if($options){
	$accountNumber = $options['payex_accountno']; //Enter your account number here.
	$encryptionKey = $options['payex_key']; //Enter your encryption key here. This is generated on your PayEx Merchant Account page.
}
?>