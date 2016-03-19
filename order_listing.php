<?php 
	global $wpdb;
	$table = $wpdb->prefix.'guest_orders';
	$sql = "SELECT * FROM ".$table." WHERE status = 'success' ORDER BY id DESC "; 
	$results = $wpdb->get_results($sql);
	//echo "<pre>"; print_r($results); 
?>
<div class="wrap">
<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

<table class="wp-list-table" cellspacing="5" border="1" cellpadding="2">
	<thead>
		<tr>
			<th>S.N.</th>
			<th>Email Id</th>
			<th>Name</th>
			<th>Address</th>
			<th>City</th>
			<th>Zipecode</th>
			<th>State</th>
			<th>Country</th>
			<th>Phone</th>
			<th>Amount</th>
			<th>Status</th>
			<th>Payment ID</th>
		</tr>
	</thead>
	<tbody>
		<?php $num = 1;
		foreach ($results as $result) { 
		?>	
			<tr>
				<td><?php echo $num;?></td>
				<td><?php echo $result->email_id;?></td>
				<td><?php echo $result->billing_name;?></td>
				<td><?php echo $result->billing_street;?></td>
				<td><?php echo $result->billing_city;?></td>
				<td><?php echo $result->billing_zip;?></td>
				<td><?php echo $result->billing_state;?></td>
				<td><?php echo $result->billing_country;?></td>
				<td><?php echo $result->billing_phone;?></td>
				<td><?php echo $result->subtotal;?></td>
				<td><?php echo $result->status;?></td>
				<td><?php echo $result->payment_transaction_id;?></td>

			</tr>
		<?php $num++; } ?>
	</tbody>
</table>
 
</div>