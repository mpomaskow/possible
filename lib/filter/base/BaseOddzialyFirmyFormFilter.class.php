<?php

/**
 * OddzialyFirmy filter form base class.
 *
 * @package    Possible
 * @subpackage filter
 * @author     Michal Pomaskow
 */
abstract class BaseOddzialyFirmyFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'firma'      => new sfWidgetFormPropelChoice(array('model' => 'Firmy', 'add_empty' => true)),
      'nazwa'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'firma'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Firmy', 'column' => 'id')),
      'nazwa'      => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('oddzialy_firmy_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OddzialyFirmy';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'firma'      => 'ForeignKey',
      'nazwa'      => 'Text',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
