<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
// use Drupal\node\Entity;
use Drupal\node\NodeInterface;

/**
 * Class NodeHistoryController
 *
 * @package Drupal\hello\Controller
 */
class NodeHistoryController extends ControllerBase {

  public function content(NodeInterface $node) {

    /**
     * @var \Drupal\Core\Database\Query\SelectInterface $query
     */
    $query = \Drupal::database()->select('hello_node_history', 'hnh')
      ->fields('hnh', ['uid', 'update_time'])
      ->condition('nid', $node->id());
    $result = $query->execute();

    // Tableau des updates.
    $rows = [];
    $uids = [];
    foreach ($result as $record) {
      $rows[] = [
        \Drupal::entityTypeManager()->getStorage('user')->load($record->uid)->toLink(),
        \Drupal::service('date.formatter')->format($record->update_time),
      ];
      $uids[] = 'user:' . $record->uid;
    }
    $table = [
      //*
      '#theme' => 'hello_node_history',
      '#count' => 'X',
      '#node' => 'nodeName',
      /*
      '#theme' => 'table',
      '#header' => [$this->t('Author'), $this->t('Update_time')],
      '#rows' =>$rows,
      */
    ];

    return [
      'hello_node_history' => $table,
      //'table' => $table,
      '#cache' => [
        'keys' => ['hello:node_history: ' . $node->id()],
        'tags' => array_merge(['node:' . $node->id()], $uids),
      ]
    ];
  }

}
