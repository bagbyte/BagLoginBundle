<?php
namespace Bag\LoginBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\Controller\SecurityController;

/**
 *  @author Sabino Papagna
 *  @version  1.0
 */
class SecurityController extends SecurityController
{
  /**
   *  This action is responsible to handle the login form.
   *  
   *  The login check is performed against <strong>bag_login_web_login_check</strong>
   */
  public function loginAction(Request $request)
  {
    /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
    $session = $request->getSession();

    // get the error if any (works with forward and redirect -- see below)
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    } else {
      $error = '';
    }

    if ($error) {
      // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
      $error = $error->getMessage();
    }
    // last username entered by the user
    $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

    $csrfToken = $this->container->has('form.csrf_provider')
      ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
      : null;

    $view = $this->container->getParameter('bag_login.views');
    return $this->container->get('templating')->renderResponse($view['login'], array(
      'last_username' => $lastUsername,
      'error'         => $error,
      'csrf_token'    => $csrfToken,
    ));
  }
}
