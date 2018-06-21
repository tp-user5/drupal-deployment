<?php

namespace Drupal\hello\Access;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Access\AccessResult;

class HelloAccessCheck implements AccessCheckInterface {

  /**
   * @var \Drupal\Component\Datetime\Time
   */
  protected $time;

  /**
   * HelloAccessCheck constructor.
   *
   * @param \Drupal\Component\Datetime\Time $date_time
   */
  public function __construct(TimeInterface $date_time) {
    $this->time = $date_time;
  }

  /**
   * {@inheritdoc}.
   */
  public function applies(Route $route) {
    return NULL;
  }

  /**
   * @param \Symfony\Component\Routing\Route $route
   * @param \Symfony\Component\HttpFoundation\Request|NULL $request
   * @param \Drupal\Core\Session\AccountInterface $account
   *
   * @return \Drupal\Core\Access\AccessResultAllowed|\Drupal\Core\Access\AccessResultForbidden
   */
  public function access(Route $route, Request $request = NULL, AccountProxy $account) {
    $nbr_heures = $route->getRequirement('_access_hello');
    //kint($account->getAccount());
    if ($account->isAnonymous() && ($this->time->getCurrentTime() - $account->getAccount()->created > $nbr_heures * 3600)) {
      return AccessResult::allowed()->cachePerUser();
    }
    return AccessResult::forbidden()->cachePerUser();
  }
}
