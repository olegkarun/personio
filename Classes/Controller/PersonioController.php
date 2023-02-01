<?php

namespace Pkd\Personio\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Pkd\Personio\Service\PersonioService;

/**
 * Personio Controller
 */
class PersonioController extends ActionController
{
  /**
   * Feed Url
   *
   * @var string
   */
  private $feedUrl;

  /**
   * @var PersonioService
   */
  protected $personioService = null;

  /**
   * Filter Items
   *
   * @param array $items
   * @return array
   */
  public function filterItems($value, $key): bool
  {
    foreach($this->settings['filter'] as $filterKey => $filterValue) {
      if(!array_key_exists($filterKey, $value) || $value[$filterKey] !== $filterValue) {
        return false;
      }
    }

    return true;
  }

  /**
   * List Action
   * 
   * @return void
   */
  public function listAction(): void
  {
    foreach($this->settings['filter'] as $filterKey => $filterValue) {
      if(is_null($filterValue) || $filterValue == '') {
        unset($this->settings['filter'][$filterKey]);
      }
    }

    $items = $this->personioService->fetchFeedItems($this->feedUrl);

    if(!empty($this->settings['filter'])) {
      $items = array_filter($items, array($this, 'filterItems'), ARRAY_FILTER_USE_BOTH);
    }
    
    $this->view->assign('items', $items);
  }

  /**
   * Show Action
   * 
   * @return void
   */
  public function showAction(): void
  {
    if(!$this->request->hasArgument('uid')
    && intval($this->request->getArgument('uid'))) {
      return;
    }

    $uid = $this->request->getArgument('uid');
    $items = $this->personioService->fetchFeedItems($this->feedUrl);
    $item = $items[array_search($uid, array_column($items, 'id'))];

    $this->view->assign('item', $item);
    $this->view->assign('feedUrl', parse_url($this->feedUrl));
    
    // @todo rebuild:nextline https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/Seo/PageTitleApi.html
    //$GLOBALS['TSFE']->page['title'] = $item['name'];
  }

  /**
   * Build Settings
   *
   * @return void
   */
  public function buildSettings(): void
  {
    if(is_array($this->settings['overwrite'])) {
      foreach($this->settings['overwrite'] as $key => $value) {
        if(!empty($value)) {
          $this->settings[$key] = trim($value);
        }
      }
    }
    unset($this->settings['overwrite']);
  }

  /**
   * Initializes the controller before invoking an action method.
   * 
   * @return void
   */
  protected function initializeAction(): void
  {
    $this->buildSettings();
    $this->personioService = new PersonioService();
    $this->feedUrl = $this->settings['feedUrl'] . '?language=' . $this->settings['language'];
  }
}
