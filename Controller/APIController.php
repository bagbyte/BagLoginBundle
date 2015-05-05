<?php
namespace Bag\LoginBundle\Controller;

use Bag\LoginBundle\Event\UserEvent;
use Bag\LoginBundle\BagLoginEvents;
use Bag\LoginBundle\Form\Type\EmailType;
use Bag\LoginBundle\BagLoginFunctions;

use FOS\RestBundle\View\View;
use OAuth2\OAuth2ServerException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *  @author Sabino Papagna
 *  @version  1.0
 */
class APIController extends Controller
{
  /**
   * @param Request $request
   * @param String $network
   * 
   * Get parameter: String <strong>client_id</strong>
   * Get parameter: String <strong>client_secret</strong>
   * 
   * @return type
   */
  public function getSocialTokenAction(Request $request, $network)
  {
    if (!in_array(strtolower($network), $this->container->get('bag_login.functions')->getSocialNetworks()))
      throw new OAuth2ServerException('400 Bad Request', 'invalid_request', 'Invalid network parameter or parameter missing');
    
    $server = $this->get('bag_login.server');
    
    try {
      return $server->grantAccessToken($request, $network);
    } catch (OAuth2ServerException $e) {
      return $e->getHttpResponse();
    }
  }
  
  /**
   *  This action is responsible to handle the registration.
   *  
   *  Dispatch <strong>BagLoginEvents::USER_REGISTER</strong> event
   *  
   *  @return 200 in case of success.
   *  @return 400 in case the data sent are not correct or some required data is missing.
   *  @return 409 in case the email is already registered.
   */
  public function registerAction(Request $request)
  {
    $user = new User();

    $formSettings = $this->gasParameter('bag_login.form');
    $registrationType = $formSettings['type']['registration'];
    
    $form = $this->createForm(new $registrationType(), $user);

    $form->bind($this->getRequest());
    
    // Check this outside the $form->isValid() check in order to return
    // a different status code.
    $oldUser = $this->get('fos_user.user_manager')->findUserByEmail($form->get('email')->getData());
    if ($oldUser != null) {
      $view = View::create(null, 409);
      return $this->get('fos_rest.view_handler')->handle($view);
    }

    if ($form->isValid()) {
      $user->setUsername($user->getEmail());
      
      $tokenGenerator = $this->get('fos_user.util.token_generator');
      $user->setConfirmationToken($tokenGenerator->generateToken());
      
      $userManager = $this->get('fos_user.user_manager');
      $userManager->updateUser($user);

      // dispatch event
      $this->container->get('event_dispatcher')->dispatch(BagLoginEvents::USER_REGISTER, new UserEvent($user, true, 'web'));
      
      $view = View::create(null, 200);
      return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    $view = View::create($form, 400);
    return $this->get('fos_rest.view_handler')->handle($view);
  }
  
  /**
   *  This action is responsible to handle the request of 
   *  the registration email containing the activation url.
   *  
   *  Dispatch <strong>BagLoginEvents::USER_REQUEST_CONFIRMATION_EMAIL</strong> event
   *  
   *  @return 200 in case of success.
   *  @return 400 in case the data sent are not correct or some required data is missing.
   *  @return 412 in case the email doesn't match any user.
   */
  public function requestActivationEmailAction()
  {
    $form = $this->createForm(new EmailType(), null);
  
    $form->bind($this->getRequest());

    if ($form->isValid()) {
      $userManager = $this->get('fos_user.user_manager');
      $user = $userManager->findUserByEmail($form->get('email')->getData());
  
      if ($user == null) {
        $view = View::create(null, 412);
        return $this->get('fos_rest.view_handler')->handle($view);
      }
      
      // dispatch event
      $this->container->get('event_dispatcher')->dispatch(BagLoginEvents::USER_REQUEST_CONFIRMATION_EMAIL, new UserEvent($user, true, 'web'));
    
      $view = View::create(null, 200);
      return $this->get('fos_rest.view_handler')->handle($view);
    }
  
    $view = View::create($form, 400);
    return $this->get('fos_rest.view_handler')->handle($view);
  }
  
  /**
   *  This action is responsible to handle the request of a new password. 
   *  The system will send an email to the user's email address
   *  with the link for setting the new password.
   *  
   *  Dispatch <strong>BagLoginEvents::USER_REQUEST_NEW_PASSWORD</strong> event
   *  
   *  @return 200 in case of success.
   *  @return 400 in case the data sent are not correct or some required data is missing.
   *  @return 409 in case the email doesn't match any user.
   *  @return 412 in case the email doesn't match any user.
   */
  public function requestNewPasswordAction()
  {
    $form = $this->createForm(new EmailType(), null);
    
    $form->bind($this->getRequest());

    if ($form->isValid()) {
      $userManager = $this->get('fos_user.user_manager');
      $user = $userManager->findUserByEmail($form->get('email')->getData());
  
      if (null === $user) {
        $view = View::create(null, 412);
        return $this->get('fos_rest.view_handler')->handle($view);
      }

      if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
        return $this->render($view['error'], array('error' => $this->get('translator')->trans('message.password_already_requested'), 'form' => $form->createView()));
      }

      if (null === $user->getConfirmationToken()) {
        /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
        $tokenGenerator = $this->container->get('fos_user.util.token_generator');
        $user->setConfirmationToken($tokenGenerator->generateToken());
      }

      // dispatch event
      $this->container->get('event_dispatcher')->dispatch(BagLoginEvents::USER_REQUEST_NEW_PASSWORD, new UserEvent($user, false, 'web'));
      
      $user->setPasswordRequestedAt(new \DateTime());
      $this->container->get('fos_user.user_manager')->updateUser($user);

      return $this->redirect($this->generateUrl('bag_login_web_password_reset_done'));
    }
  
    $view = View::create($form, 400);
    return $this->get('fos_rest.view_handler')->handle($view);
  }
}
