<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class HelloForm.
 */
class HelloAdminForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'admin_form';
  }

  public function getEditableConfigNames() {
    return ['hello.config'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $color = $this->config('hello.config')->get('color');

    $form['color'] = [
      '#type' => 'select',
      '#title' => $this->t('Choose a block color'),
      '#options' => [
        '' => $this->t('No color'),
        'blue-class' => $this->t('Blue'),
        'green-class' => $this->t('Green'),
        'red-class' => $this->t('Red'),
      ],
      '#default_value' => $color,
    ];
/*
 * Pour personnaliser le bouton 'Save configuration'
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save the configuration'),
    ];

    return $form;
*/
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('hello.config')->set('color', $form_state->getValue('color'))->save();
    \Drupal::entityTypeManager()->getViewBuilder('block')->resetCache();

    parent::submitForm($form, $form_state);
  }

}
