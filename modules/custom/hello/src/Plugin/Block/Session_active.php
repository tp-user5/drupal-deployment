<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block to count the number of active session.
 *
 * @Block(
 *   id = "session_active_block",
 *   admin_label = @translation("Number of active session")
 * )
 */
class Session_active extends BlockBase {

  /**
   * Implements Drupal\Core\Block\BlockBase::build()
   */
  public function build() {

    $message = $this->t(
      'There is currently %nbActiveSession active sessions',
      [
        '%nbActiveSession' => \Drupal::database()->select('sessions')->countQuery()->execute()->fetchField(),
      ]
    );
    $build = array(
      '#markup' => $message,
      '#cache' => [
        'keys' => ['hello:sessions'],
        'max-age' => '10',
      ],
    );

    return $build;
  }

}
