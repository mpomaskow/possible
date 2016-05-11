<?php

/**
 * Function escapes a string, clear PHP and JS tags, and then reescape html tags
 *
 * @param string $value the value to escape
 * @return string the escaped value
 */
function clear_tags($value) {
  if (is_string($value)) {
    $value = preg_replace("/<script[^.]*\/script>/i", '', $value);
    $value = preg_replace("/<\?[^.]*\?>/i", '', $value);
    return $value;
  } else {
    return $value;
  }
}

define('CLEAR_TAGS', 'clear_tags');

require_once dirname(__FILE__) . '/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration {

  public function setup() {
    $this->enablePlugins('sfPropelPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
  }

}
