<?php

class myUser extends sfBasicSecurityUser {
	public function getLogin() {
		return $this->getAttribute('adminLogin');
	}
	
	public function isAuthenticated() {
		$auth = parent :: isAuthenticated();
		$id = $this->getAttribute('adminId');
		if (strlen($this->getLogin()) > 0 && $id != 0)
			return $auth;
		return false;
	} 
	
}
