<?php

/**
 * Osoby form.
 *
 * @package    Possible
 * @subpackage form
 * @author     Michal Pomaskow
 */
class OsobyForm extends BaseOsobyForm {

  public function configure() {
    $this->removeFields();
    $this->configureFieldWidgets();
    $this->configureFieldValidators();
  }

  protected function removeFields() {
    unset($this['created_at'], $this['updated_at']);
  }

  protected function configureFieldWidgets() {
    $this->widgetSchema['data_urodzenia'] = new sfWidgetFormInput(array(), array(
      'minyear' => date("Y") - 100,
      'maxyear' => date("Y")
    ));

    $this->widgetSchema['miejscowosc'] = new sfWidgetFormPropelChoice(array(
      'model' => 'Miejscowosci',
      'order_by' => array("Nazwa", "ASC"),
      'add_empty' => false,
    ));

    $this->widgetSchema['firma'] = new sfWidgetFormPropelChoice(array(
      'model' => 'Firmy',
      'order_by' => array("Nazwa", "ASC"),
      'add_empty' => false
    ));

    $this->widgetSchema['oddzial_firmy'] = new sfWidgetFormPropelChoiceAddField(array(
      'model' => 'OddzialyFirmy',
      'order_by' => array("Nazwa", "ASC"),
      'add_empty' => false,
      'add_additional_field' => "Firma",
      'renderer_class' => "sfWidgetFormSelectAddAttribute",
    ));
  }

  protected function configureFieldValidators() {
    $this->validatorSchema['data_urodzenia'] = new sfValidatorRegex(array("pattern" => "/\d{4}-\d{2}-\d{2}/"), array("invalid" => "Invalid. Correct format YYYY-MM-DD."));
  }

}
