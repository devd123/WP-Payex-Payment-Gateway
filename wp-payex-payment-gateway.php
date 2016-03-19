<?php
/*
Plugin Name: WP Payex Payment Gateway
Description: Payex payment integration gatway with wordpress for single page custom checkout !
Version: 1.0
Author:      Neeru Sharma
Author URI:  https://neerusite.wordpress.com/
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

include( plugin_dir_path( __FILE__ ) . 'payment_process.php');

global $msg;




/**
 * Register a custom menu page.
 */
function guest_menu_page() {
    add_menu_page(__( 'Guest Checkouts Order List', 'pmpdev' ),'Guest Checkouts','manage_options','guestcheckout','guest_orders_list','dashicons-art',80);
    add_submenu_page( 'guestcheckout', 'Payex Gateway Settings', 'Settings','manage_options', 'payex_settings' , 'payex_settings_page');
}
add_action( 'admin_menu', 'guest_menu_page' );

// callback function of plugin submenu page
function guest_orders_list() {
	include( plugin_dir_path( __FILE__ ) . 'order_listing.php');
}

/**
 * Register the settings
 */
function payex_register_settings() {
     register_setting(
          'payex_options',  // settings section
          'payex_settings' // setting name
     );
}
add_action( 'admin_init', 'payex_register_settings' );
 
/**
 * Build the options page
 */
function payex_settings_page() {
     if ( ! isset( $_REQUEST['settings-updated'] ) )
          $_REQUEST['settings-updated'] = false; ?>
 
     <div class="wrap">
 
          <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
               <div class="updated fade"><p><strong><?php _e( 'Payex Options saved!', 'pmpp' ); ?></strong></p></div>
          <?php endif; ?>
           
          <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
           
          <div id="poststuff">
               <div id="post-body">
                    <div id="post-body-content">
                         <form method="post" action="options.php">
                          <?php settings_fields( 'payex_options' ); ?>
                          <?php $options = get_option( 'payex_settings' ); 
                          //print_r($options); ?>
                          <table class="form-table">
                               <tr valign="top"><th scope="row"><?php _e( 'Payex Account Number', 'pmpp' ); ?></th>
                                    <td>
                                        <input type="text" name="payex_settings[payex_accountno]" id="payex_accountno" value="<?php if($options) echo $options['payex_accountno'];?>">
                                        <br />
                                        <label class="description" for="payex_accountno"><?php _e( 'Please enter the payex account number', 'pmpp' ); ?></label>
                                    </td>
                               </tr>
                                <tr valign="top"><th scope="row"><?php _e( 'Payex Encription Key', 'pmpp' ); ?></th>
                                    <td>
                                        <input type="text" name="payex_settings[payex_key]" id="payex_key" value="<?php if($options) echo $options['payex_key'];?>">
                                        <br />
                                        <label class="description" for="payex_key"><?php _e( 'Please enter the payex encription key', 'pmpp' ); ?></label>
                                    </td>
                               </tr>
                          </table>
                          <?php submit_button(); ?>
                         </form>
                    </div> <!-- end post-body-content -->
               </div> <!-- end post-body -->
          </div> <!-- end poststuff -->
     </div>

<?php }

// Payment form page  
add_shortcode('Add_Payment_Page' , 'payment_page');
function payment_page() {
global $msg;
	
	if($msg)
	{  ?>
			<div class="pmpro_message <?php echo $msg?>"><?php echo $msg; ?></div>
	<?php } 
	include( plugin_dir_path( __FILE__ ) . 'countries.php');
	include( plugin_dir_path( __FILE__ ) . 'payment_page.php');		

}


// create table at plugin installation
function Create_Table()
{
	global $wpdb;
	$table = $wpdb->prefix.'guest_orders'; 
	$version = '1.0';

	$sql = "CREATE TABLE ".$table. "(
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
	  `email_id` varchar(64) NOT NULL DEFAULT '',
	  `billing_name` varchar(128) NOT NULL DEFAULT '',
	  `billing_street` varchar(128) NOT NULL DEFAULT '',
	  `billing_city` varchar(128) NOT NULL DEFAULT '',
	  `billing_state` varchar(32) NOT NULL DEFAULT '',
	  `billing_zip` varchar(16) NOT NULL DEFAULT '',
	  `billing_country` varchar(128) NOT NULL,
	  `billing_phone` varchar(32) NOT NULL,
	  `subtotal` varchar(16) NOT NULL DEFAULT '',
	  `status` varchar(32) NOT NULL DEFAULT '',
	  `gateway` varchar(64) NOT NULL,
	  `gateway_environment` varchar(64) NOT NULL,
	  `payment_transaction_id` varchar(64) NOT NULL,
	  `subscription_transaction_id` varchar(32) NOT NULL,
	  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	  `notes` text NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `user_id` (`user_id`),
		  KEY `status` (`status`),
		  KEY `timestamp` (`timestamp`),
		  KEY `gateway` (`gateway`),
		  KEY `gateway_environment` (`gateway_environment`),
		  KEY `payment_transaction_id` (`payment_transaction_id`),
		  KEY `subscription_transaction_id` (`subscription_transaction_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 "; 
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
	dbDelta( $sql );

	//update_option( $table_name . '_db_version', $version );
}
register_activation_hook( __FILE__, 'Create_Table' );

?>



