<?php
class TingClientInfomediaRequest extends TingClientRequest {
  
  private $xpath;  
  
  public function __construct($action=null) {
    if(isset($action) )
      $this->setParameter('action', $action);
    else
      $this->setParameter('action', 'getArticleRequest');

    $this->go();
  }

  /**
   * Setup object; TingRequestAdapter-, xpath- and TingClient-object. initialize request
   * TODO error-handling
   */
  private function go() {     
    $adapter = new TingClientRequestAdapter(array());
    $client = new TingClient($adapter);
    $this->set_test_request(); 
    $xml = $client->execute($this);
    
    $dom = new DOMDocument();
    if( !$dom->loadXML($xml) )
      throw new TingClientException('TingClientInfomediaRequest could not load xml', $xml);
    $this->xpath = new DOMXPath($dom);
  }

  public function xml() {
    return $this->xpath->document->saveXML();
  }

  public function html() {
    $action = $this->getParameter('action');
    
    switch( $action ) {
    case 'getArticleRequest':
      $query="/uaim:getArticleResponse/uaim:getArticleResponseDetails/uaim:imArticle";
      $node_list=$this->xpath->query($query);
      return $this->clean_html($node_list->item(0)->nodeValue);
      break;
    default:
      throw new TingClientException('TingClientInfomediaRequest no or not supported action', $action);
      break;
    }
  }

  private function clean_html($html)
  {
    $patterns = array();

    $patterns[0] = '/<p id=".+">/';
    $patterns[1] = '/<hl2>/';
    $patterns[2] = '/<\/hl2>/';
    $replacements = array();
    $replacements[0] = '<p>';
    $replacements[1] = '<h4>';
    $replacements[2] = '</h4>';

    $ret = preg_replace($patterns, $replacements, $html);
    return $ret;
  }

  protected function getRequest() { 
    $this->set_test_request();  
    return $this;
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
    
    $this->setParameters($parameter);
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
    return $response;
  }  
}
