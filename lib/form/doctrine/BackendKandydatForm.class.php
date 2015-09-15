<?php

/**
 * Kandydat form.
 *
 * @package    form
 * @subpackage Kandydat
 * @version    SVN: $formId: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class BackendKandydatForm extends KandydatForm {
	
	public function configure() {
		parent::configure();

	  	$this->widgetSchema['szkola_komentarz'] = new sfWidgetFormTextarea(array(
	  		));
	  	
	  	$this->widgetSchema['szkola_komentarz']->setLabel('Informacja Komisji Rekrutacyjnej dla kandydata');
		
	}
 
	protected function removeFields() {
		unset(
			$this['created_at'],
			$this['updated_at'],
			$this['id'],
			$this['haslo'],
			$this['haslo2'],
			$this['zdjecie']
		);
	}
}