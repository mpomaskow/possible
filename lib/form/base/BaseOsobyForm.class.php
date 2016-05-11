<?php

/**
 * Osoby form base class.
 *
 * @method Osoby getObject() Returns the current form's model object
 *
 * @package    Possible
 * @subpackage form
 * @author     Michal Pomaskow
 */
abstract class BaseOsobyForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'nazwisko'       => new sfWidgetFormInputText(),
      'imie'           => new sfWidgetFormInputText(),
      'miejscowosc'    => new sfWidgetFormPropelChoice(array('model' => 'Miejscowosci', 'add_empty' => false)),
      'data_urodzenia' => new sfWidgetFormDate(),
      'firma'          => new sfWidgetFormPropelChoice(array('model' => 'Firmy', 'add_empty' => false)),
      'oddzial_firmy'  => new sfWidgetFormPropelChoice(array('model' => 'OddzialyFirmy', 'add_empty' => false)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'nazwisko'       => new sfValidatorString(array('max_length' => 255)),
      'imie'           => new sfValidatorString(array('max_length' => 255)),
      'miejscowosc'    => new sfValidatorPropelChoice(array('model' => 'Miejscowosci', 'column' => 'id')),
      'data_urodzenia' => new sfValidatorDate(),
      'firma'          => new sfValidatorPropelChoice(array('model' => 'Firmy', 'column' => 'id')),
      'oddzial_firmy'  => new sfValidatorPropelChoice(array('model' => 'OddzialyFirmy', 'column' => 'id')),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('osoby[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Osoby';
  }


}
