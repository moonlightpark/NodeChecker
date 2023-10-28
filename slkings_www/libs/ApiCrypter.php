<?php 

class ApiCrypter
{
    private $iv  = __ENV_CRYPT_IV__; //Same as in JAVA (16 ja)
    private $key = __ENV_CRYPT_KEY__; //Same as in JAVA (12 ja)

    public function __construct() {
    }

    public function encrypt($str) { 
	  $str = $this->pkcs5_pad($str);   
	  $iv = $this->iv; 
	  $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv); 
	  mcrypt_generic_init($td, $this->key, $iv);
	  $encrypted = mcrypt_generic($td, $str); 
	  mcrypt_generic_deinit($td);
	  mcrypt_module_close($td); 
	  return bin2hex($encrypted);
    }

    public function decrypt($code) {
      echo __FUNCTION__.$code;
      if(is_null($code) || $code = "" || empty($code)){
            return "";
      }
	  $code = $this->hex2bin($code);
	  $iv = $this->iv; 
	  $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv); 
	  mcrypt_generic_init($td, $this->key, $iv);
	  $decrypted = mdecrypt_generic($td, $code); 
	  mcrypt_generic_deinit($td);
	  mcrypt_module_close($td); 	 
	  return $this->pkcs5_unpad($decrypted);

    }
    
    function decrypt2 ( $value)
    {
    	if ( is_null ($value) )
    		$value = "" ;
    	$value = base64_decode ($value) ;
    	$output = mcrypt_decrypt (MCRYPT_RIJNDAEL_128, $this->key,$value, MCRYPT_MODE_CBC, $this->iv) ;
    	return $output ;
    }

    protected function hex2bin($hexdata) {
	  $bindata = ''; 
	  for ($i = 0; $i < strlen($hexdata); $i += 2) {
	      $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
	  } 
	  return $bindata;
    } 

    protected function pkcs5_pad ($text) {
	  $blocksize = 16;
	  $pad = $blocksize - (strlen($text) % $blocksize);
	  return $text . str_repeat(chr($pad), $pad);
    }

    protected function pkcs5_unpad($text) {
	  $pad = ord($text{strlen($text)-1});
	  if ($pad > strlen($text)) {
	      return false;	
	  }
	  if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
	      return false;
	  }
	  return substr($text, 0, -1 * $pad);
    }
}