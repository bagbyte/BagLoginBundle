<?php
namespace Bag\LoginBundle;

/**
 * Contains all events
 */
final class BagLoginEvents
{
  /**
   * The USER_REQUEST_CONFIRMATION_EMAIL event occurs when an user requests again the confirmation email.
   *
   * The event listener method receives a Bag\LoginBundle\Event\UserEvent instance.
   */
  const USER_REQUEST_CONFIRMATION_EMAIL = 'bag_login.user_request_confirmation_email';
  
  /**
   * The USER_REGISTER_WITH_SOCIAL event occurs when an user register using a social network.
   *
   * The event listener method receives a Bag\LoginBundle\Event\UserEvent instance.
   */
  const USER_REGISTER_WITH_SOCIAL = 'bag_login.user_register_with_social';
  
  /**
   * The USER_LOGGED_IN_WITH_SOCIAL event occurs when an user logged in using social authentication.
   *
   * The event listener method receives a Bag\LoginBundle\Event\UserEvent instance.
   */
  const USER_LOGGED_IN_WITH_SOCIAL = 'bag_login.user_logged_in_with_social';
  
  /**
   * The USER_REGISTER event occurs when an user register into the application.
   *
   * The event listener method receives a Bag\LoginBundle\Event\UserEvent instance.
   */
  const USER_REGISTER = 'bag_login.user_register';
  
  /**
   * The USER_REGISTRATION_CONFIRMED event occurs when an user confirms his registration.
   *
   * The event listener method receives a Bag\LoginBundle\Event\UserEvent instance.
   */
  const USER_REGISTRATION_CONFIRMED = 'bag_login.user_registration_confirmed';
  
  /**
   * The USER_REQUEST_NEW_PASSWORD event occurs when an user requests a new password.
   *
   * The event listener method receives a Bag\LoginBundle\Event\UserEvent instance.
   */
  const USER_REQUEST_NEW_PASSWORD = 'bag_login.user_request_new_password';
  
  /**
   * The USER_CHANGED_PASSWORD event occurs when an user changes his password.
   *
   * The event listener method receives a Bag\LoginBundle\Event\UserEvent instance.
   */
  const USER_CHANGED_PASSWORD = 'bag_login.user_changed_password';
  
  /** TO BE IMPLEMENTED */
  
  /**
   * The USER_LOGGED_IN event occurs when an user logs into the system.
   *
   * The event listener method receives a Bag\LoginBundle\Event\UserEvent instance.
   */
  const USER_LOGGED_IN = 'bag_login.user_logged_in';
  
  /**
   * The USER_LOGGED_OUT event occurs when an user logs out from the system.
   *
   * The event listener method receives a Bag\LoginBundle\Event\UserEvent instance.
   */
  const USER_LOGGED_OUT = 'bag_login.user_logged_out';
}
