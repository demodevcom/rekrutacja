<?php

/**
 * Kandydat form.
 *
 * @package    form
 * @subpackage Kandydat
 * @version    SVN: $formId: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class KandydatImageForm extends KandydatForm {
	
public function __construct(Kandydat $kandydat = null, $path = '') {
		$this->path = $path;
		//echo 'sciezka: '.$this->path;
		$this->kandydat = $kandydat;
		parent:: __construct($kandydat);
	}
 
	protected function removeFields() {
		unset(
			$this['created_at'],
			$this['updated_at'],
			$this['id'],
			$this['imiona'],
		    $this['nazwisko'],
		    $this['plec'],
		      $this['urodzenie_miejsce'],
		      $this['narodowosc'],
		      $this['obywatelstwo'],
	          $this['matka_imie'],
		      $this['ojciec_imie'],
		      $this['pesel'],
		      $this['nip'],
		      
		      $this['zameldowanie_ulica'],
		      $this['zameldowanie_dom_nr'],
	      	  $this['zameldowanie_mieszkanie_nr'],
	          $this['zameldowanie_kod'],
	    	  
	          $this['korespondencja'],    	
		      $this['korespondencja_ulica'],
		      $this['korespondencja_dom_nr'],
		      $this['korespondencja_mieszkanie_nr'],
		      $this['korespondencja_kod'],
	          
		      $this['stosunek_do_sluzby_wojskowej'],
	          $this['ksiazeczka_wojskowa_nr'],
	          $this['niepelnosprawny'],		
			  
	    	  $this['szkola_srednia_rok_ukonczenia'],
	          $this['skonczone_studia'],
		      $this['skonczone_studia_rok_ukonczenia'],
	          $this['inne_studia'],		      
		      
	          $this['kierunek'],
		      $this['specjalnosc'],		      
		      $this['stacjonarne'],
		      $this['studia_typ'],
	    	  $this['jezyk'],
		      $this['jezyk2'],
	    	  $this['plywanie_grupa'],
		          	
		      $this['login'],
		      $this['haslo'],
		      $this['haslo2'],
		      
		      $this['skad_wiem'],
		      //nowe pola
		      $this['zameldowanie_miasto'],
		      $this['korespondencja_miasto'],
		      $this['zameldowanie_wojewodztwo'],
		      $this['korespondencja_wojewodztwo'],
		      $this['email'],
		      $this['telefon_nr'],
		      $this['mobile_nr'],
		      $this['wku_miasto'],
		      $this['dowod_osobisty_nr'],
		      $this['szkola_srednia'],

		      $this['szkola_komentarz'],
		      $this['dokumenty_dotarly'],
		      $this['przelew_otrzymany'],
		      $this['pytanie_haslo'],
		      $this['odpowiedz_haslo']
		      
		);
	}
}