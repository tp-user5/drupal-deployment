<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for hello.module.
 */
class HelloController extends ControllerBase {

  public function content($param_2, $param) {

    return [
      '#lazy_builder' => [
        'lazybuilder.hello.hello:content',
        [$param_2, $param]
      ],
      '#create_placeholder' => TRUE
    ];
  }

}
