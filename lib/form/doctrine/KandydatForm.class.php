<?php

/**
 * Kandydat form.
 *
 * @package    form
 * @subpackage Kandydat
 * @version    SVN: $formId: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class KandydatForm extends BaseKandydatForm {
	
	public function __construct(Kandydat $kandydat = null, $path = '') {
		$this->path = $path;
		$this->kandydat = $kandydat;
		
		if($kandydat!=null) {
			$this->path = $kandydat->getLogin();
		}
		
		parent:: __construct($kandydat);
	}
	
	public function configure() {
				 
		$this->validatorSchema->setOption('allow_extra_fields', true);
    	$this->validatorSchema->setOption('filter_extra_fields', false);

		//Required => pole wymagane
		$fields = $this->validatorSchema->getFields();
		foreach ($fields as $k => $f) {
			$f->setMessage('required', 'Pole jest wymagane');
			$f->setMessage('invalid', 'Pole zawiera niedozwolone znaki');
		}

		
    	// --------------------- PLEC ------------------------
    	
		$this->widgetSchema['plec'] = new sfWidgetFormChoice(array(
	  		'choices' => Doctrine::getTable('Kandydat')->getPlecLista(), 
	  		'multiple' => false, 
	  		'expanded' => true
	  		));
	  		
  		$this->validatorSchema['plec'] = new sfValidatorChoice(array(
	  		'choices' => array_keys(Doctrine::getTable('Kandydat')->getPlecLista()), 
	  		'multiple' => false
	  		));
	  	// ---------------------------------------------------
	  	// ------------------- MATKA IMIE ----------------------
  		$this->validatorSchema['matka_imie'] = new sfValidatorRegex(array(
  			'pattern' => '/^[^0-9 &<>%\*\,\.\/]{3,40}$/'
  		));
	  		
	  	// ---------------------------------------------------
	  	// ------------------- OJCIEC IMIE ----------------------
  		$this->validatorSchema['ojciec_imie'] = new sfValidatorRegex(array(
	  		'pattern' => '/^[^0-9 &<>%\*\,\.\/]{3,40}$/'
	  		));
	  		
	  	// ---------------------------------------------------
	  	// ------------ ZAMELDOWANIE ULICA -------------------
		$this->validatorSchema['zameldowanie_ulica'] = new sfValidatorAnd(array (
			$this->validatorSchema['zameldowanie_ulica'],
			new sfValidatorRegex(array (
				'pattern' => '/^[a-zA-Z0-9- \wł\wń\wś\wć\wż\wź\wó\wą\wę\wŁ\wŻ\wŹ\wĆ\wÓ]+$/',
				'required' => false,
				'trim' => true
			), array (
				'invalid' => 'Pole zawiera niedozwolone znaki'
			))
		), array('required' => false, 'trim' => true));
	  		
	  	// ---------------------------------------------------
	  	// -------------- ZAMELDOWANIE NR DOMU ---------------
		$this->validatorSchema['zameldowanie_mieszkanie_nr'] = new sfValidatorAnd(array (
			$this->validatorSchema['zameldowanie_mieszkanie_nr'],
			new sfValidatorRegex(array (
				'pattern' => '/^[0-9]+[a-zA-Z]?$/'
			), array (
				'invalid' => 'Numer może się składać z cyfr i maksymalnie jednej litery na końcu'
			))
		), array (
			'required' => false,
			'trim' => true
		), array('required' => true));
	  		
	  	// ---------------------------------------------------
	  	// ----------- ZAMELDOWANIE NR MIESZKANIA ------------
		$this->validatorSchema['zameldowanie_dom_nr'] = new sfValidatorAnd(array (
			new sfValidatorString(array (
				'max_length' => 6,
				'min_length' => 1
			), array (
				'max_length' => 'Długość pola musi wynosić max 6 znaków',
				'min_length' => 'Długość pola musi wynosić min 1 znak'
			)),
			new sfValidatorRegex(array (
				'pattern' => '/^[0-9]+[a-zA-Z]?$/',
				'required' => false,
			), array (
				'invalid' => 'Numer może się składać z cyfr i maksymalnie jednej litery na końcu'
			))
		), array('required' => false));
	  		
	  	// ---------------------------------------------------
	  	// ---------------- ZAMELDOWANIE KOD -----------------

		$this->validatorSchema['zameldowanie_kod'] = new sfValidatorAnd(array (
			new sfValidatorString(array (
				'max_length' => 6,
				'min_length' => 6
			), array (
				'max_length' => 'Długość pola musi wynosić 6 znaków',
				'min_length' => 'Długość pola musi wynosić 6 znaków'
			)),
			new sfValidatorRegex(array (
				'pattern' => '/^[0-9]{2}-[0-9]{3}+$/',
				'required' => false,
				'trim' => true
			), array (
				'invalid' => 'Niepoprawny format pola kod, format wymagany: xx-xxx'
			))
		), array('required' => false));
		//----------------------------------------------------
		//------------- MIASTO -------------------------------
		$this->validatorSchema['zameldowanie_miasto'] = new sfValidatorAnd(array (
			$this->validatorSchema['zameldowanie_miasto'],
			new sfValidatorRegex(array (
				'pattern' => '/^[a-zA-Z0-9- \wł\wń\wś\wć\wż\wź\wó\wą\wę\wŁ\wŚ\wŃ\wŻ\wŹ\wĆ\wÓ]+$/',
				'required' => false,
				'trim' => true
			), array (
				'invalid' => 'Pole zawiera niedozwolone znaki'
			))
		), array('required' => true, 'trim' => true));
		$this->widgetSchema['zameldowanie_wojewodztwo'] = new sfWidgetFormChoice(array(
	  		'choices' => Doctrine::getTable('Kandydat')->getWojewodztwa(), 
	  		'multiple' => false, 
	  		'expanded' => false
	  		));
	  		
  		$this->validatorSchema['zameldowanie_wojewodztwo'] = new sfValidatorChoice(array(
	  		'choices' => array_keys(Doctrine::getTable('Kandydat')->getWojewodztwa()), 
	  		'multiple' => false
	  		));
		
	  	// ---------------------------------------------------
	  	// ------------ KOREPONDENCJA ULICA -------------------
		$this->validatorSchema['korespondencja_ulica'] = new sfValidatorAnd(array (
			$this->validatorSchema['korespondencja_ulica'],
			new sfValidatorRegex(array (
				'pattern' => '/^[a-zA-Z0-9- \wł\wń\wś\wć\wż\wź\wó\wą\wę\wŁ\wŻ\wŹ\wĆ\wÓ]+$/',
				'required' => false,
				'trim' => true
			), array (
				'invalid' => 'Pole zawiera niedozwolone znaki'
			))
		), array('required' => false));
	  		
	  	// ---------------------------------------------------
	  	// -------------- KOREPONDENCJA NR DOMU ---------------
		$this->validatorSchema['korespondencja_mieszkanie_nr'] = new sfValidatorAnd(array (
			$this->validatorSchema['korespondencja_mieszkanie_nr'],
			new sfValidatorRegex(array (
				'pattern' => '/^[0-9]+[a-zA-Z]?$/'
			), array (
				'invalid' => 'Numer może się składać z cyfr i maksymalnie jednej litery na końcu'
			))
		), array (
			'required' => false,
			'trim' => true
		), array('required' => false));
	  		
	  	// ---------------------------------------------------
	  	// ----------- KOREPONDENCJA NR MIESZKANIA ------------
		$this->validatorSchema['korespondencja_dom_nr'] = new sfValidatorAnd(array (
			new sfValidatorString(array (
				'max_length' => 6,
				'min_length' => 1
			), array (
				'max_length' => 'Długość pola musi wynosić max 6 znaków',
				'min_length' => 'Długość pola musi wynosić min 1 znak'
			)),
			new sfValidatorRegex(array (
				'pattern' => '/^[0-9]+[a-zA-Z]?$/',
				'required' => false,
			), array (
				'invalid' => 'Numer może się składać z cyfr i maksymalnie jednej litery na końcu'
			))
		), array('required' => false));
	  		
	  	// ---------------------------------------------------
	  	// ---------------- KOREPONDENCJA KOD -----------------
		$this->validatorSchema['korespondencja_kod'] = new sfValidatorAnd(array (
			new sfValidatorString(array (
				'max_length' => 6,
				'min_length' => 6
			), array (
				'max_length' => 'Długość pola musi wynosić 6 znaków',
				'min_length' => 'Długość pola musi wynosić 6 znaków'
			)),
			new sfValidatorRegex(array (
				'pattern' => '/^[0-9]{2}-[0-9]{3}+$/',
				'required' => false,
				'trim' => true
			), array (
				'invalid' => 'Niepoprawny format pola kod, format wymagany: xx-xxx'
			))
		), array('required' => false));
		//miasto
		$this->validatorSchema['korespondencja_miasto'] = new sfValidatorAnd(array (
			$this->validatorSchema['zameldowanie_miasto'],
			new sfValidatorRegex(array (
				'pattern' => '/^[a-zA-Z0-9- \wł\wń\wś\wć\wż\wź\wó\wą\wę\wŁ\wŻ\wŹ\wĆ\wÓ]+$/',
				'required' => false,
				'trim' => true
			), array (
				'invalid' => 'Pole zawiera niedozwolone znaki'
			))
		), array('required' => false, 'trim' => true));
		$this->widgetSchema['korespondencja_wojewodztwo'] = new sfWidgetFormChoice(array(
	  		'choices' => Doctrine::getTable('Kandydat')->getWojewodztwa(), 
	  		'multiple' => false, 
	  		'expanded' => false
	  		));
	  		
  		$this->validatorSchema['korespondencja_wojewodztwo'] = new sfValidatorChoice(array(
	  		'choices' => array_keys(Doctrine::getTable('Kandydat')->getWojewodztwa()), 
	  		'multiple' => false
	  		));
	  		
	  	// ---------------------------------------------------
  		// ------------------- KIERUNEK ----------------------
  		$this->widgetSchema['kierunek'] = new sfWidgetFormChoice(array(
	  		'choices' => Doctrine::getTable('Kandydat')->getKierunekLista(), 
	  		'multiple' => false
	  		)); 
	  		
	  	$this->validatorSchema['kierunek'] = new sfValidatorChoice(array(
	  		'choices' => array_keys(Doctrine::getTable('Kandydat')->getKierunekLista()), 
	  		'multiple' => false
	  		));
	  		
	  	// ---------------------------------------------------
		// ------------------ STACJONARNE --------------------
		$this->widgetSchema['stacjonarne'] = new sfWidgetFormChoice(array(
			'choices' => array(0=>'stacjonarne',1=>'niestacjonarne'),
	  		'multiple' => false,
			'expanded' => true
	  		));
	  		
	  	$this->validatorSchema['stacjonarne'] = new sfValidatorChoice(array(
	  		'choices' => array(0,1), 
	  		'multiple' => false
	  		));
	  		
	  	// ---------------------------------------------------
	  	// -------------------- MGR --------------------------
	  	$this->widgetSchema['studia_typ'] = new sfWidgetFormChoice(array(
	  		'choices'=> Doctrine::getTable('Kandydat')->getTypStudiowLista(), 
	  		'multiple' => false, 
	  		'expanded' => true
	  		));

	  	$this->validatorSchema['studia_typ'] = new sfValidatorString(array('max_length' => 15), array('max_length' => 'Pole jest za długie'));	  	
		$this->validatorSchema['inne_studia'] = new sfValidatorString(array('max_length' => 255, 'required' => false), array('max_length' => 'Pole jest za długie'));	  	
		$this->validatorSchema['skonczone_studia'] = new sfValidatorString(array('max_length' => 80, 'required' => false), array('max_length' => 'Pole jest za długie'));	  	
		$this->validatorSchema['pytanie_haslo'] = new sfValidatorString(array('max_length' => 80, 'required' => false), array('max_length' => 'Pole jest za długie'));	  	
		$this->validatorSchema['odpowiedz_haslo'] = new sfValidatorString(array('max_length' => 25, 'required' => false), array('max_length' => 'Pole jest za długie'));	  	

	  	// ---------------------------------------------------
	  	// ---------------- KORSPONDENCJA --------------------
	  	
  		$this->widgetSchema['korespondencja'] = new sfWidgetFormInputCheckbox(array(
  			));
  			
  		// ---------------------------------------------------	
		// --------------- NIEPELNOSPRAWNY -------------------
		
  		$this->widgetSchema['niepelnosprawny'] = new sfWidgetFormInputCheckbox();		
		
  		$this->validatorSchema['niepelnosprawny'] = new sfValidatorBoolean();
  		
  		// ---------------------------------------------------
  		// -------------------- LOGIN ------------------------
		
	  	$this->widgetSchema['login'] = new sfWidgetFormInput(array(
	  		),
	  		!$this->isNew() ? array('readonly'=>'readonly') : array()
	  		);  
	  	
	    $this->validatorSchema['login'] = new LoginValidator(!$this->isNew() ? array('kandydat_id' => $this->getObject()->getId()) : array()); 
	  		
	  	// ---------------------------------------------------
		// ------------------- HASLO -------------------------
		
		$this->widgetSchema['haslo'] = new sfWidgetFormInputPassword(array(
  			));
  		
		
  		$this->widgetSchema['haslo2'] = new sfWidgetFormInputPassword(array(
  			)); 
  		  		
  		$this->validatorSchema['haslo2'] = clone
			$this->validatorSchema['haslo'];
			    $this->mergePostValidator(
			      new sfValidatorSchemaCompare(
			        'haslo2', sfValidatorSchemaCompare::EQUAL, 'haslo',
			        array(), array('invalid' => 'Powtórzone hasło musi być takie samo'))); 
  		
  		// ---------------------------------------------------
  		// ------------------- PESEL -------------------------
  		
	  	$this->widgetSchema['pesel'] = new sfWidgetFormInput();
	  	
	  	//$this->validatorSchema['pesel'] = new PeselUniqueValidator(!$this->isNew() ? array('kandydat_id' => $this->getObject()->getId()) : array());

  		// ---------------------------------------------------
  		// ------------------- NIP ---------------------------	  	
	  	$this->validatorSchema['nip'] = new NipValidator(!$this->isNew() ? array('required' => false, 'kandydat_id' => $this->getObject()->getId()) : array('required' => false));
	  	// ---------------------------------------------------
	  	// ---------------- SPECJALNOSC ----------------------
	  		
	  	$this->widgetSchema['specjalnosc'] = new sfWidgetFormChoice(array(
	  		'choices' => array(), 
	  		'multiple' => false
	  		));
	  		
	  	// ---------------------------------------------------
	  	// -------------------- JEZYK ------------------------
	  		
	  	$this->widgetSchema['jezyk'] = new sfWidgetFormChoice(array(
	  		'choices' => array(), 
	  		'multiple' => false
	  		));

	  	$this->validatorSchema['jezyk'] = new sfValidatorChoice(array(
	  		'choices' => array('angielski','niemiecki','francuski','wloski'), 
	  		'multiple' => false,
	  		'required'   => false
	  		));
	  		
	  	// ---------------------------------------------------
	  	// -------------------- JEZYK2 -----------------------
	  		
	    $this->widgetSchema['jezyk2'] = new sfWidgetFormChoice(array(
	  		'choices' => array(), 
	  		'multiple' => false
	  		));
	  	
	  	$this->validatorSchema['jezyk2'] = new sfValidatorChoice(array(
	  		'choices' => array('brak', 'angielski','niemiecki','francuski','wloski'), 
	  		'multiple' => false,
	  		'required'   => false
	  		));
	  		
	  	// ---------------------------------------------------
	  	// ----------- STOSUNEK DO SLUZBY WOJSKOWEJ ----------
	  		
	  	$this->widgetSchema['stosunek_do_sluzby_wojskowej'] = new sfWidgetFormChoice(array(
	  		'choices' => array(
	  					'uregulowany' => 'uregulowany',
	  					'nieuregulowany' => 'nieuregulowany'
	  					),
	  		'multiple' => false
	  		));
	  		
	  	$this->validatorSchema['stosunek_do_sluzby_wojskowej'] = new sfValidatorChoice(array(
	  		'choices' => array('uregulowany', 'nieuregulowany'), 
	  		'multiple' => false
	  		));

	  	// ---------------------------------------------------
	  		
	  	$this->widgetSchema['inne_studia'] = new sfWidgetFormTextarea(array(
	  		));
		
	  	// zasieg lat - od tego roku do 50 lat wczesniej (DESC)
	  	$yearRange = range(date('Y'),date('Y',mktime(0,0,0,0,0,date('Y')-50)),1);
	  	$yearRange = array_combine($yearRange,$yearRange);
	  	
	  	// ---------------------------------------------------
	  	// -------- SZKOLA SREDNIA ROK UKONCZENIA ------------
	  	
	  	$this->widgetSchema['szkola_srednia_rok_ukonczenia'] = new sfWidgetFormChoice(array(
	  		'choices' => $yearRange,
	  		'multiple' => false
	  	));

	  	$this->validatorSchema['szkola_srednia_rok_ukonczenia'] = new sfValidatorChoice(array(
	  		'choices' => array_keys($yearRange), 
	  		'multiple' => false
	  		));

	  	// ---------------------------------------------------
	  	// ------------ STUDIA ROK UKONCZENIA ----------------
		$newRange = array('-' => '-');
		foreach ($yearRange as $k=>$v)
			$newRange[$k] = $v;			
	  	$this->widgetSchema['skonczone_studia_rok_ukonczenia'] = new sfWidgetFormChoice(array(
	  		'choices' => $newRange,
	  		'multiple' => false
	  	));
	  	
	  	/*$this->validatorSchema['skonczone_studia_rok_ukonczenia'] = new sfValidatorChoice(array(
	  		'choices' => array_merge(array('-'), $yearRange),
	  		'multiple' => false
	  		));*/
	  		
	  	// ---------------------------------------------------
	  	// ----------------- SKAD WIEM -----------------------
	  	
	  	$this->widgetSchema['skad_wiem'] = new sfWidgetFormChoice(array(
	  		'choices' => array(
	  						'internet' => 'z internetu',
	  						'radio' => 'z ogłoszenia w radiu',
	  						'telewizja' => 'ogłoszenia w telewizji',
	  						'znajomi' => 'od znajomych',
	  						'ulotka' => 'z ulotki',
	  						'plakat' => 'z plakatu',
	  						'targi' => 'na targach edukacyjnych',
	  						'spotkanie' => 'na spotkaniu zorganizowanym w szkole',
	  						'inne' => 'inne'
	  						), 
	  		'multiple' => false
	  		));
	  		
	  	$this->validatorSchema['skad_wiem'] = new sfValidatorChoice(array(
			'choices' => array(
	  						'internet',
	  						'radio',
	  						'telewizja',
	  						'znajomi',
	  						'ulotka',
	  						'plakat',
	  						'targi',
	  						'spotkanie',
	  						'inne'
	  						),
	  		'multiple' => false
		));

		$this->validatorSchema['telefon_nr'] = new sfValidatorAnd(array (
			new sfValidatorString(array (
				'max_length' => 12,
				'min_length' => 5
			), array('max_length' => 'Wprowadzony nr jest za długi. ', 'min_length' => 'Wprowadzony nr jest za krótki. ')),
			new sfValidatorRegex(array (
				'pattern' => '/^\+?[0-9]{2}[0-9 ]+$/',
				'required' => false
			), array (
				'invalid' => 'Niepoprawny nr telefonu'
			))
		), array('required' => true, 'trim' => true));
		//telefon komorkowy
		$this->validatorSchema['mobile_nr'] = new sfValidatorAnd(array (
			new sfValidatorString(array (
				'max_length' => 12,
				'min_length' => 9
			), array('max_length' => 'Wprowadzony nr jest za długi. ', 'min_length' => 'Wprowadzony nr jest za krótki. ')),
			new sfValidatorRegex(array (
				'pattern' => '/^\+?[0-9]{2}[0-9 ]+$/',
				'required' => false
			), array (
				'invalid' => 'Niepoprawny nr telefonu'
			))
		), array('trim' => false, 'required' => false));
		$this->validatorSchema['email'] = new sfValidatorAnd(array (
			$this->validatorSchema['email'],
			new EmailUniqueValidator(array('kandydat_id' => $this->getObject()->getId())),
		), array('required' => true, 'trim' => true));
		
		// ---------------------------------------------------
		// --------------- PLYWANIE GRUPA --------------------
	  		
	  	$this->widgetSchema['plywanie_grupa'] = new sfWidgetFormChoice(array(
	  		'choices' => array(
	  						'zaawansowana' => 'zaawansowana',
	  						'srednia' => 'średnia',
	  						'podstawowa' => 'podstawowa',
	  						), 
	  		'multiple' => false
	  		));
	  		
	  	$this->validatorSchema['plywanie_grupa'] = new sfValidatorChoice(array(
			'choices' => array(
	  						'zaawansowana',
	  						'srednia',
	  						'podstawowa'
	  						),
	  		'multiple' => false,
	  		'required' => false
		));

		$this->widgetSchema['wku_miasto'] = new sfWidgetFormChoice(array(
			'choices' => array(
				'nie dotyczy' => 'nie dotyczy',
				'Będzin 45-500 ul. Kościuszki 32' => 'Będzin 45-500 ul. Kościuszki 32',
				'Biała Podlaska 21-500 ul. 1000-lecia 20' => 'Biała Podlaska 21-500 ul. 1000-lecia 20',
				'Białystok 15-428 ul. Lipowa 35' => 'Białystok 15-428 ul. Lipowa 35',
				'Bielsk Podlaski 17-100 ul. Dubiażyńska 2' => 'Bielsk Podlaski 17-100 ul. Dubiażyńska 2',
				'Bielsko-Biała 43-300 ul. Piastowska 14' => 'Bielsko-Biała 43-300 ul. Piastowska 14',
				'Bochnia 32-700 ul. Św. Leonarda 22' => 'Bochnia 32-700 ul. Św. Leonarda 22',
				'Bolesławiec 59-700 ul. B. Chrobrego 5' => 'Bolesławiec 59-700 ul. B. Chrobrego 5',
				'Brodnica 87-300 ul. Królowej Jadwigi 4' => 'Brodnica 87-300 ul. Królowej Jadwigi 4',
				'Brzeg 49-300 ul. B. Chrobrego 21' => 'Brzeg 49-300 ul. B. Chrobrego 21',
				'Busko Zdrój 28-100 ul. Bohaterów Warszawy 10' => 'Busko Zdrój 28-100 ul. Bohaterów Warszawy 10',
				'Bydgoszcz 85-915 ul. Szubińska 1' => 'Bydgoszcz 85-915 ul. Szubińska 1',
				'Chełm 22-100 ul. Koszarowa 1B' => 'Chełm 22-100 ul. Koszarowa 1B',
				'Chorzów 41-500 ul. 75 Pułku Piechoty 3' => 'Chorzów 41-500 ul. 75 Pułku Piechoty 3',
				'Ciechanów 06-400 ul. Orylska 6' => 'Ciechanów 06-400 ul. Orylska 6',
				'Częstochowa 42-200 ul. Legionów 20' => 'Częstochowa 42-200 ul. Legionów 20',
				'Człuchów 77-300 ul. Wojska Polskiego 11' => 'Człuchów 77-300 ul. Wojska Polskiego 11',
				'Elbląg 82-300 ul. Królewiecka 167A' => 'Elbląg 82-300 ul. Królewiecka 167A',
				'Ełk 19-300 ul. Mickiewicza 40' => 'Ełk 19-300 ul. Mickiewicza 40',
				'Garwolin 08-400 ul. Kościuszki 28' => 'Garwolin 08-400 ul. Kościuszki 28',
				'Gdańsk-1 80-018 ul. Trakt św. Wojciecha 253' => 'Gdańsk-1 80-018 ul. Trakt św. Wojciecha 253',
				'Gdańsk-2 80-259 ul. Obywatelska 2' => 'Gdańsk-2 80-259 ul. Obywatelska 2',
				'Gdynia 81-912 ul. Pułaskiego 7' => 'Gdynia 81-912 ul. Pułaskiego 7',
				'Giżycko 11-500 ul. Moniuszki 7' => 'Giżycko 11-500 ul. Moniuszki 7',
				'Gliwice 44-100 ul. Zawiszy Czarnego 7' => 'Gliwice 44-100 ul. Zawiszy Czarnego 7',
				'Głogów 67-200 ul. Wojska Polskiego 58' => 'Głogów 67-200 ul. Wojska Polskiego 58',
				'Gniezno 62-200 ul. Pocztowa 9' => 'Gniezno 62-200 ul. Pocztowa 9',
				'Gorzów Wielkopolski 66-400 ul. Kosynierów Gdyńskich 21' => 'Gorzów Wielkopolski 66-400 ul. Kosynierów Gdyńskich 21',
				'Grójec 05-600 ul. Piłsudskiego 58' => 'Grójec 05-600 ul. Piłsudskiego 58',
				'Grudziądz 86-300 ul. Legionów 48' => 'Grudziądz 86-300 ul. Legionów 48',
				'Gryfice 72-300 ul. Górska 2' => 'Gryfice 72-300 ul. Górska 2',
				'Inowrocław 88-100 ul. Dworcowa 27' => 'Inowrocław 88-100 ul. Dworcowa 27',
				'Jarosław 37-500 ul. Głęboka 4' => 'Jarosław 37-500 ul. Głęboka 4',
				'Jasło 38-300 ul. Kościuszki 24' => 'Jasło 38-300 ul. Kościuszki 24',
				'Jelenia Góra 58-500 ul. Obrońców Pokoju 26' => 'Jelenia Góra 58-500 ul. Obrońców Pokoju 26',
				'Kalisz 62-800 pl. Św. Józefa 5' => 'Kalisz 62-800 pl. Św. Józefa 5',
				'Katowice 40-028 ul. Francuska 30' => 'Katowice 40-028 ul. Francuska 30',
				'Kędzierzyn-Koźle 47-200 ul. Łukasiewicza 11' => 'Kędzierzyn-Koźle 47-200 ul. Łukasiewicza 11',
				'Kielce Bukówka 25-205 ul. Wojska Polskiego 250' => 'Kielce Bukówka 25-205 ul. Wojska Polskiego 250',
				'Kielce Śródmieście 25-953 ul. Wesoła 29' => 'Kielce Śródmieście 25-953 ul. Wesoła 29',
				'Kłodzko 57-300 ul. Bohaterów Getta 7' => 'Kłodzko 57-300 ul. Bohaterów Getta 7',
				'Kołobrzeg 78-100 ul. Jedności Narodowej 9' => 'Kołobrzeg 78-100 ul. Jedności Narodowej 9',
				'Konin 62-510 ul. Hurtowa 1' => 'Konin 62-510 ul. Hurtowa 1',
				'Koszalin 75-901 ul. Zwycięstwa 202A' => 'Koszalin 75-901 ul. Zwycięstwa 202A',
				'Kozienice 26-900 ul. Radomska 36' => 'Kozienice 26-900 ul. Radomska 36',
				'Kraków Krowodrza 30-901 ul. Rydla 19' => 'Kraków Krowodrza 30-901 ul. Rydla 19',
				'Kraków Nowa Huta 30-901 ul. Rakowicka 22' => 'Kraków Nowa Huta 30-901 ul. Rakowicka 22',
				'Kraków Podgórze 31-069 ul. Koletek 10' => 'Kraków Podgórze 31-069 ul. Koletek 10',
				'Legnica 59-220 ul. Partyzantów 22' => 'Legnica 59-220 ul. Partyzantów 22',
				'Leszno 64-100 ul. Zamenhoffa 32' => 'Leszno 64-100 ul. Zamenhoffa 32',
				'Lidzbark Warmiński 11-100 ul. Spółdzielców 24' => 'Lidzbark Warmiński 11-100 ul. Spółdzielców 24',
				'Lublin-1 20-043 ul. Spadochroniarzy 5' => 'Lublin-1 20-043 ul. Spadochroniarzy 5',
				'Lublin-2 20-043 ul. Aleje Racławickie 44' => 'Lublin-2 20-043 ul. Aleje Racławickie 44',
				'Lubliniec 42-700 ul. ZHP 1' => 'Lubliniec 42-700 ul. ZHP 1',
				'Łomża 18-400 ul. Polowa 12' => 'Łomża 18-400 ul. Polowa 12',
				'Łódź-1 90-646 ul. 6 Sierpnia 104' => 'Łódź-1 90-646 ul. 6 Sierpnia 104',
				'Łódź-2 90-950 ul. A. Struga 65' => 'Łódź-2 90-950 ul. A. Struga 65',
				'Malbork 82-200 pl. 3 Maja 4' => 'Malbork 82-200 pl. 3 Maja 4',
				'Mielec 39-300 ul. Legionów 25' => 'Mielec 39-300 ul. Legionów 25',
				'Mińsk Mazowiecki 05-300 ul. Piękna 3' => 'Mińsk Mazowiecki 05-300 ul. Piękna 3',
				'Mysłowice 41-400 ul. Starokościelna 2' => 'Mysłowice 41-400 ul. Starokościelna 2',
				'Nisko 37-500 ul. Kościuszki 2' => 'Nisko 37-500 ul. Kościuszki 2',
				'Nowy Dwór Mazowiecki 05-100 ul. Paderewskiego 6/11' => 'Nowy Dwór Mazowiecki 05-100 ul. Paderewskiego 6/11',
				'Nowy Sącz 33-200 ul. Czarnieckiego 13' => 'Nowy Sącz 33-200 ul. Czarnieckiego 13',
				'Nowy Targ 34-400 Osiedle Bór 10' => 'Nowy Targ 34-400 Osiedle Bór 10',
				'Nowy Tomyśl 64-300 ul. 3 Stycznia 3' => 'Nowy Tomyśl 64-300 ul. 3 Stycznia 3',
				'Nysa 48-300 ul. Marcinkowskiego 4' => 'Nysa 48-300 ul. Marcinkowskiego 4',
				'Olsztyn 10-702 ul. Warszawska 96' => 'Olsztyn 10-702 ul. Warszawska 96',
				'Opole 45-360 ul. Plebiscytowa 5' => 'Opole 45-360 ul. Plebiscytowa 5',
				'Ostrołęka 07-409 ul. Sienkiewicza 61' => 'Ostrołęka 07-409 ul. Sienkiewicza 61',
				'Ostróda 14-100 ul. Czarnieckiego 28' => 'Ostróda 14-100 ul. Czarnieckiego 28',
				'Ostrów Wielkopolski 63-400 ul. Wojska Polskiego 15' => 'Ostrów Wielkopolski 63-400 ul. Wojska Polskiego 15',
				'Oświęcim 32-600 ul. Orzeszkowej 9' => 'Oświęcim 32-600 ul. Orzeszkowej 9',
				'Piła 64-920 ul. Kossaka 16' => 'Piła 64-920 ul. Kossaka 16',
				'Piotrków Trybunalski 97-300 ul. Dąbrowskiego 14' => 'Piotrków Trybunalski 97-300 ul. Dąbrowskiego 14',
				'Płock 09-400 ul. Kilińskiego 12' => 'Płock 09-400 ul. Kilińskiego 12',
				'Poznań-1 60-959 ul. Rolna 51/53' => 'Poznań-1 60-959 ul. Rolna 51/53',
				'Poznań-2 60-811 ul. Bukowska 34A' => 'Poznań-2 60-811 ul. Bukowska 34A',
				'Poznań-3 60-959 ul. Polna 39' => 'Poznań-3 60-959 ul. Polna 39',
				'Puławy 24-100 ul. Piłsudskiego 93' => 'Puławy 24-100 ul. Piłsudskiego 93',
				'Radom 26-600 ul. 1905 roku 30' => 'Radom 26-600 ul. 1905 roku 30',
				'Rybnik 44-200 ul. Piłsudskiego 2' => 'Rybnik 44-200 ul. Piłsudskiego 2',
				'Rzeszów 35-205 ul. Konopnickiej 5' => 'Rzeszów 35-205 ul. Konopnickiej 5',
				'Sandomierz 27-600 ul. Puławiaków 12' => 'Sandomierz 27-600 ul. Puławiaków 12',
				'Sanok 38-500 ul. Przemyska 1' => 'Sanok 38-500 ul. Przemyska 1',
				'Siedlce 08-110 ul. Wałowa 1' => 'Siedlce 08-110 ul. Wałowa 1',
				'Sieradz 98-200 ul. Pułaskiego 1' => 'Sieradz 98-200 ul. Pułaskiego 1',
				'Skierniewice 96-100 ul. Batorego 64A' => 'Skierniewice 96-100 ul. Batorego 64A',
				'Słupsk 76-200 ul. Obrońców Westerplatte 8' => 'Słupsk 76-200 ul. Obrońców Westerplatte 8',
				'Starachowice 27-200 ul. Mrozowskiego 9' => 'Starachowice 27-200 ul. Mrozowskiego 9',
				'Stargard Szczeciński 73-110 ul. Czarnieckiego 31' => 'Stargard Szczeciński 73-110 ul. Czarnieckiego 31',
				'Starogard Gdański 83-200 ul. Sikorskiego 18' => 'Starogard Gdański 83-200 ul. Sikorskiego 18',
				'Sulęcin 69-200 ul. Emilii Plater 5' => 'Sulęcin 69-200 ul. Emilii Plater 5',
				'Suwałki 16-400 ul. Pułaskiego 24' => 'Suwałki 16-400 ul. Pułaskiego 24',
				'Szczecin 70-241 ul. Kopernika 17' => 'Szczecin 70-241 ul. Kopernika 17',
				'Szczecin Podjuchy 70-727 ul. Metalowa 42' => 'Szczecin Podjuchy 70-727 ul. Metalowa 42',
				'Szczecinek 78-400 ul. Kościuszki 55' => 'Szczecinek 78-400 ul. Kościuszki 55',
				'Świdnica 58-100 pl. Grunwaldzki 2' => 'Świdnica 58-100 pl. Grunwaldzki 2',
				'Świecie 86-100 ul. Kościuszki 5A' => 'Świecie 86-100 ul. Kościuszki 5A',
				'Świnoujście 72-600 ul. Piłsudskiego 24' => 'Świnoujście 72-600 ul. Piłsudskiego 24',
				'Tarnowskie Góry 42-600 ul. Mickiewicza 18' => 'Tarnowskie Góry 42-600 ul. Mickiewicza 18',
				'Tarnów 33-100 ul. Dąbrowskiego 11' => 'Tarnów 33-100 ul. Dąbrowskiego 11',
				'Tomaszów Mazowiecki 97-200 ul. Polskiej Organizacji Wojskowej 9' => 'Tomaszów Mazowiecki 97-200 ul. Polskiej Organizacji Wojskowej 9',
				'Toruń 87-100 ul. Wały gen. Sikorskiego 21' => 'Toruń 87-100 ul. Wały gen. Sikorskiego 21',
				'Turek 62-700 ul. Szkolna 4' => 'Turek 62-700 ul. Szkolna 4',
				'Tychy 43-100 ul. Cyganerii 51' => 'Tychy 43-100 ul. Cyganerii 51',
				'Warszawa Mokotów 02-515 ul. Puławska 4/6' => 'Warszawa Mokotów 02-515 ul. Puławska 4/6',
				'Warszawa Ochota 02-313 ul. Sękocińska 8' => 'Warszawa Ochota 02-313 ul. Sękocińska 8',
				'Warszawa Praga Płd. 03-419 ul. Szwedzka 2/4' => 'Warszawa Praga Płd. 03-419 ul. Szwedzka 2/4',
				'Warszawa Praga Płn. 03-473 ul. Brechta 16' => 'Warszawa Praga Płn. 03-473 ul. Brechta 16',
				'Warszawa Śródmieście 02-008 ul. Koszykowa 82' => 'Warszawa Śródmieście 02-008 ul. Koszykowa 82',
				'Warszawa Żoliborz 01-558 ul. Mierosławskiego 22' => 'Warszawa Żoliborz 01-558 ul. Mierosławskiego 22',
				'Wejherowo 84-200 ul. Sobieskiego 227' => 'Wejherowo 84-200 ul. Sobieskiego 227',
				'Włocławek 87-800 ul. Okrężna 25A' => 'Włocławek 87-800 ul. Okrężna 25A',
				'Wrocław-1 50-984 ul. Gajowicka 118' => 'Wrocław-1 50-984 ul. Gajowicka 118',
				'Wrocław-3 51-168 ul. Sołtysowicka 23' => 'Wrocław-3 51-168 ul. Sołtysowicka 23',
				'Wyszków 07-200 ul. Serocka 3' => 'Wyszków 07-200 ul. Serocka 3',
				'Zambrów 18-300 ul. Magazynowa 9' => 'Zambrów 18-300 ul. Magazynowa 9',
				'Zamość 22-400 ul. Piłsudskiego 36' => 'Zamość 22-400 ul. Piłsudskiego 36',
				'Zgierz 95-100 ul. Długa 79' => 'Zgierz 95-100 ul. Długa 79',
				'Zielona Góra 65-147 ul. Urszuli 3' => 'Zielona Góra 65-147 ul. Urszuli 3',
				'Żagań 68-100 ul. 1 Maja 24' => 'Żagań 68-100 ul. 1 Maja 24',
				'Żywiec 43-300 ul. Zamkowa 10' => 'Żywiec 43-300 ul. Zamkowa 10'
			),
	  		'multiple' => false,
			'expanded' => false
	  		));
		
		// ---------------------------------------------------
		// ----------------- ZDJECIE -------------------------
		
	  	$this->widgetSchema['zdjecie'] = new sfWidgetFormInputFile(array(
	    	));
	    //echo 'path: '.$this->path;
	    $this->validatorSchema['zdjecie'] = new sfValidatorFile(array(
			'required'   => false,
			'path'       => sfConfig::get('sf_upload_dir').'/'.$this->path,
			'mime_types' => 'web_images',
    		));
    	/*
    	echo 'Poczatek:';
	    echo($this->path);
	    echo ':koniec';
	    */
	    //$path = $this->getDefault('path');
	    
	    //echo 'path: '.$path;
	    
	    // ---------------------------------------------------
	    
	    $this->widgetSchema->setLabels(array(
	    	'imiona' => 'Imiona*',
	    	'nazwisko' => 'Nazwisko*',
	    	'plec' => 'Płeć*',
	    	'urodzenie_miejsce' => 'Miejsce urodzenia*',
	    	'narodowosc' => 'Narodowość*',
	    	'obywatelstwo' => 'Obywatelstwo*',
	    	'matka_imie' => 'Imię matki*',
	    	'ojciec_imie' => 'Imię ojca*',
	    	'pesel' => 'PESEL',
	    	'nip' => 'NIP',
	    	'zameldowanie_ulica' => 'Ulica',
	    	'zameldowanie_dom_nr' => 'Numer domu',
	    	'zameldowanie_mieszkanie_nr' => 'Numer mieszkania',
	    	'zameldowanie_kod' => 'Kod pocztowy',
	    	'zameldowanie_miasto' => 'Miasto*',
	    	'zameldowanie_wojewodztwo' => 'Województwo',
	    	'korespondencja_ulica' => 'Ulica',
	    	'korespondencja_dom_nr' => 'Numer domu',
	    	'korespondencja_mieszkanie_nr' => 'Numer mieszkania',
	    	'korespondencja_kod' => 'Kod pocztowy',
	    	'korespondencja_miasto' => 'Miasto',
	    	'korespondencja_województwo' => 'Województwo',
	    	'stosunek_do_sluzby_wojskowej' => 'Stosunek do służby wojskowej',
	    	'ksiazeczka_wojskowa_nr' => 'Numer książeczki wojskowej',
	    	'niepelnosprawny' => 'Niepełnosprawny',
	    	'szkola_srednia' => 'Ukończona szkoła średnia*',
			'szkola_srednia_rok_ukonczenia' => 'Rok ukończenia szkoły średniej*',
	    	'skonczone_studia' => 'Skończone studia',
	    	'skonczone_studia_rok_ukonczenia' => 'Rok ukończenia studiów',
	    	'inne_studia' => 'Inne studia',
	    	'kierunek' => 'Wybierz studia, które zamierzasz rozpocząć*',
	    	'specjalnosc' => 'Specjalność',
	    	'stacjonarne' => 'Tryb studiów',
	    	'studia_typ' => 'Rodzaj studiów',
	    	'jezyk' => 'Język obcy',
	    	'jezyk2' => 'Język obcy dodatkowy',
	    	'plywanie_grupa' => 'Pływanie (grupa)',
	    	'login' => 'Login*',
			'email' => 'Email*',
	    	'haslo' => 'Hasło*',
	    	'haslo2' => 'Powtórz hasło*',
	    	'zdjecie' => 'Zdjęcie',
	    	'skad_wiem' => 'O szkole dowiedziałem się',
	    	'telefon_nr' => 'Nr telefonu*',
			'mobile_nr' => 'Telefon komórkowy',
	    	'wku_miasto' => 'WKU Miasto',
	    	'dowod_osobisty_nr' => 'Nr dowodu osobistego*',
	    	'pytanie_haslo' => 'Pytanie zadawane w przypadku zapomnienia hasła',
	    	'odpowiedz_haslo' => 'Odpowiedź'
	    	));	    

		$fields = $this->validatorSchema->getFields();			
		foreach ($fields as $k => $f) {
			$f->setMessage('required', 'Pole jest wymagane');
			$f->setMessage('invalid', 'Wartość jest nieprawidłowa');
		}
		
		$this->removeFields();
	}
	
	protected function removeFields() {
    	unset(
			$this['created_at'],
			$this['updated_at'],
			$this['id'],
		      
		      $this['szkola_komentarz'],
		      $this['dokumenty_dotarly'],
		      $this['przelew_otrzymany']
		);
	}
	
}