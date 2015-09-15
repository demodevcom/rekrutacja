<?php
class LoginForm extends sfForm {
	
	public function configure() {
		//formularze
		$this->setWidgets(array (
			'login' => new sfWidgetFormInput(), 
			'haslo' => new sfWidgetFormInputPassword(), 			
		));

		$this->widgetSchema->setNameFormat('login[%s]');
		
		//walidatory
		$this->setValidators(array (
			'login'		=> new sfValidatorString(array('max_length' => 25, 'required' => true)),
			'haslo'	=> new sfValidatorString(array('max_length' => 25, 'required' => true)),
			//'email'		=> new sfValidatorEmail(array ('required' => false)), 
		));

		$this->widgetSchema->setLabels(array(
			'login'		=> 'Nazwa użytkownika',
			'haslo'	=> 'Hasło'
		));    

	}
}
?>