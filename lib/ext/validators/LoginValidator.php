<?php

class LoginValidator extends sfValidatorBase {
	/**
	 * Configures the current validator.
	 *
	 * Available options:
	 *
	 *  * max_length: The maximum length of the string
	 *  * min_length: The minimum length of the string
	 *  * unique: if the prefix is unique within the database
	 *  * invalid: if the prefix contains forbidden characters 
	 *
	 * Available error codes:
	 *
	 *  * max_length
	 *  * min_length
	 *
	 * @param array $options   An array of options
	 * @param array $messages  An array of error messages
	 *
	 * @see sfValidatorBase
	 */
	protected function configure($options = array (), $messages = array ()) {
		$this->addMessage('max_length', 'Wartość "%value%" zbyt długa, pole login musi mieć co najwyżej 25 znakow');
		$this->addMessage('min_length', 'Wartość "%value%" zbyt krótka, pole login musi conajmniej 5 znaków');
		$this->addMessage('invalid', 'Pole zawiera niedozwolone znaki, pole może zawierać tylko litery i cyfry');
		$this->addMessage('unique', 'Podany login jest już zajęty');

		$this->addOption('max_length', 25);
		$this->addOption('min_length', 5);
		$this->addOption('unique', true);
		$this->addOption('invalid', true);
		$this->addOption('kandydat_id', 0);
	}

	/**
	 * @see sfValidatorBase
	 */
	protected function doClean($value) {
		$clean = (string) $value;
		
		$length = function_exists('mb_strlen') ? mb_strlen($clean, $this->getCharset()) : strlen($clean);

		if ($this->hasOption('max_length') && $length > $this->getOption('max_length')) {
			throw new sfValidatorError($this, 'max_length', array (
				'value' => $value,
				'max_length' => $this->getOption('max_length')
			));
		}

		if ($this->hasOption('min_length') && $length < $this->getOption('min_length')) {
			throw new sfValidatorError($this, 'min_length', array (
				'value' => $value,
				'min_length' => $this->getOption('min_length')
			));
		}
		//czy poprawny format
		if ($this->hasOption('invalid') && !preg_match('/^[0-9a-zA-Z]+$/', $clean)) {
			throw new sfValidatorError($this, 'invalid', array (
				'value' => $value,
				'invalid' => $this->getOption('invalid')
			));
		}
		//sprawdzamy czy nie istnieje w bazie danych
		if ($this->hasOption('unique')) {
			$accountId = 0;
			if ($this->hasOption('kandydat_id'))
				$accountId = $this->getOption('kandydat_id');
			sfContext::getInstance()->getLogger()->debug('Login unique validation');
			$accounts = Doctrine :: getTable('Kandydat')->findBySql('lower(login) = ? AND id <> ?', array(strtolower($clean), $accountId));
			if (count($accounts) > 0)
				throw new sfValidatorError($this, 'unique', array (
					'value' => $value,
					'invalid' => $this->getOption('unique')
				));
		}

		return $clean;
	}
}
?>