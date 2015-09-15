<?php

/**
 * login actions.
 *
 * @package    testowy
 * @subpackage login
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class loginActions extends sfActions {

	public function executeIndex(sfWebRequest $request) {
		$this->form = new LoginForm();
		if ($request->isMethod('post')) {
			$login = $request->getParameter('login');
			$this->form->bind($request->getParameter('login'));
			if ($this->form->isValid()) { //formularz jest poprawny
				$accounts = Doctrine :: getTable('Admin')->getByLoginAndPassword($login['login'], $login['haslo']);				
				if (count($accounts) == 1) {
					//$this->getUser()->setFlash('aNotice', sprintf('Użytkownik zalogowany.'), false);
					//zapisanie id zalogowanego usera
					$this->getUser()->setAttribute('adminId', $accounts[0]->getId());
					$this->getUser()->setAttribute('adminLogin', $accounts[0]->getLogin());
					$this->getUser()->setAuthenticated(true);
					$this->redirect('@kandydat_kandydat');
				}
				else {
					$this->getUser()->setFlash('aError', sprintf('Nie ma takiego użytkownika lub podano złe hasło.'), false);
					$this->getUser()->setAuthenticated(false);
				}
			}
		}
	}
	
	public function executeLogout() {
		$this->getUser()->setAuthenticated(false);
		$this->getUser()->setAttribute('adminId', null);
		$this->getUser()->setAttribute('adminLogin', null);
		$this->getUser()->setFlash('aNotice', sprintf('Zostałeś wylogowany.'));
		$this->redirect('login/index');
	}

}