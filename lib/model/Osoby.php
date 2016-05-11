<?php

/**
 * Skeleton subclass for representing a row from the 'osoby' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Osoby extends BaseOsoby {
  /**
   * @return string
   */
  public function getWiek() {
    return date("Y") - date("Y", $this->getDataUrodzenia("U"));
  }

  /**
   * @return string
   */
  public function getPlec() {
    if(mb_substr($this->getImie(), -1) === "a") {
      return "kobieta";
    }
    return "mężczyzna";
  }
}

// Osoby
