<?php

class sfWidgetDiv extends sfWidgetForm {

    /**
     * Configures the current widget.
     *
     * @param array $options     An array of options
     * @param array $attributes  An array of default HTML attributes
     *
     * @see sfWidgetForm
     */
    protected function configure($options = array(), $attributes = array()) {

    }

    /**
     * Renders the widget.
     *
     * @param  string $name        The element name
     * @param  string $value       The value displayed in this widget
     * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
     * @param  array  $errors      An array of errors for the field
     *
     * @return string An HTML tag string
     *
     * @see sfWidgetForm
     */
    public function render($name, $value = '', $attributes = array(), $errors = array()) {
      if(empty($value)) {
        $value = $this->getDefault();
      }
      return $this->renderContentTag('div', $value, array_merge($attributes));
    }

}
