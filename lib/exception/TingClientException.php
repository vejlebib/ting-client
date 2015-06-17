<?php

class TingClientException extends Exception {
  public function __construct($message, $code = 0, Exception $previous = null) {
    foreach($this->errors as $val){
      if(strpos($message, $val) !== FALSE){
        drupal_set_message(t($val), 'warning');
        break;
      }
    }
    parent::__construct($message, $code, $previous);
  }

  private $errors = array(
    'Unsupported index',
    'Unsupported boolean modifier',
    'Invalid or unsupported use',
    'Internal problem',
  );
}

