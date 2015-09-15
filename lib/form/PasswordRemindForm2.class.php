<?php

class PasswordRemindForm2 extends sfForm {
		
	public function configure() {
		sfContext :: getInstance()->getLogger()->debug('Executing remind2 configure...');
		//formularze
		$this->setWidgets(array (
			'odpowiedz' => new sfWidgetFormInput()
		));

		$this->widgetSchema->setNameFormat('remind2[%s]');
		
		//walidatory
		$this->setValidators(array (
			'odpowiedz'		=> new sfValidatorString(array('min_length' => 1, 'max_length' => 25, 'required' => true),  array('min_length' => 'Pole zbyt krótkie', 'max_length' => 'Pole zbyt długie', 'required' => 'Pole jest wymagane'))
		));

		$this->widgetSchema->setLabels(array(
			'odpowiedz'		=> 'Odpowiedź'
		));    

	}	
}