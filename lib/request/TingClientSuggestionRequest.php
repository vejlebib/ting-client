<?php

class TingClientSuggestionRequest extends TingClientRequest {

  protected $query;
  protected $index;
  protected $facetIndex;
  protected $filterQuery;
  protected $sort;
  protected $agency;
  protected $profile;
  protected $maxSuggestions;
  protected $maxTime;
  protected $highlight;
  protected $highlightPre;
  protected $highlightPost;
  protected $logger;

  public function getRequest() {
    $this->setParameter('action', 'sug:getFacet');

    $methodParameterMap = array(
      'index' => 'index',
      'query' => 'query',
      'facetIndex' => 'facetIndex',
      'filterQuery' => 'filterQuery',
      'agency' => 'agency',
      'profile' => 'profile',
      'highlight' => 'highlight',
      'highlightPre' => 'highlight.pre',
      'highlightPost' => 'highlight.post',
      'maxSuggestions' => 'maxSuggestions',
      'maxTime' => 'maxTime',
      'sort' => 'sort',
      'outputType' => 'json',
    );

    foreach ($methodParameterMap as $method => $parameter) {
      $getter = 'get' . ucfirst($method);
      if (method_exists('TingClientSuggestionRequest', $getter)) {
        if ($value = $this->$getter()) {
          $this->setParameter($parameter, $value);
        }
      }
      else {
        $this->logger = new TingClientDrupalWatchDogLogger();
        $this->logger->doLog('Call to undefined method TingClientSuggestionRequest::' . $getter, WARNING);
      }
    }

    return $this;
  }

  public function processResponse(stdClass $response) {
    return $response;
  }

  public function parseResponse($responseString) {
    return $responseString;
  }

  public function setQuery($query) {
    $this->query = $query;
  }
  public function getQuery() {
    return $this->query;
  }

  public function setIndex($index) {
    $this->index = $index;
  }
  public function getIndex() {
    return $this->index;
  }

  public function setFacetIndex($facet_index) {
    $this->facetIndex = $facet_index;
  }
  public function getFacetIndex() {
    return $this->facetIndex;
  }

  public function setFilterQuery($filter_query) {
    $this->filterQuery = $filter_query;
  }
  public function getFilterQuery() {
    return $this->filterQuery;
  }

  public function setSort($sort) {
    $this->sort = $sort;
  }
  public function getSort() {
    return $this->sort;
  }

  public function setAgency($agency) {
    $this->agency = $agency;
  }
  public function getAgency() {
    return $this->agency;
  }

  public function setProfile($profile) {
    $this->profile = $profile;
  }
  public function getProfile() {
    return $this->profile;
  }

  public function setMaxSuggestions($max_suggestions) {
    $this->maxSuggestions = $max_suggestions;
  }
  public function getMaxSuggestions() {
    return $this->maxSuggestions;
  }

  public function setMaxTime($max_time) {
    $this->maxTime = $max_time;
  }
  public function getMaxTime() {
    return $this->maxTime;
  }

  public function setHighlight($highlight) {
    $this->highlight = ( $highlight ) ? 'true' : NULL;
  }
  public function getHighlight() {
    return $this->highlight;
  }

  public function setHighlightPre($highlight_pre) {
    $this->highlightPre = $highlight_pre;
  }
  public function getHighlightPre() {
    return $this->highlightPre;
  }

  public function setHighlightPost($highlight_post) {
    $this->highlightPost = $highlight_post;
  }
  public function getHighlightPost() {
    return $this->highlightPost;
  }

  public function setOutputType($output_type) {
    $this->highlightPost = $output_type;
  }
  public function getOutputType() {
    return $this->highlightPost;
  }

}
