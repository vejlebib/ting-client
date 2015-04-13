<?php

class TingClientSuggestionFacet {

  public $suggestion;
  public $frequency;

  public function __construct($suggestion, $frequency) {
    $this->suggestion = $suggestion;
    $this->frequency = $frequency;
  }
}
