<?php
class TingMarcResult {
  /**
   * Raw data from webservice
   * @var OutputInterface
   */
  private $result;

  private $data = array();

  public function __construct($result) {
    $this->_position = 0;
    $this->result = $result;
    $this->process();
  }

  /**
   * Build items from raw data (json).
   */
  protected function process() {
    // Check for errors.
    if (!empty($this->result->searchResponse->error)) {
      throw new TingMarcException($this->result->searchResponse->error);
    }

    $data = $this->result
      ->searchResponse->result->searchResult[0]
      ->collection->object[0]
      ->collection->record->datafield;

    if (empty($data)) {
      unset($this->result);
      return;
    }

    $index = 0;
    foreach ($data as $datafield) {
      $tag = $datafield->{'@tag'}->{'$'};
      $subfields = $datafield->subfield;

      if (empty($subfields)) {
        unset($this->result);
        return;
      }

      if (is_object($subfields)) {
        $code = $subfields->{'@code'}->{'$'};
        $value = $subfields->{'$'};
        $this->_setData($tag, $code, $value, $index);
      }
      elseif (is_array($subfields)) {
        foreach ($subfields as $subfield) {
          $code = $subfield->{'@code'}->{'$'};
          $value = $subfield->{'$'};
          $this->_setData($tag, $code, $value, $index);
        }
      }
      $index++;
    }
    unset($this->result);
  }

  public function getValue($field, $subfield = NULL, $index = -1) {
    if ($subfield) {
      if ($index == -1 && isset($this->data[$field][$subfield])) {
          return reset($this->data[$field][$subfield]);
      }
      elseif (isset($this->data[$field][$subfield][$index])) {
        return $this->data[$field][$subfield][$index];
      }
    }
    elseif (isset($this->data[$field])) {
      return $this->data[$field];
    }
    return NULL;
  }

  private function _setData($tag, $code, $value, $index) {
    if (!empty($this->data[$tag][$code][$index])) {
      if (is_array($this->data[$tag][$code][$index])) {
        $this->data[$tag][$code][$index][] = $value;
      }
      else {
        $tmp = $this->data[$tag][$code][$index];
        $this->data[$tag][$code][$index] = array($tmp);
        $this->data[$tag][$code][$index][] = $value;
      }
    }
    else {
      $this->data[$tag][$code][$index] = $value;
    }
  }
}
