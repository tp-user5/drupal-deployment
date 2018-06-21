<?php
namespace Drupal\hello\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class HelloAccessAdmin extends RouteSubscriberBase {

  // TEST hack


  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Change path '/user/login' to '/login'.
    /*
    if ($route = $collection->get('system.modules_list')) {
      $route->setPath('/modules');
    }
    // Always deny access to '/user/logout'.
    // Note that the second parameter of setRequirement() is a string.
    if ($route = $collection->get('system.modules_list')) {
      $route->setRequirement('_access', 'FALSE');
    }
    */
    $route = $collection->get('system.modules_list');
    $route->setRequirement('_access', 'TRUE');
  }

}
