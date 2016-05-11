<?php

class sfWidgetFormPropelChoiceAddField extends sfWidgetFormPropelChoice {

  /**
   * @see sfWidget
   */
  public function __construct($options = array(), $attributes = array()) {
    $options['choices'] = array();
    parent::__construct($options, $attributes);
  }

  /**
   * Constructor.
   *
   * Available options:
   *
   *  * add_additional_field: Additional attribute for option element
   *
   * @see sfWidgetFormSelect
   */
  protected function configure($options = array(), $attributes = array()) {
    $this->addRequiredOption('model');
    $this->addOption('add_additional_field', false);

    parent::configure($options, $attributes);
  }

  /**
   * Returns the choices associated to the model.
   *
   * @return array An array of choices
   */
  public function getChoices() {
    $choices = array();
    if (false !== $this->getOption('add_empty')) {
      $choices[''] = true === $this->getOption('add_empty') ? '' : $this->translate($this->getOption('add_empty'));
    }

    $class = constant($this->getOption('model') . '::PEER');

    $criteria = null === $this->getOption('criteria') ? new Criteria() : clone $this->getOption('criteria');
    if ($order = $this->getOption('order_by')) {
      $method = sprintf('add%sOrderByColumn', 0 === strpos(strtoupper($order[1]), 'ASC') ? 'Ascending' : 'Descending');
      $criteria->$method(call_user_func(array($class, 'translateFieldName'), $order[0], BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME));
    }
    $objects = call_user_func(array($class, $this->getOption('peer_method')), $criteria, $this->getOption('connection'));

    $methodKey = $this->getOption('key_method');
    if (!method_exists($this->getOption('model'), $methodKey)) {
      throw new RuntimeException(sprintf('Class "%s" must implement a "%s" method to be rendered in a "%s" widget', $this->getOption('model'), $methodKey, __CLASS__));
    }

    $methodValue = $this->getOption('method');
    if (!method_exists($this->getOption('model'), $methodValue)) {
      throw new RuntimeException(sprintf('Class "%s" must implement a "%s" method to be rendered in a "%s" widget', $this->getOption('model'), $methodValue, __CLASS__));
    }

    if ($this->getOption('add_additional_field') !== false) {
      $additional_field = $this->getOption('add_additional_field');
      $methodAddt = sprintf('get%s', $additional_field);
      if (!method_exists($this->getOption('model'), $methodAddt)) {
        throw new RuntimeException(sprintf('Class "%s" must implement a "%s" method to be rendered in a "%s" widget', $this->getOption('model'), $methodAddt, __CLASS__));
      }
    }

    foreach ($objects as $object) {
      $values = array("value" => $object->$methodValue());
      if($methodAddt) {
        $values[strtolower($additional_field)] = $object->$methodAddt();
      }
      $choices[$object->$methodKey()] = $values;
    }

    return $choices;
  }
}
