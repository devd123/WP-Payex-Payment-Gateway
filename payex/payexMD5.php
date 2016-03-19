<?php

/**
 * Helper class for creating MD5 hash.
 *
 */
class payexMD5{

	/**
         * Returns the same array with addition of calculated hash.
	 *
         * @param array $paramArray an array with empty hash key.
	 * @param string $encryptionKey the encryption key used to make the hash.
	 * @return array an array with the same values as $paramArray with the addition of 'hash'.
         */
	function createHash($paramArray, $encryptionKey){
	
		$param = $paramArray;
		
		$stringToHash = implode("", $param);
		$stringToHash .= $encryptionKey;
		$hash = md5($stringToHash);
		
		$param['hash'] = $hash;
		return $param;
		
        }
}

?>
