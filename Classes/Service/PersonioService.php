<?php

namespace Pkd\Personio\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use Psr\Http\Message\RequestFactoryInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;

/**
 * Personio Service
 */
class PersonioService extends ActionController
{

  /** @var RequestFactoryInterface */
  private $requestFactory;

  /**
   * Personio Service Constructor
   */
  public function __construct()
  {
     $this->requestFactory = GeneralUtility::makeInstance(RequestFactoryInterface::class);
  }

  /**
   * Fetch Feed Items
   *
   * @return array
   */
  public function fetchFeedItems($feedUrl) {
    $additionalOptions = [
       'headers' => ['Cache-Control' => 'no-cache'],
       'allow_redirects' => false
    ];

    $response = $this->requestFactory->request($feedUrl, 'GET', $additionalOptions);
    
    if ($response->getStatusCode() === 200
    && strpos($response->getHeaderLine('Content-Type'), 'text/xml') === 0) {
      $content = $response->getBody()->getContents();
      $encoder = new XmlEncoder();

      return $encoder->decode($content, 'array')['position'];
    }

    return [];
  }
}
