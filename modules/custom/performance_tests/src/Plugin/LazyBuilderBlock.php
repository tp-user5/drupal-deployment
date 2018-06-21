<?php

namespace Drupal\performance_tests\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\Client;

/**
 * Provides a 'c' block.
 *
 * @Block(
 *  id = "perftests_lazybuilded_block",
 *  admin_label = @Translation("LazyBuilded block"),
 * )
 */
class LazyBuilderBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
      '#markup' => 'LazyBuilder block<br />',
      '#cache' => [
        'cache_keys' => ['title'],
        'max-age' => 3600
      ]
    ];
    $build['perftests_lazybuilder_block_ra'] = [
        '#lazy_builder' => [
          'lazybuilder_content:uncacheable_content',
          []
        ],
        '#create_placeholder' => TRUE,
        'max-age' => 0
      ];
    return $build;
  }

}
