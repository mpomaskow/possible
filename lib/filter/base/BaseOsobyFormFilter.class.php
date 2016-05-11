<?php

/**
 * Osoby filter form base class.
 *
 * @package    Possible
 * @subpackage filter
 * @author     Michal Pomaskow
 */
abstract class BaseOsobyFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nazwisko'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'imie'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'miejscowosc'    => new sfWidgetFormPropelChoice(array('model' => 'Miejscowosci', 'add_empty' => true)),
      'data_urodzenia' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'firma'          => new sfWidgetFormPropelChoice(array('model' => 'Firmy', 'add_empty' => true)),
      'oddzial_firmy'  => new sfWidgetFormPropelChoice(array('model' => 'OddzialyFirmy', 'add_empty' => true)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'nazwisko'       => new sfValidatorPass(array('required' => false)),
      'imie'           => new sfValidatorPass(array('required' => false)),
      'miejscowosc'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Miejscowosci', 'column' => 'id')),
      'data_urodzenia' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'firma'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Firmy', 'column' => 'id')),
      'oddzial_firmy'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OddzialyFirmy', 'column' => 'id')),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('osoby_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Osoby';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'nazwisko'       => 'Text',
      'imie'           => 'Text',
      'miejscowosc'    => 'ForeignKey',
      'data_urodzenia' => 'Date',
      'firma'          => 'ForeignKey',
      'oddzial_firmy'  => 'ForeignKey',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
