<?php
namespace Bag\LoginBundle\Controller;

use Bag\LoginBundle\Event\UserEvent;
use Bag\LoginBundle\BagLoginEvents;

use Bag\LoginBundle\Form\Type\EmailType;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;

/**
 *  @author Sabino Papagna
 *  @version  1.0
 */
class PasswordController extends Controller
{
  /**
   *  This action is responsible to handle the form which allows the user
   *  to request a new password. The system will send an email to the user's email address
   *  with the link for setting the new password.
   *  
   *  Dispatch <strong>BagLoginEvents::USER_REQUEST_NEW_PASSWORD</strong> event
   *  
   *  In case of success, redirect the user to <strong>bag_login_web_password_reset_done</strong>
   */
  public function requestNewAction()
  {
    $view = $this->container->getParameter('bag_login.views');
    
    $form = $this->createForm(new EmailType(), null);
    
    if ($this->getRequest()->isMethod('POST')) {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail($form->get('email')->getData());
    
        if (null === $user) {
          return $this->render($view['request_new_password'], array('error' => $this->get('translator')->trans('message.email_not_found'), 'form' => $form->createView()));
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
    }
  
    return $this->render($view['request_new_password'], array('form' => $form->createView()));
  }

  /**
   *  When the user request a new password,
   *  after succesfully filling the form, he is redirected to this page.
   *  
   *  This action simply display a static page defined in <strong>bag_login.views.request_new_password_completed</strong>
   */
  public function requestCompletedAction()
  {
    $view = $this->container->getParameter('bag_login.views');
    
    return $this->render($view['request_new_password_completed']);
  }
  
  /**
   *  This action is responsible to handle the form which allows the user
   *  to change his password.
   *  
   *  Dispatch <strong>FOSUserEvents::RESETTING_RESET_INITIALIZE</strong> event
   *  Dispatch <strong>FOSUserEvents::RESETTING_RESET_SUCCESS</strong> event
   *  Dispatch <strong>FOSUserEvents::RESETTING_RESET_COMPLETED</strong> event
   *  Dispatch <strong>BagLoginEvents::USER_CHANGED_PASSWORD</strong> event
   *  
   *  In case of success, redirect the user to <strong>bag_login_web_change_password_done</strong>
   */
  public function changeAction(Request $request, $token)
  {
    /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
    $formFactory = $this->container->get('fos_user.resetting.form.factory');
    /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
    $userManager = $this->container->get('fos_user.user_manager');
    /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    $dispatcher = $this->container->get('event_dispatcher');

    $user = $userManager->findUserByConfirmationToken($token);

    if (null === $user) {
      throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
    }

    $event = new GetResponseUserEvent($user, $request);
    $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

    if (null !== $event->getResponse()) {
      return $event->getResponse();
    }

    $form = $formFactory->createForm();
    $form->setData($user);

    if ('POST' === $request->getMethod()) {
      $form->bind($request);

      if ($form->isValid()) {
        $event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
          $url = $this->container->get('router')->generate('bag_login_web_change_password_done');
          $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
        
        // dispatch event
        $this->container->get('event_dispatcher')->dispatch(BagLoginEvents::USER_CHANGED_PASSWORD, new UserEvent($user, false, 'web'));

        return $response;
      }
    }

    $view = $this->container->getParameter('bag_login.views');
    
    return $this->render($view['change_password'], array(
      'token' => $token,
      'form' => $form->createView(),
    ));
  }
  
  /**
   *  When the user change his password,
   *  after succesfully filling the form, he is redirected to this page.
   *  
   *  This action simply display a static page defined in <strong>bag_login.views.change_password_completed</strong>
   */
  public function requestPasswordDoneAction()
  {
    $view = $this->container->getParameter('bag_login.views');
    
    return $this->render($view['change_password_completed']);
  }

  /**
   * Get the truncated email displayed when requesting the resetting.
   *
   * The default implementation only keeps the part following @ in the address.
   *
   * @param \FOS\UserBundle\Model\UserInterface $user
   *
   * @return string
   */
  protected function getObfuscatedEmail(UserInterface $user)
  {
    $email = $user->getEmail();
    if (false !== $pos = strpos($email, '@')) {
      $email = '...' . substr($email, $pos);
    }

    return $email;
  }
}
