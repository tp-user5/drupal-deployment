<?php

namespace Drupal\performance_tests\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\Client;

/**
 * Provides a 'SomeOtherBlock' block.
 *
 * @Block(
 *  id = "some_other_block",
 *  admin_label = @Translation("Some Other Block"),
 * )
 */
class SomeOtherBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $httpClient;

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    Client $http_client
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->httpClient = $http_client;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('http_client')
    );
  }

  public function build() {
    $build = [];
    $build['title'] = [
      '#markup' => 'Some other block<br />',
      '#cache' => [
        'cache_keys' => ['title'],
        'max-age' => 3600
      ]
    ];
    $build['some_other_block_ra']= [
      '#markup' => date('H:m:s', time()),
      '#cache' => [
        'cache_keys' => ['perftests_some_other_block_ra'],
        // 'contexts' => ['user'],
        'max-age' => 3600
      ]
    ];
    return $build;
  }

}
