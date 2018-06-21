<?php

namespace Drupal\performance_tests\Controller;

use Drupal\Core\Controller\ControllerBase;

class CacheExamplesController extends ControllerBase {

  public function page1() {
    $build = [
      '#markup' => 'Simple markup',
      '#cache' => [
        'cache_keys' => ['performance_test.page1'],
        'max-age' => 100
        ]
    ];
    return $build;
  }

  public function page2() {
      $build = [];
      $build['title'] = [
        '#markup' => 'Direct markup (without lazybuilder)<br />',
        '#cache' => [
          'cache_keys' => ['title'],
          'max-age' => 3600
        ]
      ];
      $build['perftests_lazybuilder_block_ra'] = [
          '#lazy_builder' => [
            'lazybuilded_content:cacheable_content',
            []
          ],
          '#create_placeholder' => TRUE
        ];
      return $build;
    }

    public function page3() {
        $build = [];
        $build['title'] = [
          '#markup' => 'Direct markup (without lazybuilder)<br />',
          '#cache' => [
            'cache_keys' => ['title'],
            'max-age' => 0
          ]
        ];
        $build['perftests_lazybuilder_block_ra'] = [
            '#lazy_builder' => [
              'lazybuilded_content:uncacheable_content',
              []
            ],
            '#create_placeholder' => TRUE
          ];
        return $build;
      }
}
