<?php

class TingClientMarcXchnageRequest extends TingClientRequest {
  protected $agency;
  protected $profile;
  protected $identifier;

  public function setAgency($agency) {
    $this->agency = $agency;
  }

  public function setProfile($profile) {
    $this->profile = $profile;
  }

  public function setIdentifier($id) {
    $this->identifier = $id;
  }

  public function getRequest() {
    // Hardcoded defaults.
    $this->setParameter('action', 'getObjectRequest');
    $this->setParameter('outputType', 'json');
    $this->setParameter('objectFormat', 'marcxchange');

    // Library settings.
    $this->setParameter('agency', $this->agency);
    $this->setParameter('profile', $this->profile);

    // Object ID (agency:faust).
    $this->setParameter('identifier', $this->identifier);

    return $this;
  }

  public function processResponse(stdClass $response) {
    return new TingMarcResult($response);
  }

}
