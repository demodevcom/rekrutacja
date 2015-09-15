<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Kandydat filter form base class.
 *
 * @package    filters
 * @subpackage Kandydat *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseKandydatFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'imiona'                          => new sfWidgetFormFilterInput(),
      'nazwisko'                        => new sfWidgetFormFilterInput(),
      'plec'                            => new sfWidgetFormFilterInput(),
      'kierunek'                        => new sfWidgetFormFilterInput(),
      'stacjonarne'                     => new sfWidgetFormFilterInput(),
      'studia_typ'                      => new sfWidgetFormFilterInput(),
      'urodzenie_miejsce'               => new sfWidgetFormFilterInput(),
      'matka_imie'                      => new sfWidgetFormFilterInput(),
      'ojciec_imie'                     => new sfWidgetFormFilterInput(),
      'narodowosc'                      => new sfWidgetFormFilterInput(),
      'obywatelstwo'                    => new sfWidgetFormFilterInput(),
      'pesel'                           => new sfWidgetFormFilterInput(),
      'dowod_osobisty_nr'               => new sfWidgetFormFilterInput(),
      'zameldowanie_dom_nr'             => new sfWidgetFormFilterInput(),
      'zameldowanie_kod'                => new sfWidgetFormFilterInput(),
      'stosunek_do_sluzby_wojskowej'    => new sfWidgetFormFilterInput(),
      'niepelnosprawny'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'login'                           => new sfWidgetFormFilterInput(),
      'haslo'                           => new sfWidgetFormFilterInput(),
      'created_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'zameldowanie_miasto'             => new sfWidgetFormFilterInput(),
      'zameldowanie_wojewodztwo'        => new sfWidgetFormFilterInput(),
      'email'                           => new sfWidgetFormFilterInput(),
      'telefon_nr'                      => new sfWidgetFormFilterInput(),
      'nip'                             => new sfWidgetFormFilterInput(),
      'zameldowanie_ulica'              => new sfWidgetFormFilterInput(),
      'specjalnosc'                     => new sfWidgetFormFilterInput(),
      'jezyk'                           => new sfWidgetFormFilterInput(),
      'jezyk2'                          => new sfWidgetFormFilterInput(),
      'zameldowanie_mieszkanie_nr'      => new sfWidgetFormFilterInput(),
      'korespondencja_ulica'            => new sfWidgetFormFilterInput(),
      'korespondencja_dom_nr'           => new sfWidgetFormFilterInput(),
      'korespondencja_mieszkanie_nr'    => new sfWidgetFormFilterInput(),
      'korespondencja_kod'              => new sfWidgetFormFilterInput(),
      'ksiazeczka_wojskowa_nr'          => new sfWidgetFormFilterInput(),
      'szkola_srednia_rok_ukonczenia'   => new sfWidgetFormFilterInput(),
      'szkola_srednia'                  => new sfWidgetFormFilterInput(),
      'inne_studia'                     => new sfWidgetFormFilterInput(),
      'plywanie_grupa'                  => new sfWidgetFormFilterInput(),
      'skad_wiem'                       => new sfWidgetFormFilterInput(),
      'skonczone_studia'                => new sfWidgetFormFilterInput(),
      'skonczone_studia_rok_ukonczenia' => new sfWidgetFormFilterInput(),
      'zdjecie'                         => new sfWidgetFormFilterInput(),
      'korespondencja_miasto'           => new sfWidgetFormFilterInput(),
      'korespondencja_wojewodztwo'      => new sfWidgetFormFilterInput(),
      'mobile_nr'                       => new sfWidgetFormFilterInput(),
      'wku_miasto'                      => new sfWidgetFormFilterInput(),
      'szkola_komentarz'                => new sfWidgetFormFilterInput(),
      'przelew_zaksiegowany'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'dokumenty_dotarly'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'pytanie_haslo'                   => new sfWidgetFormFilterInput(),
      'odpowiedz_haslo'                 => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'imiona'                          => new sfValidatorPass(array('required' => false)),
      'nazwisko'                        => new sfValidatorPass(array('required' => false)),
      'plec'                            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'kierunek'                        => new sfValidatorPass(array('required' => false)),
      'stacjonarne'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'studia_typ'                      => new sfValidatorPass(array('required' => false)),
      'urodzenie_miejsce'               => new sfValidatorPass(array('required' => false)),
      'matka_imie'                      => new sfValidatorPass(array('required' => false)),
      'ojciec_imie'                     => new sfValidatorPass(array('required' => false)),
      'narodowosc'                      => new sfValidatorPass(array('required' => false)),
      'obywatelstwo'                    => new sfValidatorPass(array('required' => false)),
      'pesel'                           => new sfValidatorPass(array('required' => false)),
      'dowod_osobisty_nr'               => new sfValidatorPass(array('required' => false)),
      'zameldowanie_dom_nr'             => new sfValidatorPass(array('required' => false)),
      'zameldowanie_kod'                => new sfValidatorPass(array('required' => false)),
      'stosunek_do_sluzby_wojskowej'    => new sfValidatorPass(array('required' => false)),
      'niepelnosprawny'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'login'                           => new sfValidatorPass(array('required' => false)),
      'haslo'                           => new sfValidatorPass(array('required' => false)),
      'created_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'zameldowanie_miasto'             => new sfValidatorPass(array('required' => false)),
      'zameldowanie_wojewodztwo'        => new sfValidatorPass(array('required' => false)),
      'email'                           => new sfValidatorPass(array('required' => false)),
      'telefon_nr'                      => new sfValidatorPass(array('required' => false)),
      'nip'                             => new sfValidatorPass(array('required' => false)),
      'zameldowanie_ulica'              => new sfValidatorPass(array('required' => false)),
      'specjalnosc'                     => new sfValidatorPass(array('required' => false)),
      'jezyk'                           => new sfValidatorPass(array('required' => false)),
      'jezyk2'                          => new sfValidatorPass(array('required' => false)),
      'zameldowanie_mieszkanie_nr'      => new sfValidatorPass(array('required' => false)),
      'korespondencja_ulica'            => new sfValidatorPass(array('required' => false)),
      'korespondencja_dom_nr'           => new sfValidatorPass(array('required' => false)),
      'korespondencja_mieszkanie_nr'    => new sfValidatorPass(array('required' => false)),
      'korespondencja_kod'              => new sfValidatorPass(array('required' => false)),
      'ksiazeczka_wojskowa_nr'          => new sfValidatorPass(array('required' => false)),
      'szkola_srednia_rok_ukonczenia'   => new sfValidatorPass(array('required' => false)),
      'szkola_srednia'                  => new sfValidatorPass(array('required' => false)),
      'inne_studia'                     => new sfValidatorPass(array('required' => false)),
      'plywanie_grupa'                  => new sfValidatorPass(array('required' => false)),
      'skad_wiem'                       => new sfValidatorPass(array('required' => false)),
      'skonczone_studia'                => new sfValidatorPass(array('required' => false)),
      'skonczone_studia_rok_ukonczenia' => new sfValidatorPass(array('required' => false)),
      'zdjecie'                         => new sfValidatorPass(array('required' => false)),
      'korespondencja_miasto'           => new sfValidatorPass(array('required' => false)),
      'korespondencja_wojewodztwo'      => new sfValidatorPass(array('required' => false)),
      'mobile_nr'                       => new sfValidatorPass(array('required' => false)),
      'wku_miasto'                      => new sfValidatorPass(array('required' => false)),
      'szkola_komentarz'                => new sfValidatorPass(array('required' => false)),
      'przelew_zaksiegowany'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'dokumenty_dotarly'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'pytanie_haslo'                   => new sfValidatorPass(array('required' => false)),
      'odpowiedz_haslo'                 => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kandydat_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Kandydat';
  }

  public function getFields()
  {
    return array(
      'id'                              => 'Number',
      'imiona'                          => 'Text',
      'nazwisko'                        => 'Text',
      'plec'                            => 'Number',
      'kierunek'                        => 'Text',
      'stacjonarne'                     => 'Number',
      'studia_typ'                      => 'Text',
      'urodzenie_miejsce'               => 'Text',
      'matka_imie'                      => 'Text',
      'ojciec_imie'                     => 'Text',
      'narodowosc'                      => 'Text',
      'obywatelstwo'                    => 'Text',
      'pesel'                           => 'Text',
      'dowod_osobisty_nr'               => 'Text',
      'zameldowanie_dom_nr'             => 'Text',
      'zameldowanie_kod'                => 'Text',
      'stosunek_do_sluzby_wojskowej'    => 'Text',
      'niepelnosprawny'                 => 'Boolean',
      'login'                           => 'Text',
      'haslo'                           => 'Text',
      'created_at'                      => 'Date',
      'updated_at'                      => 'Date',
      'zameldowanie_miasto'             => 'Text',
      'zameldowanie_wojewodztwo'        => 'Text',
      'email'                           => 'Text',
      'telefon_nr'                      => 'Text',
      'nip'                             => 'Text',
      'zameldowanie_ulica'              => 'Text',
      'specjalnosc'                     => 'Text',
      'jezyk'                           => 'Text',
      'jezyk2'                          => 'Text',
      'zameldowanie_mieszkanie_nr'      => 'Text',
      'korespondencja_ulica'            => 'Text',
      'korespondencja_dom_nr'           => 'Text',
      'korespondencja_mieszkanie_nr'    => 'Text',
      'korespondencja_kod'              => 'Text',
      'ksiazeczka_wojskowa_nr'          => 'Text',
      'szkola_srednia_rok_ukonczenia'   => 'Text',
      'szkola_srednia'                  => 'Text',
      'inne_studia'                     => 'Text',
      'plywanie_grupa'                  => 'Text',
      'skad_wiem'                       => 'Text',
      'skonczone_studia'                => 'Text',
      'skonczone_studia_rok_ukonczenia' => 'Text',
      'zdjecie'                         => 'Text',
      'korespondencja_miasto'           => 'Text',
      'korespondencja_wojewodztwo'      => 'Text',
      'mobile_nr'                       => 'Text',
      'wku_miasto'                      => 'Text',
      'szkola_komentarz'                => 'Text',
      'przelew_zaksiegowany'            => 'Boolean',
      'dokumenty_dotarly'               => 'Boolean',
      'pytanie_haslo'                   => 'Text',
      'odpowiedz_haslo'                 => 'Text',
    );
  }
}