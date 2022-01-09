<?php

namespace Pkd\Personio\Hook;

use Pkd\Personio\Service\PersonioService;

class ItemsProcFunc
{

  /**
   * @var PersonioService
   */
  protected $personioService = null;

  public function getFilterValues(&$params) {
    $params['items'] = [
      ['None', '']
    ];  

    $feedUrl = $params['flexParentDatabaseRow']['pi_flexform']['data']['sDEF']['lDEF']['settings.overwrite.feedUrl']['vDEF'];    
    if(empty($feedUrl)) {
      return;
    }

    $this->personioService = new PersonioService();

    $items = $this->personioService->fetchFeedItems($feedUrl);
    $filterKey = end(explode('.', $params['field']));
    $filter = [];
    
    foreach($items as $key => $item) {
      if(array_key_exists($filterKey, $item)) {
        array_push($filter, $item[$filterKey]);
      }
    }
    $filter = array_unique($filter);

    foreach($filter as $filterValue) {
      $params['items'][] = [$filterValue, $filterValue];
    }
  }
}