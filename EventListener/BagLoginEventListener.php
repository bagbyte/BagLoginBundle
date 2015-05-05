<?php
namespace Bag\LoginBundle\EventListener;

use Bag\LoginBundle\Event\UserEvent;
use Bag\LoginBundle\BagLoginEvents;

use Doctrine\ORM\EntityManager;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BagLoginEventListener implements EventSubscriberInterface
{
  private $em;
  private $container;
  
  public function __construct(ContainerInterface $container, EntityManager $entityManager)
  {
    $this->em = $entityManager;
    $this->container = $container;
  }

  public static function getSubscribedEvents()
  {
    return array(
      BagLoginEvents::USER_REQUEST_CONFIRMATION_EMAIL => 'onUserRegistrationEmailRequest',
      BagLoginEvents::USER_REGISTER_WITH_SOCIAL => 'onUserRegistrationWithSocial',
      BagLoginEvents::USER_LOGGED_IN_WITH_SOCIAL => 'onUserLoginWithSocial',
      BagLoginEvents::USER_REGISTER => 'onUserRegistration',
      BagLoginEvents::USER_REGISTRATION_CONFIRMED => 'onRegistrationConfirmed',
      BagLoginEvents::USER_REQUEST_NEW_PASSWORD => 'onNewPasswordRequest',
      BagLoginEvents::USER_CHANGED_PASSWORD => 'onPasswordChanged',
    );
  }

  public function onUserRegistrationEmailRequest(UserEvent $event)
  {
    $settings = $this->container->getParameter('bag_login.email');
    
    if ($settings['send_registration_email'])
      $this->container->get('bag_login.notification_manager')->sendRegistrationEmail($event->getUser());
  }

  public function onUserRegistrationWithSocial(UserEvent $event)
  {
    $settings = $this->container->getParameter('bag_login.email');
    
    if ($settings['send_registration_email'])
      $this->container->get('bag_login.notification_manager')->sendRegistrationEmail($event->getUser(), true);
  }

  public function onUserLoginWithSocial(UserEvent $event) {  }

  public function onUserRegistration(UserEvent $event)
  {
    $settings = $this->container->getParameter('bag_login.email');
    
    if ($settings['send_registration_email'])
      $this->container->get('bag_login.notification_manager')->sendRegistrationEmail($event->getUser());
  }

  public function onRegistrationConfirmed(UserEvent $event)
  {
    $settings = $this->container->getParameter('bag_login.email');
    
    if ($settings['send_activation_email'])
      $this->container->get('bag_login.notification_manager')->sendActivationEmail($event->getUser());
  }
  
  public function onNewPasswordRequest(UserEvent $event) {
    $this->container->get('bag_login.notification_manager')->sendPasswordChangeRequestEmail($event->getUser());
  }
  
  public function onPasswordChanged(UserEvent $event) {
    $settings = $this->container->getParameter('bag_login.email');
    
    if ($settings['send_password_changed_email'])
      $this->container->get('bag_login.notification_manager')->sendPasswordChangedEmail($event->getUser());
  }
}
