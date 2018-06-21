<?php

namespace Drupal\annonce\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Session\AccountProxyInterface;

use Drupal\Core\Messenger\MessengerInterface;
use \Drupal\Core\Routing\ResettableStackedRouteMatchInterface;
use Drupal\Core\Database\Connection;
use \Drupal\Component\Datetime\TimeInterface;

/**
 * Class AnnonceEventSubscriber.
 */
class AnnonceEventSubscriber implements EventSubscriberInterface {

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  protected $messenger;
  protected $currentRouteMatch;
  protected $database;
  protected $time;

  /**
   * Constructs a new AnnonceEventSubscriber object.
   */
  public function __construct(AccountProxyInterface $current_user, MessengerInterface $messenger, ResettableStackedRouteMatchInterface $currentRouteMatch, Connection $database, TimeInterface $time) {
    $this->currentUser = $current_user;
    $this->messenger = $messenger;
    $this->currentRouteMatch = $currentRouteMatch;
    $this->database = $database;
    $this->time = $time;
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['kernel.request'] = [['display_username'], ['display_annonce']];

    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */
  public function display_username(Event $event) {

    // kint($this->currentRouteMatch->getCurrentRouteMatch());
    $this->messenger->addMessage('Event for ' . $this->currentUser->getDisplayName());
    // drupal_set_message('Event for ' . $this->currentUser->getUsername(), 'status', TRUE);
    // drupal_set_message('Event kernel.request thrown by Subscriber in module annonce.', 'status', TRUE);
  }

  /**
   * @param \Symfony\Component\EventDispatcher\Event $event
   */
  public function display_annonce(Event $event) {
    if($this->currentRouteMatch->getRouteName() == 'entity.annonce.canonical'){
      $this->messenger->addMessage('Entité annonce');
      $this->database->insert('annonce_history')->fields(array(
        'aid' => $this->currentRouteMatch->getParameter('annonce')->id(),
        'uid' => $this->currentUser->id(),
        'date' => $this->time->getCurrentTime(),
      ))->execute();
    };
  }

}
