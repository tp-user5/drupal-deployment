<?php

namespace Drupal\tp_apigeo\Controller;

use Drupal\Core\Controller\ControllerBase;

use GeoApiFr\GeoApiFr;

/**
 * Provides route responses for hello.module.
 */
class RegionController extends ControllerBase {

  public function content($code_region) {



    return ['#markup' => $this->t('TEST Region')];
  }

}
