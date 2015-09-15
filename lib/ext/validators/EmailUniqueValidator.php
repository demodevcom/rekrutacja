<?php
class EmailUniqueValidator extends sfValidatorBase {
	//$this->setOption('pattern', '/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i');
	protected function configure($options = array (), $messages = array ()) {
		$this->addMessage('max_length', 'Wartość przekracza maksymalną dopuszczalną wartość dla tego pola');
		$this->addMessage('min_length', 'Wartość jest zbyt krótka dla pola email');
		$this->addMessage('invalid', 'Wartość zawiera niedozwolone znaki');
		$this->addMessage('unique', 'Podany email jest już zarejestrowany w systemie');

		$this->addOption('max_length', 255);
		$this->addOption('min_length', 3);
		$this->addOption('unique', true);
		$this->addOption('invalid', true);
		$this->addOption('kandydat_id', 0);
	}

	/**
	 * @see sfValidatorBase
	 */
	protected function doClean($value) {
		$clean = trim((string) $value);
		
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
		if ($this->hasOption('invalid') && !preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i', $clean)) {
			throw new sfValidatorError($this, 'invalid', array (
				'value' => $value,
				'invalid' => $this->getOption('invalid')
			));
		}
		//sprawdzamy czy nie istnieje w bazie danych
		if ($this->hasOption('unique')) {
			$customerId = 0;
			if ($this->hasOption('kandydat_id'))
				$customerId = $this->getOption('kandydat_id');
			sfContext :: getInstance()->getLogger()->debug('Email unique validation');
			$persons = Doctrine :: getTable('Kandydat')->findBySql('email = ? AND id <> ? ', array (
				$clean,
				$customerId
			));
			if (count($persons) > 0)
				throw new sfValidatorError($this, 'unique', array (
					'value' => $value,
					'invalid' => $this->getOption('unique')
				));
		}
		return $clean;
	}
		
}

?>