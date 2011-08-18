<?php
class TingClientInfomediaRequest extends TingClientRequest {
  
  private $xpath;  
  
  public function __construct($action=null) {
    if(isset($action) )
      $this->setParameter('action', $action);
    else
      $this->setParameter('action', 'getArticleRequest');
  }

   protected function getRequest() { 
     $this->set_test_request();  
     return $this;
    }

   /**
    * Setup object; TingRequestAdapter-, xpath- and TingClient-object. initialize request
    * TODO error-handling
    */
   public function go() {     
     $adapter = new TingClientRequestAdapter(array());
     $client = new TingClient($adapter);
     $this->set_test_request(); 
     $xml = $client->execute($this);
     
     $dom = new DOMDocument();
     if( !$dom->loadXML($xml) )
       throw new TingClientException('TingClientInfomediaRequest could not load xml', $xml);
     $this->xpath = new DOMXPath($dom);

     return $this->parseXML($xml);     
   }

   private function parseXML($xml) {
     return $this->xpath->document->saveXML();
     //     return $xml;
   }

   /**
    * This methode returns the endpoint for the service - NOT the wsdl
    */
   public function getWsdlUrl() {
     return variable_get('ting_infomedia_url');
   }
 
  /*
   * set parameters for a test request
   */
  private function set_test_request() {
    $parameter = array();

    $parameter['articleIdentifier'] = array('faust'=>27882501);
    $parameter['libraryCode'] = 718300;
    $parameter['userId'] = '0019';
    $parameter['userPinCode'] = '0019';
    $parameter['outputType'] = 'xml';
    
    
    //krumo($parameter);
    
    $this->setParameters($parameter);
    // krumo($this->getParameters());
      
    /* original soap-request
    <uaim:getArticleRequest>
    <uaim:articleIdentifier>
      <uaim:faust>27882501</uaim:faust>
    </uaim:articleIdentifier>
    <uaim:libraryCode>718300</uaim:libraryCode>
    <uaim:userId>0019</uaim:userId>
    <uaim:userPinCode>0019</uaim:userPinCode>
    <uaim:outputType>xml</uaim:outputType>
    </uaim:getArticleRequest>
    */
  }

  // abstract method from TingClientRequest class
  public function processResponse(stdClass $response) {
    //  print_r($response);
    return $response;
  }  
}
