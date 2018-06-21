<?php

namespace Drupal\performance_tests;
use Drupal\Core\Logger\LoggerChannelFactory;

/**
 * Class LazyLoadedContent.
 */
class LazyLoadedContent {

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

  public function content(){
    // sleep(5);
    return [
      '#markup' => time(),
      '#cache' => [
        'cache_keys' => ['perftests_lazybuilded_block']
      ]
      // 'max-age' => 0
    ];
  }
}
