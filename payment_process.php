<?php
/* Payex library function with insert and update order list */

ob_start();
// include the payex lib files 
include( plugin_dir_path( __FILE__ ) . 'settings.php');
include( plugin_dir_path( __FILE__ ) . '/payex/PxOrder.php');

class initializePayex
{
    function initializePayex()
    {
        $orderRef = '';
        $getid = $this->saveOrderdata();
        if(isset($_REQUEST['orderRef']))
        $orderRef = $_REQUEST['orderRef'];
        if(is_numeric($getid))
        {
            $getDataFromDb = $this->getDataFromTable($getid);
            if(is_array($getDataFromDb))
            {
                $prepareParams = $this->prepareParams($getDataFromDb);
                $response = $this->getAuthorization($prepareParams);
                if($response)
                {
                    $this->redirectoPayex($response);
                }
            }
        }
        if($orderRef)
        {
            $this->getCompleteResponse($orderRef);
        }
        
    }
    protected function prepareParams($getDataFromDb)
    {
    global $testMode , $encryptionKey ,$accountNumber;
	//Parameters for Initialize8. Check payexpim.com for how the array should be constructed. For PxOrder.Initialize8: http://www.payexpim.com/technical-reference/pxorder/initialize8/.
	return $initialize8Params = array
		(
		'accountNumber' => $accountNumber, 
		'purchaseOperation' => "AUTHORIZATION",
		'price' => $getDataFromDb[0]->subtotal, //NOTE: if you fetch price from another variable, you should make sure price does not get stored as a float data type in this array. Example of how to solve this: 'price' => (string)$myPriceVariable,
		'priceArgList' => "",
		'currency' => "USD",
		'vat' => "0",
		'orderID' => $getDataFromDb[0]->id,
		'productNumber' => "1",
		'description' => $getDataFromDb[0]->email_id,
		'clientIPAddress' => $_SERVER['REMOTE_ADDR'],
		'clientIdentifier' => "USERAGENT=".$_SERVER['HTTP_USER_AGENT'],
		'additionalValues' => "",
		'externalID' => "",
		'returnUrl' => site_url('manually-payment'), //point to the completeExample.php file if you want to test PxOrder.Complete.
		'view' => "CREDITCARD",
		'agreementRef' => "",
		'cancelUrl' => site_url('manually-payment'),
		'clientLanguage' => "en-US",
        'hash' => "" // Leave empty, will be calculated by PxOrder.php
		);
    }
    protected function getAuthorization($initialize8Params)
    {
       
        global $testMode , $encryptionKey ,$accountNumber;
        $pxorder = new pxOrderMethods($testMode);
        $response = $pxorder->initialize8($initialize8Params, $encryptionKey);
        return $response;
    }
    protected function redirectoPayex($response)
    {
        
    //Check if response was OK.
	if(strval($response->status->errorCode) == 'OK'){
		
		//If OK, redirect.
       // echo strval($response->redirectUrl); die;
        //wp_redirect(strval($response->redirectUrl));
        header('Location: '.strval($response->redirectUrl));
        exit;
	
	}
	else{
		
		//Dumping soap request and responseXML if initialize8 call failed.
		//echo($pxorder->getLastRequest());
		var_dump($response);
	}
    }
    protected function saveOrderdata($responseData = false)
    {
       
    if(isset($_POST['submit-checkout']) && $_POST['submit-checkout'] == 1)
	{

		global $wpdb,$msg;

		if(empty($_POST['bfirstname']) && empty($_POST['blastname']) && empty($_POST['customamount']) && empty($_POST['email_id']) )
		{
			$msg = "Please fill all the required fields";
			return false; 
		}

		$table = $wpdb->prefix.'guest_orders';
		$order = array(
				'user_id' => $_POST['user_id'],
				'email_id' => $_POST['bemail'],
				'billing_name' => $_POST['bfirstname'].' '.$_POST['bfirstname'],
				'billing_street' => $_POST['baddress1'].''.$_POST['baddress2'],
				'billing_city' => $_POST['bcity'],
				'billing_state' => $_POST['bstate'],
				'billing_zip' => $_POST['bzipcode'],
				'billing_country' => $_POST['bcountry'],
				'billing_phone' => $_POST['bphone'],
				'subtotal' => $_POST['customamount'],
				'status' => $_POST['status'],
				'gateway' => $_POST['gateway'],
				'gateway_environment' => $_POST['gateway_environment'],
				'payment_transaction_id' => $_POST['payment_transaction_id'],
				'subscription_transaction_id' => $_POST['subscription_transaction_id'],
				'timestamp' => date("Y-m-d H:s:i", current_time("timestamp")),
				'notes' => $_POST['notes'],
				
			);
			$sql = "INSERT INTO ".$table."
								(`user_id`, `email_id`, `billing_name`, `billing_street`, `billing_city`, `billing_state`, `billing_zip`, `billing_country`, `billing_phone`, `subtotal`, `status`, `gateway`, `gateway_environment`, `payment_transaction_id`, `subscription_transaction_id`, `timestamp`, `notes`)
								VALUES('" . intval($order['user_id']) . "',
									   '" . $order['email_id'] . "',
									   '" . esc_sql(trim($order['billing_name'])) . "',
									   '" . esc_sql(trim($order['billing_street'])) . "',
									   '" . esc_sql($order['billing_city']) . "',
									   '" . esc_sql($order['billing_state']) . "',
									   '" . esc_sql($order['billing_zip']) . "',
									   '" . esc_sql($order['billing_country']) . "',
									   '" . cleanPhone($order['billing_phone']) . "',
									   '" . $order['subtotal'] . "',
									   '" . esc_sql($order['status']) . "',
									   '" . $order['gateway'] . "',
									   '" . $order['gateway_environment'] . "',
									   '" . esc_sql($order['payment_transaction_id']) . "',
									   '" . esc_sql($order['subscription_transaction_id']) . "',
									   '" . esc_sql($order['timestamp']) . "',
									   '" . esc_sql($order['notes']) . "'
							    )";  

			$insert =  $wpdb->get_var($sql);
            return  $last_id = $wpdb->insert_id;

		
	}

    if($responseData)
        {
            global $wpdb;
            $table = $wpdb->prefix.'guest_orders';
            $sql = "UPDATE ".$table." SET 
                                    `status` = '" . esc_sql($responseData['transactionStatus']) . "',
                                    `subtotal` = '" . esc_sql($responseData['amount']) . "',
                                    `gateway` = 'payex',
                                    `payment_transaction_id` = '" . esc_sql($responseData['transactionNumber']) . "',
                                    `subscription_transaction_id` = '" . esc_sql($responseData['transactionRef']) . "'	
                                    WHERE id = '" . $responseData['orderId'] . "'
                                    LIMIT 1"; 

	    	$updaet =  $wpdb->get_var($sql);
            
        }
    }
    protected function getCompleteResponse($orderRef)
    {
        global $testMode, $encryptionKey ,$accountNumber , $msg;
       
        $orderRef = stripcslashes( $_GET['orderRef'] );
	//Parameters for Complete. Check payexpim.com for how the array should be constructed. For PxOrder.Complete: http://www.payexpim.com/technical-reference/pxorder/complete/.
	$completeParams = array
		(
		'accountNumber' => $accountNumber, 
		'orderRef' => $orderRef,
                'hash' => "" // Leave empty, will be calculated by PxOrder.php
		);
	
	//create a pxOrderMethods object(PxOrder.php).
	$pxorder = new pxOrderMethods($testMode);
	
	//call desired method with appropriate array of parameters + encryption key.
	$response = $pxorder->complete($completeParams, $encryptionKey);
	//Check if Complete call was OK. IMPORTANT! This will only tell you if the Complete-request was sent successfully, not if the purchase/transaction was successful. $response->transactionStatus need to be validated to show purchase status, see example below.
	if(strval($response->status->errorCode) == 'OK')
    {
		
            
           
			$return_orderdata = (array)$response;
            //echo "<pre>"; print_r($return_orderdata); die;
           
           
       		
		if(strval($response->transactionStatus) == 0 || strval($response->transactionStatus) == 3)
        {
			$responseData = array();
            $responseData['orderId']           = $return_orderdata['orderId'];
            $responseData['transactionNumber'] = $return_orderdata['transactionNumber'];
            $responseData['paymentMethod']     = $return_orderdata['paymentMethod'];
            $responseData['transactionRef']    = $return_orderdata['transactionRef'];
            $responseData['transactionStatus'] = 'success';
            $responseData['amount']            = $return_orderdata['amount'];

			$this->saveOrderdata($responseData);
            $msg .= 'Payment Result : your payment has been successfully done !';
            $msg .= '<p> Payment ID : '. $responseData['transactionNumber'].'</p>';
            $msg .= '<p> Payment Type : Visa/Mastercard</p>';
            $msg .= '<p> Amount : '. $responseData['amount'].' USD</p>';
            $msg .= '<p> Status : Success </p>';
                        
		}
		else
        {
            $responseData = array();
            $responseData['orderId']           = $return_orderdata['orderId'];
            $responseData['transactionNumber'] = $return_orderdata['transactionNumber'];
            $responseData['paymentMethod']     = $return_orderdata['paymentMethod'];
            $responseData['transactionRef']    = $return_orderdata['transactionRef'];
            $responseData['transactionStatus'] = 'failed';
            $responseData['amount']            = $return_orderdata['amount'];


            $this->saveOrderdata($return_orderdata);
			$msg = 'Payment Result : your payment has been failed or decline please try again !';
		}
	}
	else
        {
		
         $msg = 'Payment Result : your payment has been failed please try again';
		
		}
    }

    protected function getDataFromTable($id)
    {
            global $wpdb;
            $table = $wpdb->prefix.'guest_orders';
            $sql = "SELECT * FROM ".$table." WHERE  id ='$id' ";
            return $results = $wpdb->get_results($sql);

    }

    function xml_array($xml)
	{
	    $arr = array();

	    foreach ($xml as $element)
	    {
	        $tag = $element->getName();
	        $e = get_object_vars($element);
	        if (!empty($e))
	        {
	            $arr[$tag] = $element instanceof SimpleXMLElement ? $this->xml_array($element) : $e;
	        }
	        else
	        {
	            $arr[$tag] = trim($element);
	        }
    	}
	}

}
$obj = new initializePayex;
ob_end_flush();	
?>