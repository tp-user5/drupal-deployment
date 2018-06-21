<?php

namespace Drupal\tp_apigeo\Controller;

use Drupal\Core\Controller\ControllerBase;

use GeoApiFr\GeoApiFr;

/**
 * Provides route responses for hello.module.
 */
class ApigeoController extends ControllerBase {

  public function content($test) {

    //$form = \Drupal::formBuilder()->getForm('Drupal\tp_apigeo\Form\SelectorForm');
    //$form = 'TEST Form';
    // $reponse = 'TEST Result';
    return ['#markup' => $test];
  }

}
