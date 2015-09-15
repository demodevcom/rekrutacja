<?php

/**
 * Kandydat form base class.
 *
 * @package    form
 * @subpackage kandydat
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseKandydatForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                              => new sfWidgetFormInputHidden(),
      'imiona'                          => new sfWidgetFormInput(),
      'nazwisko'                        => new sfWidgetFormInput(),
      'plec'                            => new sfWidgetFormInput(),
      'kierunek'                        => new sfWidgetFormInput(),
      'stacjonarne'                     => new sfWidgetFormInput(),
      'studia_typ'                      => new sfWidgetFormInput(),
      'urodzenie_miejsce'               => new sfWidgetFormInput(),
      'matka_imie'                      => new sfWidgetFormInput(),
      'ojciec_imie'                     => new sfWidgetFormInput(),
      'narodowosc'                      => new sfWidgetFormInput(),
      'obywatelstwo'                    => new sfWidgetFormInput(),
      'pesel'                           => new sfWidgetFormInput(),
      'dowod_osobisty_nr'               => new sfWidgetFormInput(),
      'zameldowanie_dom_nr'             => new sfWidgetFormInput(),
      'zameldowanie_kod'                => new sfWidgetFormInput(),
      'stosunek_do_sluzby_wojskowej'    => new sfWidgetFormInput(),
      'niepelnosprawny'                 => new sfWidgetFormInputCheckbox(),
      'login'                           => new sfWidgetFormInput(),
      'haslo'                           => new sfWidgetFormInput(),
      'created_at'                      => new sfWidgetFormDateTime(),
      'updated_at'                      => new sfWidgetFormDateTime(),
      'zameldowanie_miasto'             => new sfWidgetFormInput(),
      'zameldowanie_wojewodztwo'        => new sfWidgetFormInput(),
      'email'                           => new sfWidgetFormInput(),
      'telefon_nr'                      => new sfWidgetFormInput(),
      'nip'                             => new sfWidgetFormInput(),
      'zameldowanie_ulica'              => new sfWidgetFormInput(),
      'specjalnosc'                     => new sfWidgetFormInput(),
      'jezyk'                           => new sfWidgetFormInput(),
      'jezyk2'                          => new sfWidgetFormInput(),
      'zameldowanie_mieszkanie_nr'      => new sfWidgetFormInput(),
      'korespondencja_ulica'            => new sfWidgetFormInput(),
      'korespondencja_dom_nr'           => new sfWidgetFormInput(),
      'korespondencja_mieszkanie_nr'    => new sfWidgetFormInput(),
      'korespondencja_kod'              => new sfWidgetFormInput(),
      'ksiazeczka_wojskowa_nr'          => new sfWidgetFormInput(),
      'szkola_srednia_rok_ukonczenia'   => new sfWidgetFormInput(),
      'szkola_srednia'                  => new sfWidgetFormInput(),
      'inne_studia'                     => new sfWidgetFormInput(),
      'plywanie_grupa'                  => new sfWidgetFormInput(),
      'skad_wiem'                       => new sfWidgetFormInput(),
      'skonczone_studia'                => new sfWidgetFormInput(),
      'skonczone_studia_rok_ukonczenia' => new sfWidgetFormInput(),
      'zdjecie'                         => new sfWidgetFormInput(),
      'korespondencja_miasto'           => new sfWidgetFormInput(),
      'korespondencja_wojewodztwo'      => new sfWidgetFormInput(),
      'mobile_nr'                       => new sfWidgetFormInput(),
      'wku_miasto'                      => new sfWidgetFormInput(),
      'szkola_komentarz'                => new sfWidgetFormInput(),
      'przelew_zaksiegowany'            => new sfWidgetFormInputCheckbox(),
      'dokumenty_dotarly'               => new sfWidgetFormInputCheckbox(),
      'pytanie_haslo'                   => new sfWidgetFormInput(),
      'odpowiedz_haslo'                 => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                              => new sfValidatorDoctrineChoice(array('model' => 'Kandydat', 'column' => 'id', 'required' => false)),
      'imiona'                          => new sfValidatorString(array('max_length' => 80)),
      'nazwisko'                        => new sfValidatorString(array('max_length' => 80)),
      'plec'                            => new sfValidatorInteger(),
      'kierunek'                        => new sfValidatorString(array('max_length' => 30)),
      'stacjonarne'                     => new sfValidatorInteger(array('required' => false)),
      'studia_typ'                      => new sfValidatorString(array('max_length' => 15)),
      'urodzenie_miejsce'               => new sfValidatorString(array('max_length' => 40)),
      'matka_imie'                      => new sfValidatorString(array('max_length' => 40)),
      'ojciec_imie'                     => new sfValidatorString(array('max_length' => 40)),
      'narodowosc'                      => new sfValidatorString(array('max_length' => 40)),
      'obywatelstwo'                    => new sfValidatorString(array('max_length' => 40)),
      'pesel'                           => new sfValidatorString(array('max_length' => 11, 'required' => false)),
      'dowod_osobisty_nr'               => new sfValidatorString(array('max_length' => 10)),
      'zameldowanie_dom_nr'             => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'zameldowanie_kod'                => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'stosunek_do_sluzby_wojskowej'    => new sfValidatorString(array('max_length' => 20)),
      'niepelnosprawny'                 => new sfValidatorBoolean(array('required' => false)),
      'login'                           => new sfValidatorString(array('max_length' => 20)),
      'haslo'                           => new sfValidatorString(array('max_length' => 32)),
      'created_at'                      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                      => new sfValidatorDateTime(array('required' => false)),
      'zameldowanie_miasto'             => new sfValidatorString(array('max_length' => 30)),
      'zameldowanie_wojewodztwo'        => new sfValidatorString(array('max_length' => 30)),
      'email'                           => new sfValidatorString(array('max_length' => 255)),
      'telefon_nr'                      => new sfValidatorString(array('max_length' => 12)),
      'nip'                             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'zameldowanie_ulica'              => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'specjalnosc'                     => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'jezyk'                           => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'jezyk2'                          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'zameldowanie_mieszkanie_nr'      => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'korespondencja_ulica'            => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'korespondencja_dom_nr'           => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'korespondencja_mieszkanie_nr'    => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'korespondencja_kod'              => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'ksiazeczka_wojskowa_nr'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'szkola_srednia_rok_ukonczenia'   => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'szkola_srednia'                  => new sfValidatorString(array('max_length' => 255)),
      'inne_studia'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'plywanie_grupa'                  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'skad_wiem'                       => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'skonczone_studia'                => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'skonczone_studia_rok_ukonczenia' => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'zdjecie'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'korespondencja_miasto'           => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'korespondencja_wojewodztwo'      => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'mobile_nr'                       => new sfValidatorString(array('max_length' => 12, 'required' => false)),
      'wku_miasto'                      => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'szkola_komentarz'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'przelew_zaksiegowany'            => new sfValidatorBoolean(array('required' => false)),
      'dokumenty_dotarly'               => new sfValidatorBoolean(array('required' => false)),
      'pytanie_haslo'                   => new sfValidatorString(array('max_length' => 80)),
      'odpowiedz_haslo'                 => new sfValidatorString(array('max_length' => 25)),
    ));

    $this->widgetSchema->setNameFormat('kandydat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Kandydat';
  }

}
