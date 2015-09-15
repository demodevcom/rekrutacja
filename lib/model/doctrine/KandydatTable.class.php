<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class KandydatTable extends Doctrine_Table
{
	
	static public $_KierunekLista = array(
		'informatyka' => 'Informatyka',
		'politologia' => 'Politologia',
		'turystyka i rekreacja' => 'Turystyka i rekreacja'
		);

	static public $_SpecjalnoscLista = array(
		'systemy' => 'Systemy baz danych',
		'inzynieria' => 'Inżynieria oprogramowania',
		'technologie' => 'Technologie multimedialne i grafika komputerowa',
		'komunikacja' => 'Komunikacja społeczna',
		'manager' => 'Manager projektów europejskich', 
		'polityka' => 'Polityka regionalna i samorządowa',
		'obsluga' => 'Obsługa ruchu turystycznego',
		'hotelarstwo' => 'Hotelarstwo i Gastronomia',
		'zarzadzanie' => 'Zarządzanie w turystyce', 
		'turystyka' => 'Turystyka międzynarodowa',

		'miedzynarodowa' => 'Turystyka międzynarodowa',
		'zarzadzanie_turystyka' => 'Zarządzanie turystyką i rekreacją',
		'informatyka_w_turystyce' => 'Informatyka w sektorze turystycznym',
		'zarzadzanie_promocja_regionalna' => 'Zarządzanie promocją regionalną i lokalną'
			
		);
	
	static public $wojewodztwaLista = array(
		'Dolnośląskie' => 'Dolnośląskie', 
		'Kujawsko-Pomorskie' => 'Kujawsko-Pomorskie', 
		'Lubelskie' => 'Kujawsko-Pomorskie',
		'Łódzkie' => 'Łódzkie',
		'Małopolskie' => 'Małopolskie',
		'Mazowieckie' => 'Mazowieckie',
		'Opolskie' => 'Opolskie',
		'Podkarpackie' => 'Podkarpackie',
		'Podlaskie' => 'Podlaskie',
		'Pomorskie' => 'Pomorskie',
		'Świętokrzyskie' => 'Świętokrzyskie',
		'Warmińsko-Mazurskie' => 'Warmińsko-Mazurskie',
		'Wielkopolskie' => 'Wielkopolskie',
		'Zachodniopomorskie' => 'Zachodniopomorskie',
		'Śląskie' => 'Śląskie',
		'Lubuskie' => 'Lubuskie'
	);

	static public $_PlecLista = array(
		false => 'kobieta',
		true => 'mężczyzna'
		);

	static public $_TypStudiowLista = array(
		'mgr' => 'magisterskie (II stopnia)',
		'inz' => 'inżynierskie/licencjackie'
		);
		
	public static function getKierunekLista() {
		return self::$_KierunekLista;
	}
	
	public static function getSpecjalnoscLista() {
		return self::$_SpecjalnoscLista;
	}
	
	public static function getWojewodztwa() {
		return self :: $wojewodztwaLista;
	}
	
	public static function getPlecLista() {
		return self::$_PlecLista;
	}
	
	public static function getTypStudiowLista() {
		return self::$_TypStudiowLista;
	}	

  	public function applyKierunekFilter(Doctrine_Query $q, $value) {
  		$rootAlias = $q->getRootAlias();
 		if (array_key_exists($value,self::$_KierunekLista))
 			$q->andWhere($rootAlias.'.kierunek = ?', $value);
    	return $q;
  	}

  	public function applyStacjonarneFilter(Doctrine_Query $q, $value) {
  		$rootAlias = $q->getRootAlias();
 		if ($value == '1')
 			$q->andWhere($rootAlias.'.stacjonarne = ?', 1);
 		if ($value == '0')
 			$q->andWhere($rootAlias.'.stacjonarne = ?', 0);
    	return $q;
  	}

  	public function applyStudiaTypFilter(Doctrine_Query $q, $value) {
  		$rootAlias = $q->getRootAlias();
 		if ($value === 'inz')
 			$q->andWhere($rootAlias.'.studia_typ = ?', 'inz');
 		if ($value === 'mgr')
 			$q->andWhere($rootAlias.'.studia_typ = ?', 'mgr');
    	return $q;
  	}

  	public function applySpecjalnoscFilter(Doctrine_Query $q, $value) {
  		$rootAlias = $q->getRootAlias();
		if (array_key_exists($value,self::$_SpecjalnoscLista))
			$q->andWhere($rootAlias.'.specjalnosc = ?', $value);
		
    	return $q;
  	}

	public function getByLoginAndPassword($login, $password) {
	    $q = $this->createQuery('k')
	      ->where('k.login = ?', $login)
	      ->addWhere('k.haslo = ?', md5($password));
	    return $q->execute();				
	}

	public function getByPesel($pesel) {
	    $q = $this->createQuery('k')
	      ->where('k.pesel = ?', $pesel);
	    return $q->execute();				
	}

}