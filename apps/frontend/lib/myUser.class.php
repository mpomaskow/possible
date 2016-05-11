<?php

class myUser extends sfUser {

    public function isFirstRequest($boolean = null) {
        if (is_null($boolean)) {
            return $this->getAttribute('first_request', true);
        }

        $this->setAttribute('first_request', $boolean);
    }

    public function hasCredential($credential, $useAnd = true) {
      return true;
    }
}
