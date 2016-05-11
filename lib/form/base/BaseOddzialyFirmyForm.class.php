<?php

/**
 * OddzialyFirmy form base class.
 *
 * @method OddzialyFirmy getObject() Returns the current form's model object
 *
 * @package    Possible
 * @subpackage form
 * @author     Michal Pomaskow
 */
abstract class BaseOddzialyFirmyForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'firma'      => new sfWidgetFormPropelChoice(array('model' => 'Firmy', 'add_empty' => false)),
      'nazwa'      => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'firma'      => new sfValidatorPropelChoice(array('model' => 'Firmy', 'column' => 'id')),
      'nazwa'      => new sfValidatorString(array('max_length' => 255)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('oddzialy_firmy[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OddzialyFirmy';
  }


}
