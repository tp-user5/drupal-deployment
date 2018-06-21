<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for hello.module.
 */
class HelloNodeListController extends ControllerBase {

  public function content($nodetype = NULL) {

    $query = $this->entityTypeManager()->getStorage('node')->getQuery();
    // Si on a un argument dans l'URL, on ne cible que les noeuds correspondants.
    if ($nodetype) {
      $query->condition('type', $nodetype);
    }
    // On construit une requête paginée.
    $nids = $query->pager('10')->execute();

    // Charge les noeuds correspondants au résultat de la requête.
    $nodes = $this->entityTypeManager()->getStorage('node')->loadMultiple($nids);

    // Construit un tableau de liens vers les noeuds.
    $items = [];
    foreach ($nodes as $node){
      $items[] = $node->toLink();
    }
    $list = [
      '#theme' => 'item_list',
      '#items' => $items,
      '#title' => $this->t('Node list title'),
    ];

    $pager = ['#type' => 'pager'];


    return [
      'list'  => $list,
      'pager' => $pager,
      '#cache' => [
        'keys' => ['hello:hello_list'],
        'tags' => ['node_list'],
      ],
    ];
  }

}
