<?php
/**
 * Walidator: przynajmniej jeden z dwojga. Przynajmniej jedno z dwoch pol musi być ustawione.
 * @author Pawel Skrzynski
 */
class ValidatorSchemaOneNotNull extends sfValidatorSchema {
	public function __construct($leftField, $rightField, $options = array (), $messages = array ()) {
		$this->addOption('left_field', $leftField);
		$this->addOption('right_field', $rightField);

		$this->addOption('throw_global_error', false);

		parent :: __construct(null, $options, $messages);
	}

	/**
	 * @see sfValidatorBase
	 */
	protected function doClean($values) {
		if (is_null($values)) {
			$values = array ();
		}

		if (!is_array($values)) {
			throw new InvalidArgumentException('You must pass an array parameter to the clean() method');
		}

		$leftValue = isset ($values[$this->getOption('left_field')]) ? $values[$this->getOption('left_field')] : null;
		$rightValue = isset ($values[$this->getOption('right_field')]) ? $values[$this->getOption('right_field')] : null;

		if (strlen($leftValue) > 0 || strlen($rightValue) > 0)
			$valid = true;
		else
			$valid = false;

		if (!$valid) {
			$error = new sfValidatorError($this, 'invalid', array (
				'left_field' => $leftValue,
				'right_field' => $rightValue,
				'operator' => $this->getOption('operator'),
				
			));
			if ($this->getOption('throw_global_error')) {
				throw $error;
			}

			throw new sfValidatorErrorSchema($this, array (
				$this->getOption('left_field') => $error
			));
		}

		return $values;
	}

}
?>