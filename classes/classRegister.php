<?php
class register {
	public $regUser;
	public $regPass1;
	public $regPass2;
	public $regEmail;
	public $regNickname;
	public $okay;
	public $regFlag;
	public $errorMessage;
	
	function __construct ($regUser, $regPass1, $regPass2, $regEmail, $regNickname, $flag) {
		$this->regUser = $regUser;
		$this->regPass1 = $regPass1;
		$this->regPass2 = $regPass2;
		$this->regEmail = $regEmail;
		$this->regNickname = $regNickname;
		$this->regFlag = $flag;
		$this->isOkey();
	}
	
	function isOkey(){
		$z = 1;
		if (strlen($this->regUser) < 4) { 
			$z = $z * 0;
			$this->errorMessage = " Your login should be at least 4 characters long.<br>";
		}
		if (strlen($this->regPass1) < 6) { 
			$z = $z * 0;
			$this->errorMessage .= " Your password should be at least 4 characters long.<br>";
		}		
		if ( $this->regPass1 != $this->regPass2) { 
			$z = $z * 0;
			$this->errorMessage .= " Your password doesn't match.<br>";
		}	
		if (strlen($this->regNickname) < 4) { 
			$z = $z * 0;
			$this->errorMessage .= " Your nickname should be at least 4 characters long.<br>";
		}	
		if (strpbrk($this->regEmail,"@.") == false) { 
			$z = $z * 0;
			$this->errorMessage .= " Your email is incorrect.<br>";
		}	
		if (strlen($this->regEmail) < 13) { 
			$z = $z * 0;
			$this->errorMessage .= " Your email is suspeciously short.<br>";
		}	
		if ($z == 1) {
			$this->okay = true;
			echo "<h4<ZHOPA</h4>";
		}
		else 
			$this->okay = false;
	}
}
?>