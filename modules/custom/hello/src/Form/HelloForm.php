<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Class HelloForm.
 */
class HelloForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'hello_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Champ destiné à afficher le résultat du calcul.
    if (isset($form_state->getRebuildInfo()['result'])) {
      $form['result'] = [
        '#markup' => '<h2>'.$this->t('result : ' . $form_state->getRebuildInfo()['result'] . '</h2>'),
      ];
    }

    $form['first_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First value'),
      '#ajax' => array(
        'callback' => array($this, 'ajaxValidateNumeric'),
        'event' => 'change',
      ),
      '#suffix' => '<span class="error-message"></span>',
    ];
/*
    $form['first_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First value'),
    ];
*/
    $form['operation'] = [
      '#type' => 'radios',
      '#title' => $this->t('Operator'),
      '#options' => [
        'plus' => 'Plus',
        'minus' => 'Minus',
        'multiply' => 'Multiply',
        'divide' => 'Divide',
      ],
      '#default_value' => 'plus',
    ];

    $form['second_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Second value'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Calculate'),
    ];

    return $form;
  }

  public function ajaxValidateNumeric(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $field = $form_state->getTriggeringElement()['#name'];

    if (is_numeric($form_state->getValue($field))) {
      $css = ['border' => '2px solid green'];
      $message = $this->t('Ok!');
    } else {
      $css = ['border' => '2px solid red'];
      $message = $this->t('%field must be numeric!', ['%field' => $form[$field]['#title']]);
    }

    $response->AddCommand(new CssCommand("[name=$field]", $css));
    $response->AddCommand(new HtmlCommand('.error-message' . $field, $message));

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $first_value = $form_state->getValue('first_value');
    $second_value = $form_state->getValue('second_value');
    $operation = $form_state->getValue('operation');

    if(!is_numeric($first_value)) {
      $form_state->setErrorByName($first_value, $this->t('The first value must benumeric !'));
    }

    /*
    if(!$operation) {
      $form_state->setErrorByName($first_value, $this->t('Please choose an operator'));
    }
    */

    if(!is_numeric($second_value)) {
      $form_state->setErrorByName($second_value, $this->t('The second value must benumeric !'));
    } elseif ($operation == 'divide' && !$second_value) {
      $form_state->setErrorByName($second_value, $this->t('You are trying to divide something by ZERO !'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $operator = $form_state->getValue('operation');

    switch ($operator) {
      case 'minus' :
        $result = $form_state->getValue('first_value') - $form_state->getValue('second_value');
        break;
      case 'multiply' :
        $result = $form_state->getValue('first_value') * $form_state->getValue('second_value');
        break;
      case 'divide' :
        $result = $form_state->getValue('first_value') / $form_state->getValue('second_value');
        break;
      default :
        $result = $form_state->getValue('first_value') + $form_state->getValue('second_value');
    }

    $form_state->addBuildInfo('result', $result);
    $form_state->setRebuild();

    // $datetime_submit = \Drupal::service('datetime.time')->getCurrentTime();

    // drupal_set_message($this->t('The result is : ') . $result);

    \Drupal::state()->set('hello_form_submission_time', REQUEST_TIME);

    $tab_result = ['param_2' => $result];
    $form_state->setRedirect('hello.hello', $tab_result);

/*
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }
*/
  }

}
