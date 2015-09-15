<?php
class PeselUniqueValidator extends sfValidatorBase {
	/**
	 * Configures the current validator.
	 *
	 * Available options:
	 *
	 *  * max_length: The maximum length of the string
	 *  * min_length: The minimum length of the string
	 *  * unique: if the pesel is unique within the database
	 *  * invalid: if the pesel contains forbidden characters 
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
		$this->addMessage('max_length', 'Wartość "%value%" zbyt długa, pole PESEL musi mieć 11 znaków');
		$this->addMessage('min_length', 'Wartość "%value%" zbyt krótka, pole PESEL musi mieć 11 znaków');
		$this->addMessage('invalid', 'Wartość "%value%" zawiera niedozwolone znaki, pole PESEL może zawierać tylko cyfry');
		$this->addMessage('unique', 'Podany nr PESEL jest już zarejestrowany w systemie');
		$this->addMessage('checksum', 'Podany nr PESEL jest niepoprawny');

		$this->addOption('max_length', 11);
		$this->addOption('min_length', 11);
		$this->addOption('unique', true);
		$this->addOption('invalid', true);
		$this->addOption('checksum', true);
		$this->addOption('kandydat_id', 0);
	}

/**
 * Jedenasta cyfra jest cyfrą kontrolną, służącą do wychwytywania przekłamań numeru. 
 * Jest ona generowana na podstawie pierwszych dziesięciu cyfr. 
 * Aby sprawdzić czy dany PESEL jest prawidłowy należy, zakładając, że litery a-k to kolejne cyfry numeru od lewej, obliczyć wyrażenie
 * a + 3*b + 7*c + 9*d + e + 3*f + 7*g + 9*h + i + 3*j + k
 * Jeśli otrzymany wynik nie jest podzielny przez 10, to znaczy, że numer zawiera błąd[2].
 * 
 * Przykład dla numeru PESEL 44051401358:
 *     4*1 + 4*3 + 0*7 + 5*9 + 1*1 + 4*3 + 0*7 + 1*9 + 3*1 + 5*3 + 8 = 109
 * 
 * Liczba 109 nie jest podzielna przez 10, więc numer zawiera błąd.
 */
	private function check($no) {
		if (strlen($no) != 11)
			return false;
		$c = str_split($no);
		$val = $c[0] + $c[1]*3 + $c[2]*7 + $c[3]*9 + $c[4] + $c[5]*3 + $c[6]*7 + $c[7]*9 + $c[8] + $c[9]*3 + $c[10];
		if ($val % 10 == 0)
			return true;
		return false;
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
		if ($this->hasOption('invalid') && !preg_match('/^[0-9]{11}$/', $clean)) {
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
			sfContext::getInstance()->getLogger()->debug('Pesel unique validation');
			$persons = Doctrine :: getTable('Kandydat')->findBySql('pesel = ? AND id <> ? ', array($clean, $customerId));
			if (count($persons) > 0)
				throw new sfValidatorError($this, 'unique', array (
					'value' => $value,
					'invalid' => $this->getOption('unique')
				));
		}
		//sprawdzamy czy poprawny
		if ($this->hasOption('checksum')) {
			if ($this->check($clean) === false)
				throw new sfValidatorError($this, 'checksum', array (
					'value' => $value,
					'invalid' => $this->getOption('checksum')
				));
		}

		return $clean;
	}
}
?>