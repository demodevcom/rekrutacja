<?php


/**
 * kandydat actions.
 *
 * @package    testowy
 * @subpackage kandydat
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class kandydatActions extends sfActions {
	
	//private $kandydat;
	
	public function executeIndex(sfWebRequest $request) {
		//$this->kandydat_list = Doctrine::getTable('Kandydat')->createQuery('a')->execute();
		$this->redirect('kandydat/new');
	}

	public function executeMain(sfWebRequest $request) {
		$this->kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$this->getUser()->getAttribute('kandydatId')
		));
		if ($this->kandydat == null) {
			$this->getUser()->setAuthenticated(false);
			$this->redirect('login/index');
		}
	}

	public function executeRemind1(sfWebRequest $request) {
		$this->form = new PasswordRemindForm1();
		if ($request->isMethod('post')) {
			$this->form = new PasswordRemindForm1();
			$data = $request->getParameter('remind1');
			$this->form->bind($data);
			if ($this->form->isValid()) { //formularz jest poprawny
				//pobieramy kandydata po peselu
				$set = Doctrine :: getTable('Kandydat')->getByPesel($data['pesel']);
				if (count($set) != 1)
					$this->getUser()->setFlash('error', sprintf('Nie ma takiego użytkownika'), false);
				else {
					$this->getUser()->setAttribute('reminderKandydatId', $set[0]->getId());
					$this->redirect('kandydat/remind2');	
				}
			}
		}

	}

	public function executeRemind2(sfWebRequest $request) {
		$this->kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$this->getUser()->getAttribute('reminderKandydatId')
		));
		$this->forward404Unless($this->kandydat);
		$this->form = new PasswordRemindForm2();
		if ($request->isMethod('post')) {
			$data = $request->getParameter('remind2');
			$this->form->bind($data);
			if ($this->form->isValid()) { //formularz jest poprawny
				if (strtolower(trim($data['odpowiedz'])) == strtolower(trim($this->kandydat->getOdpowiedzHaslo()))) {
					$pass = StringGenerator :: generateString(6);
					$this->kandydat->setHaslo($pass);
					$this->kandydat->save();
					$this->getUser()->setFlash('notice', sprintf('Nowe hasło: ' . $pass), false);
					
				}
				else
					$this->getUser()->setFlash('error', sprintf('Zła odpowiedź!'), false);
			}
		}
	}

	public function executeProgress(sfWebRequest $request) {
		$this->kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$this->getUser()->getAttribute('kandydatId')
		));
		$this->forward404Unless($this->kandydat);
	}
	
	public function executeShow(sfWebRequest $request) {
	  	$response = $this->getResponse();
		$response->setHttpHeader('Content-Type', 'text/html; charset=utf-8');
		$response->addCacheControlHttpHeader('Cache-Control', 'no-cache');
		$response->sendHttpHeaders();

		$this->kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$this->getUser()->getAttribute('kandydatId')
		));
		$this->forward404Unless($this->kandydat);
		$this->formFields = array (
			'imiona' => 'Imiona',
			'nazwisko' => 'Nazwisko',
			'plec' => 'Płeć',
			'urodzenie_miejsce' => 'Miejsce urodzenia',
			'narodowosc' => 'Narodowość',
			'obywatelstwo' => 'Obywatelstwo',
			'matka_imie' => 'Imię matki',
			'ojciec_imie' => 'Imię ojca',
			'pesel' => 'PESEL',
			'dowod_osobisty_nr' => 'Nr dowodu osobistego',
			'nip' => 'NIP',
			'telefon_nr' => 'Nr telefonu',
			'mobile_nr' => 'Telefon komórkowy',
			'zameldowanie_ulica' => 'Ulica',
			'zameldowanie_dom_nr' => 'Numer domu',
			'zameldowanie_mieszkanie_nr' => 'Numer mieszkania',
			'zameldowanie_kod' => 'Kod pocztowy',
			'zameldowanie_miasto' => 'Miasto',
			'zameldowanie_wojewodztwo' => 'Województwo',

			'korespondencja_ulica' => 'Ulica (adr. korespondencyjny)',
			'korespondencja_dom_nr' => 'Numer domu (adr. korespondencyjny)',
			'korespondencja_mieszkanie_nr' => 'Numer mieszkania (adr. korespondencyjny)',
			'korespondencja_kod' => 'Kod pocztowy (adr. korespondencyjny)',
			'korespondencja_miasto' => 'Miasto (adr. korespondencyjny)',
			'korespondencja_wojewodztwo' => 'Województwo (adr. korespondencyjny)',

			'stosunek_do_sluzby_wojskowej' => 'Stosunek do służby wojskowej',
			'ksiazeczka_wojskowa_nr' => 'Numer książeczki wojskowej',
			'wku_miasto' => 'WKU Miasto',
			'niepelnosprawny' => 'Niepełnosprawny',
			'szkola_srednia' => 'Ukończona szkoła średnia',
			'szkola_srednia_rok_ukonczenia' => 'Rok ukończenia szkoły średniej',
			'skonczone_studia' => 'Skończone studia',
			'skonczone_studia_rok_ukonczenia' => 'Rok ukończenia studiów',
			'inne_studia' => 'Inne studia',
			'kierunek' => 'Kierunek studiów',
			'specjalnosc' => 'Specjalność',
			'stacjonarne' => 'Tryb studiów',
			'studia_typ' => 'Rodzaj studiów',
			'jezyk' => 'Język obcy',
			'jezyk2' => 'Język obcy dodatkowy',
			'plywanie_grupa' => 'Pływanie (grupa)',
			'login' => 'Login',
			'email' => 'Email',
			//'haslo' => 'Hasło',
			'zdjecie' => 'Zdjęcie',
			'skad_wiem' => 'O szkole dowiedziałem się',
			'created_at' => 'Data utworzenia',
			'updated_at' => 'Data ostatnich zmian'
		);
		$this->fieldList = array_keys($this->formFields);

	}

	public function executeNew(sfWebRequest $request) {
		$this->getUser()->setAuthenticated(false);
		$this->form = new KandydatForm();

		$jsParams = '
		    <script type="text/javascript">     
		    	var jezyk = \'\';
		    	var jezyk2 = \'\';
		    	var specjalnosc = \'\';
		   	</script>
		   	';
		$this->getRequest()->setParameter('jsParams', $jsParams);
	}

	public function executeCreate(sfWebRequest $request) {
		$this->getUser()->setAuthenticated(false);
		$this->forward404Unless($request->isMethod('post'));

		$this->form = new KandydatForm(null, $request->getPostParameter('kandydat[login]'));

		$this->processForm($request, $this->form);

		$this->setTemplate('new');

		$jsParams = '
		    <script type="text/javascript">     
		    	var jezyk = \'\';
		    	var jezyk2 = \'\';
		    	var specjalnosc = \'\';
		   	</script>
		   	';

		$this->getRequest()->setParameter('jsParams', $jsParams);

	}

	public function executeEdit(sfWebRequest $request) {
		$kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$this->getUser()->getAttribute('kandydatId')
		));
		if ($kandydat == null)
			sfContext :: getInstance()->getLogger()->debug('Editing null :(...');
		$this->forward404Unless($kandydat, sprintf('Obiekt nie istnieje (%s).', array (
			$this->getUser()->getAttribute('kandydatId')
		)));

		$this->form = new KandydatEditForm($kandydat, $kandydat->getLogin());

		// string z parametrami dla js
		$jsParams = '
		    <script type="text/javascript"> 
		    	var jezyk = ' . ($kandydat->getJezyk() != '' ? '\'' . $kandydat->getJezyk() . '\'' : '\'\'') . ';
		    	var jezyk2 = ' . ($kandydat->getJezyk2() != '' ? '\'' . $kandydat->getJezyk2() . '\'' : '\'\'') . ';
		    	var specjalnosc = ' . ($kandydat->getSpecjalnosc() != '' ? '\'' . $kandydat->getSpecjalnosc() . '\'' : '\'\'') . ';
		   	</script>
		   	';

		$this->getRequest()->setParameter('jsParams', $jsParams);

	}

	public function executeEditImage(sfWebRequest $request) {
		$kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$this->getUser()->getAttribute('kandydatId')
		));
		$this->forward404Unless($kandydat, sprintf('Obiekt nie istnieje (%s).', array (
			$request->getParameter('id')
		)));

		$this->form = new KandydatImageForm($kandydat, $kandydat->getLogin());
		$this->kandydatLogin = $kandydat->getLogin();

	}

	public function executeUpdate(sfWebRequest $request) {
		//utl_dump_array('POST', $_POST);
		$kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$this->getUser()->getAttribute('kandydatId')
		));
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($kandydat, sprintf('Obiekt nie istnieje (%s).', array (
			$request->getParameter('id')
		)));
		/*
			if(@file_exists(sfConfig::get('sf_upload_dir').'/'.$kandydat->getLogin().'/'.$kandydat->getZdjecie())) {
		    	unlink(sfConfig::get('sf_upload_dir').'/'.$kandydat->getLogin().'/'.$kandydat->getZdjecie());
		}
		*/
		$this->form = new KandydatEditForm($kandydat, $kandydat->getLogin());
		$this->kandydatLogin = $kandydat->getLogin();

		$this->processForm($request, $this->form);

		// string z parametrami dla js
		$jsParams = '
		    <script type="text/javascript"> 
		    	var jezyk = ' . ($kandydat->getJezyk() != '' ? '\'' . $kandydat->getJezyk() . '\'' : '\'\'') . ';
		    	var jezyk2 = ' . ($kandydat->getJezyk2() != '' ? '\'' . $kandydat->getJezyk2() . '\'' : '\'\'') . ';
		    	var specjalnosc = ' . ($kandydat->getSpecjalnosc() != '' ? '\'' . $kandydat->getSpecjalnosc() . '\'' : '\'\'') . ';
		   	</script>
		   	';

		$this->getRequest()->setParameter('jsParams', $jsParams);

		$this->setTemplate('edit');
	}

	public function executeChangeImage(sfWebRequest $request) {
		$kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$this->getUser()->getAttribute('kandydatId')
		));
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($kandydat, sprintf('Obiekt nie istnieje (%s).', array (
			$request->getParameter('id')
		)));

		if (@ file_exists(sfConfig :: get('sf_upload_dir') . '/' . $kandydat->getLogin() . '/' . $kandydat->getZdjecie())) {
			@ unlink(sfConfig :: get('sf_upload_dir') . '/' . $kandydat->getLogin() . '/' . $kandydat->getZdjecie());
		}

		$this->form = new KandydatImageForm($kandydat, $kandydat->getLogin());

		$this->processImageForm($request, $this->form);

		$this->setTemplate('editImage');
	}

	protected function processImageForm(sfWebRequest $request, sfForm $form) {

		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ($form->isValid()) {
			$kandydat = $form->save();

			$this->getUser()->setFlash('notice', 'Zdjęcie zostało zmienione');
			$this->redirect('kandydat/show?id=' . $kandydat->getId());
		} else {
			$this->getUser()->setFlash('error', 'Wystąpiły błędy.');
			$this->setTemplate('editImage');
		}
	}

	public function executeFormChangePass(sfWebRequest $request) {
		$kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$this->getUser()->getAttribute('kandydatId')
		));
		//echo 'login: '.$kandydat->getLogin();
		$this->form = new KandydatPasswordForm($kandydat);
		$this->kandydat = $kandydat;
	}

	public function executeChangePass(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
		$this->forward404Unless($kandydat = Doctrine :: getTable('Kandydat')->find(array (
			$request->getParameter('id')
		)), sprintf('Object kandydat does not exist (%s).', array (
			$request->getParameter('id')
		)));
		$this->form = new KandydatPasswordForm($kandydat);

		$this->processFormPass($request, $this->form);
	}

	protected function processFormPass(sfWebRequest $request, sfForm $form) {

		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ($form->isValid()) {
			$kandydat = $form->save();
			$this->getUser()->setFlash('notice', 'Hasło zostało zmienione');
			$this->redirect('kandydat/show?id=' . $kandydat->getId());
		} else {
			$this->getUser()->setFlash('error', 'Wystąpiły błędy.');
			$this->setTemplate('formChangePass');
		}
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {

		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid()) {
			$kandydat = $form->save();
			if ($this->getUser()->isAuthenticated() == false) {
				//zalogowanie nowego studenta
				$this->getUser()->setAttribute('kandydatId', $kandydat->getId());
				$this->getUser()->setAttribute('login', $kandydat->getLogin());
				$this->getUser()->setAuthenticated(true);
			}
			$this->getUser()->setFlash('notice', 'Dane zostały zaktualizowane');
			$this->redirect('kandydat/edit?id=' . $kandydat->getId());
		}
		$this->getUser()->setFlash('error', 'Błąd podczas aktualizacji danych');
		sfContext::getInstance()->getLogger()->debug('Form is not valid');
		$errors = $form->getErrorSchema()->getErrors();
		foreach ($errors as $err)
			sfContext::getInstance()->getLogger()->debug('Error: ' . $err);		

	}
	
	public function executeBankTransfer(sfWebRequest $request) {
		$kandydat = Doctrine :: getTable('Kandydat')->find(array ($this->getUser()->getAttribute('kandydatId')));
		$this->forward404Unless($kandydat, 'Obiekt nie istnieje');

	  	$response = $this->getResponse();
	  	$response->clearHttpHeaders();
		
		$response->setHttpheader('Pragma: public', true);
		$response->addCacheControlHttpHeader('Cache-Control', 'no-cache');

		$response->setHttpHeader("Last-Modified", gmdate("D, d M Y H:i:s") . " GMT");
		$response->setContentType('image/png');
		//$response->setHttpHeader('Content-Length', filesize('' . (string) utf8_decode($path. '')));
		$response->sendHttpHeaders();
		$imgDir = sfConfig :: get('sf_web_dir') . '/images/';
		//utl_dump_array('config', sfConfig::getAll());
		$generator = new BankTransferGenerator(	$imgDir . 'druk.png', $imgDir . 'druk.ttf',
												'opłata wpisowa',
												$kandydat['imiona'] . ' ' . $kandydat['nazwisko'] . ' ' .  $kandydat['zameldowanie_ulica'] . ' ' . 
												$kandydat['zameldowanie_dom_nr'] . '/' . $kandydat['zameldowanie_mieszkanie_nr'] . ' ' . $kandydat['zameldowanie_miasto'],
												'WSTE ul. Zamkowa 1, 34-200 Sucha Beskidzka',
												($kandydat['studia_typ'] == 'mgr') ? '100,00' : '300,00', '47124048781111000047196926');
		$generator->generate();
		//$response->sendContent();
		return sfView::NONE;			
		
	}

	public function executePetition(sfWebRequest $request) {
		$kandydat = Doctrine :: getTable('Kandydat')->find(array ($this->getUser()->getAttribute('kandydatId')));
		$this->forward404Unless($kandydat, 'Obiekt nie istnieje');
		sfContext :: getInstance()->getLogger()->debug('executePodanie przed tworzeniem pdf table');
		$pdf = new FPdfTable();
		$podanie = new Prosba($kandydat);
		//sprawdzamy czy istnieje katalog dla user'a
		if (file_exists(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin()))
			//kasujemy plik, ktory tam jest
			@unlink(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/prosba.pdf');
		else
			//tworzymy katalog
			mkdir(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin());		
		//sfContext :: getInstance()->getLogger(0)->debug('zaczynam generowac pdf');
		$podanie->generate($pdf, sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/prosba.pdf' );
		//sfContext :: getInstance()->getLogger()->debug('wygenerowano plik');			
	  	$response = $this->getResponse();
	  	$response->clearHttpHeaders();		
		$response->setHttpheader('Pragma: public', true);
		$response->addCacheControlHttpHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
		$response->setHttpHeader("Last-Modified", gmdate("D, d M Y H:i:s") . " GMT");
		$response->setContentType('application/pdf');
		$response->setHttpHeader('Content-Description', 'File Transfer');
		$response->setHttpHeader('Content-Transfer-Encoding', 'binary', true);
		$response->setHttpHeader('Content-Disposition', 'attachment; filename=' . str_replace(" ", "_", utf8_decode('prosba.pdf')));
		$response->sendHttpHeaders();
		
		$response->setContent(readfile(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/prosba.pdf'));
		$response->sendContent();

		return sfView::NONE;			

	}

	public function executeTeczka(sfWebRequest $request) {
		$kandydat = Doctrine :: getTable('Kandydat')->find(array ($this->getUser()->getAttribute('kandydatId')));
		$this->forward404Unless($kandydat, 'Obiekt nie istnieje');
		$pdf = new FPdfTable();
		$teczka = new Teczka($kandydat);
		//sprawdzamy czy istnieje katalog dla user'a
		if (file_exists(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin()))
			//kasujemy plik, ktory tam jest
			@unlink(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/teczka.pdf');
		else
			//tworzymy katalog
			mkdir(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin());		
		//sfContext :: getInstance()->getLogger(0)->debug('zaczynam generowac pdf');
		$teczka->generate($pdf, sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/teczka.pdf' );
		//sfContext :: getInstance()->getLogger()->debug('wygenerowano plik');			
	  	$response = $this->getResponse();
	  	$response->clearHttpHeaders();		
		$response->setHttpheader('Pragma: public', true);
		$response->addCacheControlHttpHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
		$response->setHttpHeader("Last-Modified", gmdate("D, d M Y H:i:s") . " GMT");
		$response->setContentType('application/pdf');
		$response->setHttpHeader('Content-Description', 'File Transfer');
		$response->setHttpHeader('Content-Transfer-Encoding', 'binary', true);
		$response->setHttpHeader('Content-Disposition', 'attachment; filename=' . str_replace(" ", "_", utf8_decode('teczka.pdf')));
		$response->sendHttpHeaders();
		
		$response->setContent(readfile(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/teczka.pdf'));
		$response->sendContent();
		
		return sfView::NONE;			

	}
	//questionaire
	public function executeQuestionaire(sfWebRequest $request) {
		$kandydat = Doctrine :: getTable('Kandydat')->find(array ($this->getUser()->getAttribute('kandydatId')));
		$this->forward404Unless($kandydat, 'Obiekt nie istnieje');
		$pdf = new FPdfTable();
		$teczka = new Podanie($kandydat);
		//sprawdzamy czy istnieje katalog dla user'a
		if (file_exists(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin()))
			//kasujemy plik, ktory tam jest
			@unlink(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/podanie.pdf');
		else
			//tworzymy katalog
			mkdir(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin());		
		//sfContext :: getInstance()->getLogger(0)->debug('zaczynam generowac pdf');
		if ($kandydat->getStudiaTyp() == 'inz')
			$teczka->generateBsc($pdf, sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/podanie.pdf' );
		else
			$teczka->generateMsc($pdf, sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/podanie.pdf' );		
		//sfContext :: getInstance()->getLogger()->debug('wygenerowano plik');			
	  	$response = $this->getResponse();
	  	$response->clearHttpHeaders();		
		header('Cache-Control: no-store, no-cache, must-revalidate');
		$response->setHttpheader('Pragma: public', true);
		$response->addCacheControlHttpHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
		$response->setHttpHeader("Last-Modified", gmdate("D, d M Y H:i:s") . " GMT");
		$response->setContentType('application/pdf');
		$response->setHttpHeader('Content-Description', 'File Transfer');
		$response->setHttpHeader('Content-Transfer-Encoding', 'binary', true);
		$response->setHttpHeader('Content-Disposition', 'attachment; filename=' . str_replace(" ", "_", utf8_decode('podanie.pdf')));
		$response->sendHttpHeaders();
		
		$response->setContent(readfile(sfConfig::get('sf_data_dir') . '/pdf/' . $kandydat->getLogin() . '/podanie.pdf'));
		$response->sendContent();
		
		return sfView::NONE;			

	}
	

}