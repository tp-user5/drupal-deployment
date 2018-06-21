<?php

namespace Drupal\performance_tests\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CacheTablesViewerController extends ControllerBase {

  public function cache_render_explorer($string) {
    // $rows = \Drupal::database()->select('cache_dynamic_page_cache', 'c')
    $query = \Drupal::database()->select('cache_render', 'c')
    ->fields('c', array(
    'cid',
    'data',
    'expire',
    'tags'
    ));
    $query->condition('c.cid', '%'.$string.'%', 'LIKE');
    // ->orderBy('e.created', 'DESC')
    // ->range(0, 10)
    $rows = $query->execute();

    foreach($rows as $row){
      dump($row->cid);
      dump(unserialize($row->data));
      dump('expiration: '.date('H:m:s', $row->expire));
      dump($row->tags);
      print '<br />';
    }

  return new Response();
  }

    public function cache_page_explorer($string) {
      // $rows = \Drupal::database()->select('cache_dynamic_page_cache', 'c')
      $query = \Drupal::database()->select('cache_page', 'c')
      ->fields('c', array(
      'cid',
      'data',
      'created',
      'expire',
      'tags'
      ));
      if(!empty($string)) $query->condition('c.cid', '%'.$string.'%', 'LIKE');
      // ->orderBy('e.created', 'DESC')
      // ->range(0, 10)
      $rows = $query->execute();

      foreach($rows as $row){
        dump($row->cid);
        dump($row->created);
        dump(unserialize($row->data));
        dump('expiration: '.date('H:m:s', $row->expire));
        dump($row->tags);
        print '<br />';
      }
    return new Response();
    }

  public function cache_dynamic_page_cache_explorer($string) {
    // $rows = \Drupal::database()->select('cache_dynamic_page_cache', 'c')
    $query = \Drupal::database()->select('cache_dynamic_page_cache', 'c')
    ->fields('c', array(
    'cid',
    'data',
    'expire',
    'tags'
    ));
    if(!empty($string)) $query->condition('c.cid', '%'.$string.'%', 'LIKE');
    // ->orderBy('e.created', 'DESC')
    // ->range(0, 10)
    $rows = $query->execute();

    foreach($rows as $row){
      dump($row->cid);
      dump(unserialize($row->data));
      dump('expiration: '.date('H:m:s', $row->expire));
      dump($row->tags);
      print '<br />';
    }

  return new Response();
  }

}
