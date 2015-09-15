<?php

class PasswordRemindForm1 extends sfForm {
	public function configure() {
		sfContext :: getInstance()->getLogger()->debug('Executing remind1 configure...');
		//formularze
		$this->setWidgets(array (
			'pesel' => new sfWidgetFormInput()
		));

		$this->widgetSchema->setNameFormat('remind1[%s]');
		
		//walidatory
		$this->setValidators(array (
			'pesel'		=> new sfValidatorString(array('max_length' => 11, 'min_length' => 11, 'required' => true), array('max_length' => 'Pole musi mieć 11 znaków', 'min_length' => 'Pole musi mieć 11 znaków', 'required' => 'Polejest wymagane'))
		));

		$this->widgetSchema->setLabels(array(
			'pesel'		=> 'PESEL'
		)); 

	}	
}