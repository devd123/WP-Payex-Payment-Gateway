<?php

include_once 'payexMD5.php';

/**
 * Class that handles calling PxOrder API.
 * http://www.payexpim.com/category/pxorder/
 *
 * @param boolean $testMode Decides if running testmode or not.
 */
class pxOrderMethods{

	private $PxOrderWSDL;
	private $payexFunc;
	private $soapObject;

	function __construct($testMode){
	
		$this->payexFunc = new payexMD5;
	
		if($testMode == true){
			$this->PxOrderWSDL = "https://test-external.payex.com/pxorder/pxorder.asmx?wsdl"; //TEST ENVIRONMENT
		}
		else{
			$this->PxOrderWSDL = "https://external.payex.com/pxorder/pxorder.asmx?wsdl"; //PRODUCTION ENVIRONMENT
		}	
		
		$this->soapObject = new SoapClient($this->PxOrderWSDL,array("trace" => 1, "exceptions" => 0));
	}
	
	/**
	 * Returns the last SOAP request sent by this class.
	 *
         * @return string a string containing headers and body of the last SOAP request.
	 */
	function getLastRequest(){
	
	$request = "headers: " . $this->soapObject->__GetLastRequestHeaders() . "\n" . "body: " . $this->soapObject->__getLastRequest();
	
	return $request;
	}

	
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/initialize8/
	 * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
         * 
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API.
	 */
	function initialize8($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->Initialize8($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'Initialize8Result'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/cancel2/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API
	 */
	function cancel2($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->Cancel2($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'Cancel2Result'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/capture5/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API
	 */
	function capture5($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->Capture5($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'Capture5Result'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/credit5/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API
	 */
	function credit5($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->Credit5($param);
		var_dump($result);
		
		$simpleResponseXML = new simpleXMLelement($result->{'Credit5Result'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/check2/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API
	 */
	function check2($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->Check2($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'Check2Result'});
		
		return $simpleResponseXML;
	}
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/gettransactiondetails2/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API
	 */
	function gettransactiondetails2($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->GetTransactionDetails2($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'GetTransactionDetails2Result'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/purchasefinancinginvoice/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API
	 */
	function purchasefinancinginvoice($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->PurchaseFinancingInvoice($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'PurchaseFinancingInvoiceResult'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/purchaseinvoiceprivate/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API
	 */
	function purchaseinvoiceprivate($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->PurchaseInvoicePrivate($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'PurchaseInvoicePrivateResult'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/purchaseinvoicecorporate/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API
	 */
	function purchaseinvoicecorporate($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->PurchaseInvoiceCorporate($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'PurchaseInvoiceCorporateResult'});
		
		return $simpleResponseXML;
	}
	/**
	 * http://www.payexpim.com/technical-reference/pxorder/complete/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API
	 */
	function complete($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->Complete($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'CompleteResult'});
		
		return $simpleResponseXML;
	}
}

?>