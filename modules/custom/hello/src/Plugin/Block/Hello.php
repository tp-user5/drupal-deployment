<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block to view Hello TEST.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @translation("Hello!")
 * )
 */
class Hello extends BlockBase {

  protected function blockAcess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission('Access_hello', $account);
  }

  /**
   * Implements Drupal\Core\Block\BlockBase::build()
   */
  public function build() {

    $message = $this->t(
      'Welcome %name. It is %time',
      [
        '%name' => \Drupal::currentUser()->getAccountName(),
        '%time' => \Drupal::service('date.formatter')->format(\Drupal::service('datetime.time')->getCurrentTime(), 'custom', 'H:i s\s'),
      ]
    );

    $build = array(
      '#markup' => $message,
      '#cache' => [
        'keys' => ['hello_block'],
        'contexts' => ['user'],
        'max-age' => '10',
      ],
      );

    return $build;
  }

}
