<?php

namespace Drupal\tp_apigeo\Form;

use GeoApiFr\GeoApiFr;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RegionSelector.
 */
class RegionSelector extends FormBase {

  public function getFormId() {
    return 'region_selector';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $response = GeoApiFr::getInstance()->get('regions');
    foreach($response as $region){
      $region_list[$region->code] = $region->nom;
    }

    $form['region'] = [
      '#type' => 'select',
      '#title' => $this->t('Region'),
      '#options' => $region_list,
      '#weight' => '0',
      '#ajax' => array(
        'callback' => [$this, 'AjaxLoadDepartements'],
        'event' => 'change',
        'wrapper' => 'dp_wrapper'
      ),
    ];

    if($region = $form_state->getValue('region')){
      $response = GeoApiFr::getInstance()->get('departements', ['codeRegion' => $region]);
      $department_list = ['Sélectionner le département'];
      foreach($response as $departement){
        $department_list[$departement->code] = $departement->nom;
      }
    }

    $form['dp_wrapper'] = array(
      '#type' => 'container',
      '#attributes' => array('id' => 'dp_wrapper', 'class' => ['visually-hidden'])
    );

    $form['dp_wrapper']['department'] = [
      '#type' => 'select',
      '#title' => $this->t('Départements'),
      '#options' => $department_list,
      '#weight' => '0',
      '#ajax' => array(
        'callback' => [$this, 'AjaxLoadCommunes'],
        'event' => 'change',
        'wrapper' => 'c_wrapper'
      ),
    ];

    if($departement = $form_state->getValue('department')){
      $response = GeoApiFr::getInstance()->get('communes', ['codeDepartement' => $departement]);
      $communes_list = ['Sélectionner la commune'];
      foreach($response as $commune){
        $communes_list[$commune->code] = $commune->nom;
      }
    }

    $form['c_wrapper'] = array(
      '#type' => 'container',
      '#attributes' => array('id' => 'c_wrapper', 'class' => ['visually-hidden'])
    );

    $form['c_wrapper']['commune'] = [
      '#type' => 'select',
      '#title' => $this->t('Communes'),
      '#default_value' => 'hidden',
      '#options' => $communes_list,
      '#weight' => '0',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function AjaxLoadDepartements(array &$form, FormStateInterface $form_state){
    $form['dp_wrapper']['#attributes']['class'] = [];
    return $form['dp_wrapper'];
  }

  public function AjaxLoadCommunes(array &$form, FormStateInterface $form_state){
    $form['c_wrapper']['#attributes']['class'] = [];
    return $form['c_wrapper'];
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('tp_apigeo.geo_controller_commune', ['code_commune' => $form_state->getValue('commune')]);
  }
}