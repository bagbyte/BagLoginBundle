<?php
namespace Bag\LoginBundle\Controller;
  
use Mia\CoreBundle\Entity\User;

use Bag\LoginBundle\Form\Type\EmailType;
use Bag\LoginBundle\Event\UserEvent;
use Bag\LoginBundle\BagLoginEvents;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *  @author Sabino Papagna
 *  @version  1.0
 */
class RegistrationController extends Controller
{
  /**
   *  This action is responsible to handle the form which allows the user
   *  to request a copy of the registration email containing the activation url.
   *  
   *  Dispatch <strong>BagLoginEvents::USER_REQUEST_CONFIRMATION_EMAIL</strong> event
   *  
   *  In case of success, redirect the user to <strong>bag_login_web_request_activation_email_completed</strong>
   */
  public function requestActivationEmailAction()
  {
    $form = $this->createForm(new EmailType(), null);
  
    $options = array();

    if ($this->getRequest()->isMethod('POST')) {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail($form->get('email')->getData());
    
        if ($user != null) {
          // dispatch event
          $this->container->get('event_dispatcher')->dispatch(BagLoginEvents::USER_REQUEST_CONFIRMATION_EMAIL, new UserEvent($user, true, 'web'));
        
          return $this->redirect($this->generateUrl('bag_login_web_request_activation_email_completed'));
        }
        else
          $options['error'] = $this->get('translator')->trans('message.email_not_found');
      }
    }
  
    $options['form'] = $form->createView();
    
    $view = $this->container->getParameter('bag_login.views');
    return $this->render($view['activation_email_request'], $options);
  }

  /**
   *  When the user request a new activation email,
   *  after succesfully filling the form, he is redirected to this page.
   *  
   *  This action simply display a static page defined in <strong>bag_login.views.activation_email_request_completed</strong>
   */
  public function requestActivationEmailCompletedAction()
  {
    $view = $this->container->getParameter('bag_login.views');
    
    return $this->render($view['activation_email_request_completed']);
  }
  
  /**
   *  This action is responsible to handle the registration form.
   *  The view containing the form can be customizable with the 
   *  configuration parameter <strong>bag_login.views.registration</strong>
   *  
   *  Dispatch <strong>BagLoginEvents::USER_REGISTER</strong> event
   *  
   *  In case of success, redirect the user to <strong>bag_login_web_registration_done</strong>
   */
  public function registerAction(Request $request)
  {
    $user = new User();

    $formSettings = $this->gasParameter('bag_login.form');
    $registrationType = $formSettings['type']['registration'];
    
    $form = $this->createForm(new $registrationType(), $user);

    if ($this->getRequest()->isMethod('POST')) {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $user->setUsername($user->getEmail());
        
        $tokenGenerator = $this->get('fos_user.util.token_generator');
        $user->setConfirmationToken($tokenGenerator->generateToken());
        
        $userManager = $this->get('fos_user.user_manager');
        $userManager->updateUser($user);

        // dispatch event
        $this->container->get('event_dispatcher')->dispatch(BagLoginEvents::USER_REGISTER, new UserEvent($user, true, 'web'));
        
        return $this->redirect($this->generateUrl('bag_login_web_registration_completed'));
      }
    }
    
    $view = $this->container->getParameter('bag_login.views');
    return $this->render($view['registration'], array('form' => $form->createView()));
  }

  /**
   *  After submitting the registration form,
   *  the user is redirected to a confirmation page.
   *  
   *  This action simply display a static page defined in <strong>bag_login.views.registration_completed</strong>
   */
  public function registrationCompletedAction()
  {
    $view = $this->container->getParameter('bag_login.views');
    $settings = $this->container->getParameter('bag_login.email');
    
    return $this->render($view['registration_completed'], array('sendActivationEmail' => $settings['require_account_verification']));
  }
  
  /**
   *  This action is responsible to activate a new user account,
   *  it checks if the token passed in the URL is correct for the user.
   *  If the token is valid, the related account is activated.
   *  
   *  The view containing the form can be customizable with the 
   *  configuration parameter <strong>bag_login.views.registration</strong>
   *  
   *  Dispatch <strong>FOSUserEvents::REGISTRATION_CONFIRM</strong> event
   *  Dispatch <strong>BagLoginEvents::USER_REGISTRATION_CONFIRMED</strong> event
   *  Dispatch <strong>FOSUserEvents::USER_REGISTRATION_CONFIRMED</strong> event
   *  
   *  In case of failuer, redirect the user to <strong>bag_login_web_page_not_found</strong>
   *  In case of success, redirect the user to <strong>bag_login_web_registration_done</strong>
   */
  public function accountActivationAction(Request $request, $token)
  {
    $userManager = $this->container->get('fos_user.user_manager');

    $user = $userManager->findUserByConfirmationToken($token);

    if (null === $user)
      return $this->redirect($this->generateUrl('bag_login_web_page_not_found'));

    $user->setConfirmationToken(null);
    $user->setEnabled(true);

    $this->container->get('event_dispatcher')->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, new GetResponseUserEvent($user, $request));

    $userManager->updateUser($user);

    $this->container->get('event_dispatcher')->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, null));
    $this->container->get('event_dispatcher')->dispatch(BagLoginEvents::USER_REGISTRATION_CONFIRMED, new UserEvent($user, true, 'web'));

    return $this->redirect($this->generateUrl('bag_login_web_registration_done'));
  }

  /**
   *  After activating the account, the user is redirected 
   *  to a confirmation page.
   *  
   *  This action simply display a static page defined in <strong>bag_login.views.account_activated</strong>
   */
  public function accountActivationCompletedAction()
  {
    $view = $this->container->getParameter('bag_login.views');
    
    return $this->render($view['account_activated']);
  }
}
