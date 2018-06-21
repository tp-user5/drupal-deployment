<?php

namespace Drupal\performance_tests\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\Client;

/**
 * Provides a 'DynamicBlock' block.
 *
 * @Block(
 *  id = "dynamic_block",
 *  admin_label = @Translation("Dynamic block"),
 * )
 */
class DynamicBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * GuzzleHttp\Client definition.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;
  /**
   * Constructs a new SlowBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    Client $http_client
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->httpClient = $http_client;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('http_client')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['title'] = [
        '#markup' => 'Dynamic block (placeholdered)<br />',
        '#cache' => [
          'cache_keys' => ['title'],
          'max-age' => 3600
        ]
      ];
    $build['dynamic_block_ra']= [
      '#markup' => date('H:m:s', time()),
      '#cache' => [
        'cache_keys' => ['perftests_dynamic_block_ra'],
        'contexts' => ['user'],
        'tags' => ['user_list'],
        'max-age' => 0
      ]
    ];
    return $build;
  }

}
