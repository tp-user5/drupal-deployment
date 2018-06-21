<?php


namespace Drupal\tp_apigeo\Controller;

use GeoApiFr\GeoApiFr;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class GeoController.
 */
class GeoController extends ControllerBase {

  public function get_commune($code_commune) {
    $data = GeoApiFr::getInstance()->get('communes', ['code' => $code_commune]);
    $this->commune = current($data);
    return $this->commune;
  }

  public function commune_title($code_commune) {
    $this->commune = $this->get_commune($code_commune);
    return $this->commune->nom;
  }

  public function commune($code_commune) {
    $build = [];

    if($code_commune){
      $this->commune = $this->get_commune($code_commune);
      $build[] = ['#markup' => $this->commune->nom.' ('.$this->commune->code.') <br />'];
      $build[] = ['#markup' => $this->commune->population.' habitants<br />'];
    }

    $build[] = \Drupal::formBuilder()->getForm('Drupal\tp_apigeo\Form\RegionSelector');
    return $build;
  }
}