<?php
class NipValidator extends sfValidatorBase {
	/**
	 * Configures the current validator.
	 *
	 * Available options:
	 *
	 *  * max_length: The maximum length of the string
	 *  * min_length: The minimum length of the string
	 *  * unique: if the nip is unique within the database
	 *  * invalid: if the nip contains forbidden characters 
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
		$this->addMessage('max_length', 'Wartość "%value%" zbyt długa, pole NIP  musi mieć 10 znaków');
		$this->addMessage('min_length', 'Wartość "%value%" zbyt krótka, pole NIP  musi mieć 10 znaków');
		$this->addMessage('invalid', 'Wartość "%value%" zawiera niedozwolone znaki, pole NIP może zawierać tylko cyfry');
		$this->addMessage('unique', 'Podany nr NIP jest już zarejestrowany w systemie');
		$this->addMessage('checksum', 'Podany nr NIP jest niepoprawny');

		$this->addOption('max_length', 10);
		$this->addOption('min_length', 10);
		$this->addOption('unique', true);
		$this->addOption('invalid', true);
		$this->addOption('checksum', true);
		$this->addOption('kandydat_id', 0);
	}

/**
 	Trzy pierwsze cyfry każdego NIP-u oznaczają kod urzędu skarbowego, który nadał dany numer. W kodzie tym występują wyłącznie cyfry od 1 do 9 - teoretycznie cyfra 0 nie powinna być w nim generowana. W wyjątkowych przypadkach kod urzędu skarbowego może zawierać jednak cyfrę 0 na drugiej pozycji, gdyż w roku 2004 dla kilkudziesięciu urzędów skarbowych uczyniono wyjątek od dotychczasowej reguły, i tak np. kod 106 oznacza Małopolski Urząd Skarbowy w Krakowie, więc nadany przez niego NIP 106-00-00-062 jest prawidłowy. Zwyczajowo NIP zapisuje się, oddzielając grupy cyfr łącznikiem. Dla osób fizycznych numer dzielony jest na grupy 123-456-78-90, a dla osób prawnych, bądź ułomnych osób prawnych, na grupy 123-45-67-890.

	Dziesiąta cyfra NIP-u jest cyfrą kontrolną, obliczaną według specjalnego algorytmu:

    1. Pomnożyć każdą z pierwszych dziewięciu cyfr odpowiednio przez wagi: 6, 5, 7, 2, 3, 4, 5, 6, 7.
    2. Zsumować wyniki mnożenia.
    3. Obliczyć resztę z dzielenia przez 11 (operacja modulo 11).

	NIP jest tak generowany, aby nigdy w wyniku tego dzielenia nie wyszła liczba 10.
 */
	private function check($str) {
		if (strlen($str) != 10)	{
			return false;
		}
	 
		$arrSteps = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
		$intSum=0;
		for ($i = 0; $i < 9; $i++)	{
			$intSum += $arrSteps[$i] * $str[$i];
		}
		$int = $intSum % 11;
	 
		$intControlNr=($int == 10)?0:$int;
		if ($intControlNr == $str[9]) {
			return true;
		}
		return false;
				
	}

	/**
	 * @see sfValidatorBase
	 */
	protected function doClean($value) {
		$clean = (string) preg_replace('/[\s-]/', '', $value);
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
		if ($this->hasOption('invalid') && !preg_match('/^[0-9]{10}$/', $clean)) {
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
			sfContext::getInstance()->getLogger()->debug('Nip unique validation');
			$persons = Doctrine :: getTable('Kandydat')->findBySql('nip = ? AND id <> ? ', array($clean, $customerId));
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