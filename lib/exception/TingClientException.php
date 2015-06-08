<?php

class TingClientException extends Exception {
  public function __construct($message, $code = 0, Exception $previous = null) {
    foreach($this->errors as $key => $val){
      if(strpos($message, $key) !== FALSE){
        drupal_set_message(t($this->errors[$key].': '. $message), 'warning');
        break;
      }
    }
    parent::__construct($message, $code, $previous);
  }

  private $errors = array(
    'Unsupported index' => 'Fix your syntax',
    'Unsupported boolean modifier' => 'Fix your syntax',
    'Invalid or unsupported use' => 'Fix ypur syntax',
    'Internal problem' => 'Try agoin later',
  );
}

