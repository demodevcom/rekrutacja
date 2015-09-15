<?php


/**
 * login actions.
 *
 * @author     Pawel Skrzynski
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class loginActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		/*Jeżeli użytkownik jest zalogowany, to nie wyświetla mu się formularz logowania*/
		if($this->getUser()->isAuthenticated()) $this->redirect('kandydat/main');
		$this->form = new LoginForm();
		if ($request->isMethod('post')) {
			$login = $request->getParameter('login');
			$this->form->bind($request->getParameter('login'));
			if ($this->form->isValid()) { //formularz jest poprawny
	
				$accounts = Doctrine :: getTable('Kandydat')->getByLoginAndPassword($login['login'], $login['haslo']);				
				if (count($accounts) == 1) {
					$this->getUser()->setFlash('notice', sprintf('Użytkownik zalogowany'));
					//zapisanie id zalogowanego usera
					$this->getUser()->setAttribute('kandydatId', $accounts[0]->getId());
					$this->getUser()->setAttribute('login', $accounts[0]->getLogin());
					$this->getUser()->setAuthenticated(true);
					$this->redirect('kandydat/main');
				} else {
					$this->getUser()->setFlash('error', sprintf('Nie ma takiego użytkownika lub podano złe hasło'), false);
					$this->getUser()->setAuthenticated(false);
				}
			} else {
				$this->getUser()->setFlash('error', sprintf('Pola nie zostały wypełnione poprawnie'), false);
				$this->getUser()->setAuthenticated(false);
			}
		}
	}
	
	public function executeInfo() {
	
	}	

	public function executeLogout() {
		$this->getUser()->setAuthenticated(false);
		$this->getUser()->setAttribute('customerId', null);
		$this->getUser()->setAttribute('login', null);
		$this->getUser()->setFlash('notice', sprintf('Zostałeś wylogowany.'));
		$this->redirect('login/info');
	}

}