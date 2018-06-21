<?php

namespace Drupal\tp_apigeo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use GeoApiFr\GeoApiFr;

/**
 * Class HelloForm.
 */
class SelectorForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'selector_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $regions = GeoApiFr::getInstance()->get('regions');
    // kint($region);

    $region_list = array();
    foreach ($regions as $region) {
      $region_list[$region->code] = $region->nom;
    }

    // kint($region_list);

    $form['region'] = [
      '#type' => 'select',
      '#title' => $this->t('Region'),
      '#options' => $region_list,
      '#weight' => '10',
    ];

    if ($region = $form_state->getValue('region')) {
      // kint($region);
      $response = GeoApiFr::getInstance()->get('departements', 'codeRegion='.$region);
      // kint($response);
      $departement_list = array();
      foreach ($response as $departement) {
        $departement_list[$departement->code] = $departement->nom;
      }

      $form['departement'] = [
        '#type' => 'select',
        '#title' => $this->t('Département'),
        '#options' => $departement_list,
        '#weight' => '20',
      ];
    }

    if ($departement = $form_state->getValue('departement')) {
      $response = GeoApiFr::getInstance()->get('communes', 'codeDepartement='.$departement);
      // kint($response);
      $commune_list = array();
      foreach ($response as $commune) {
        $commune_list[$commune->code] = $commune->nom;
      }

      $form['commune'] = [
        '#type' => 'select',
        '#title' => $this->t('Commune'),
        '#options' => $commune_list,
        '#weight' => '30',
      ];
    }

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#weight' => '50',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    //kint('submit');
    // $form_state->setRebuild();
    $test = array('azzer');
    $form_state->setRedirect('tp_apigeo.index', $test);
  }
}