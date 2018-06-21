<?php

namespace Drupal\performance_tests;
use Drupal\Core\Logger\LoggerChannelFactory;

/**
 * Class LazyLoadedContent.
 */
class LazyBuildedContent {

  /**
   * Drupal\Core\Logger\LoggerChannelFactory definition.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactory
   */
  protected $loggerFactory;
  /**
   * Constructs a new LazyLoadedContent object.
   */
  public function __construct(LoggerChannelFactory $logger_factory) {
    $this->loggerFactory = $logger_factory;
  }

  public function uncacheable_content(){
    sleep(3);
    $build['title'] = [
      '#markup' => 'Lazybuilded part (uncacheable)<br />',
      '#cache' => [
        'cache_keys' => ['title'],
        'max-age' => 0
      ]
    ];
    $build['content'] = [
      '#markup' => date('H:m:s', time()),
      '#cache' => [
        'cache_keys' => ['perftests_lazybuilded_content_ra'],
        'max-age' => 0
      ]
    ];
  return $build;
  }



  public function cacheable_content(){
    sleep(2);
    $build['title'] = [
      '#markup' => 'Lazybuilded part (cacheable)<br />',
      '#cache' => [
        'cache_keys' => ['title'],
        'max-age' => 3600
      ]
    ];
    $build['content'] = [
      '#markup' => date('H:m:s', time()),
      '#cache' => [
        'cache_keys' => ['perftests_lazybuilded_content_sra'],
        'max-age' => 3600
      ]
    ];
  return $build;
  }
}
