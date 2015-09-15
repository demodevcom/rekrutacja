<?php


/**
 * Kandydat filter form.
 *
 * @package    filters
 * @subpackage Kandydat *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class KandydatFormFilter extends BaseKandydatFormFilter {
	
	public function configure(){
  		$this->widgetSchema['kierunek'] = new sfWidgetFormSelect(
  			array('choices' => array(
  				'all'			  				=> '',
  				'informatyka' 	=> 'Informatyka',
  				'turystyka i rekreacja' 	=> 'Turystyka i rekreacja',
  				'politologia' 	=> 'Politologia'
  			)));

  		$this->widgetSchema['specjalnosc'] = new sfWidgetFormSelect(
  			array('choices' => array())
  			);

  		$this->widgetSchema['stacjonarne'] = new sfWidgetFormSelect(
  			array('choices' => array(
  				'' => '',
  				'0' 	=> 'Stacjonarne',
  				'1' 	=> 'Niestacjonarne'
  			)));
  		$this->widgetSchema['stacjonarne']->setLabel('Tryb');

  		$this->widgetSchema['studia_typ'] = new sfWidgetFormSelect(
  			array('choices' => array(
  				'' => '',
  				'inz' 	=> 'inżynierskie/licencjackie',
  				'mgr' 	=> 'magisterskie'
  			)));
  		$this->widgetSchema['studia_typ']->setLabel('Typ studiów');

  		
  		$this->validatorSchema['kierunek'] = new sfValidatorPass(array('required' => false));
  		$this->validatorSchema['stacjonarne'] = new sfValidatorPass(array('required' => false));
  		$this->validatorSchema['studia_typ'] = new sfValidatorPass(array('required' => false));
  		
  	}
  	
  	public function addKierunekColumnQuery($query, $field, $value) {
  		return Doctrine::getTable('Kandydat')->applyKierunekFilter($query, $value);
	}
	
  	public function addSpecjalnoscColumnQuery($query, $field, $value) {
  		return Doctrine::getTable('Kandydat')->applySpecjalnoscFilter($query, $value);
	}
	
  	public function addStacjonarneColumnQuery($query, $field, $value) {
  		return Doctrine::getTable('Kandydat')->applyStacjonarneFilter($query, $value);
	}

  	public function addStudiaTypColumnQuery($query, $field, $value) {
  		return Doctrine::getTable('Kandydat')->applyStudiaTypFilter($query, $value);
	}
	
}