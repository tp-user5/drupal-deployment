<?php

namespace Drupal\hello;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for hello.module.
 */
class LazybuilderHelloService extends ControllerBase {

  public function content($param_2, $param) {

    // kint($param);

    $nomUtilisateur = $this->currentUser()->getUsername();
    $message = $this->t(
      "Hello ! You are on Hello page.\n Your name is : %userName.\n The URL paramater is : %param.",
      [
        '%userName' => $nomUtilisateur,
        '%param' => $param
      ]
    );

    if (!empty($param_2)) {
      //$message .= $this->t('The result of your operation is : %result', ['%result' => $calculator_result]);
      $message .= $this->t(" The result of your operation is : %param_2", ['%param_2' => $param_2]);
    }

    // Tester l'affichage avec BigPipe en envoyant l'affichage de ce contenu en différé de 5 secondes.
    sleep(5);

    return [
      '#markup' => $message,
      '#cache' => [
        'keys' => ['LazybuilderHello'],
        'contexts' => ['user'],
      ]
    ];
  }

}
