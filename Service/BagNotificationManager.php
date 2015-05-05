<?php
namespace Bag\LoginBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BagNotificationManager
{   
  private $container;
  private $em;
  private $templateEngine;
  
  public function __construct(ContainerInterface $container, EntityManager $entityManager, $templateEngine)
  {
    $this->container = $container;
    $this->em = $entityManager;
    $this->templateEngine = $templateEngine;
  }
  
  private function sendEmail($to, $subject, $from_address, $from_name, $view, $type, $options) {
    $contentType = "text/plain";
    
    if (!is_null($type) && ($type == 'html'))
      $contentType = "text/html";
    
    $messagge = \Swift_Message::newInstance()
      ->setContentType($contentType)
      ->setSubject($subject)
      ->setFrom(array($from_address => $from_name))
      ->setTo($to)
      ->setBody(
        $this->templateEngine->render(
          $view,
          $options)
        )
    );
	
    try {
      $this->container->get('mailer')->send($messagge);
    } catch (\Exception $e) {
    }
  }
  
  public function sendRegistrationEmail($user, $social = false)
  {
    $settings = $this->container->getParameter('bag_login.email');
    
    $subject = $settings['events']['registration']['subject'];
    $view = $settings['events']['registration']['view'];
    $type = $settings['events']['registration']['type'];
    $options = array('user' => $user,
                     'sendActivationEmail' => (!$social && $settings['require_account_verification']));

    $this->sendEmail($user->getEmail(), $subject, $settings['from_address'], $settings['from_display_name'], $view, $type, $options);
  }
  
  public function sendActivationEmail($user)
  {
    $settings = $this->container->getParameter('bag_login.email');
    
    $subject = $settings['events']['account_activation']['subject'];
    $view = $settings['events']['account_activation']['view'];
    $type = $settings['events']['account_activation']['type'];
    $options = array('user' => $user);

    $this->sendEmail($user->getEmail(), $subject, $settings['from_address'], $settings['from_display_name'], $view, $type, $options);
  }
  
  public function sendPasswordChangeRequestEmail($user)
  {
    $settings = $this->container->getParameter('bag_login.email');
    
    $subject = $settings['events']['request_new_password']['subject'];
    $view = $settings['events']['request_new_password']['view'];
    $type = $settings['events']['request_new_password']['type'];
    $options = array('user' => $user);

    $this->sendEmail($user->getEmail(), $subject, $settings['from_address'], $settings['from_display_name'], $view, $type, $options);
  }
  
  public function sendPasswordChangedEmail($user)
  {
    $settings = $this->container->getParameter('bag_login.email');
    
    $subject = $settings['events']['password_changed']['subject'];
    $view = $settings['events']['password_changed']['view'];
    $type = $settings['events']['password_changed']['type'];
    $options = array('user' => $user);

    $this->sendEmail($user->getEmail(), $subject, $settings['from_address'], $settings['from_display_name'], $view, $type, $options);
  }
}
