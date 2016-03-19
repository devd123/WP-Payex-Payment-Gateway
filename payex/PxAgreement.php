<?php

include_once 'payexMD5.php';

/**
 * Class that handles calling PxAgreement API.
 * http://www.payexpim.com/category/pxagreement/
 *
 * @param boolean $testMode Decides if running testmode or not.
 */
class pxAgreementMethods{

	private $PxAgreementWSDL;
	private $payexFunc;
	private $soapObject;

	function __construct($testMode){
	
		$this->payexFunc = new payexMD5;
	
		if($testMode == true){
			$this->PxAgreementWSDL = "https://test-external.payex.com/pxagreement/pxagreement.asmx?WSDL"; //TEST ENVIRONMENT
		}
		else{
			$this->PxAgreementWSDL = "https://external.payex.com/pxagreement/pxagreement.asmx?WSDL"; //PRODUCTION ENVIRONMENT
		}	
		
		$this->soapObject = new SoapClient($this->PxAgreementWSDL,array("trace" => 1, "exceptions" => 0));
	}


	
	/**
	 * http://www.payexpim.com/technical-reference/pxagreement/createagreement3/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API.
	 */
	function createAgreement3($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->CreateAgreement3($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'CreateAgreement3Result'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxagreement/autopay3/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API.
	 */
	function autoPay3($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->AutoPay3($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'AutoPay3Result'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxagreement/deleteagreement/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API.
	 */
	function deleteAgreement($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->DeleteAgreement($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'DeleteAgreementResult'});
		
		return $simpleResponseXML;
	}
	
	/**
	 * http://www.payexpim.com/technical-reference/pxagreement/check/
         * Hash will be calculated by the method, therefore send in an empty 'Hash' parameter.
	 *
	 * @param array $paramArray An array with the parameters you are sending.
	 * @param string $encryptionKey Your encryption key, defined in settings.php.
	 * @return object $simpleResponseXML A simpleXML-object of the response from PayEx API.
	 */
	function check($paramArray, $encryptionKey){
		
		$param = $this->payexFunc->createHash($paramArray, $encryptionKey);
		
		$result = $this->soapObject->Check($param);
		
		$simpleResponseXML = new simpleXMLelement($result->{'CheckResult'});
		
		return $simpleResponseXML;
	}
	
}

?>