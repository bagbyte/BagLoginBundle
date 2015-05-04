<?php
namespace Bag\LoginBundle\Controller;

/**
 *  @author Sabino Papagna
 *  @version  1.0
 */
class DefaultController extends Controller
{
  /**
   *  The action displays a page not found static page.
   *  
   *  This action simply display a static page defined in <strong>bag_login.views.page_not_found</strong>
   */
  public function pageNotFoundAction()
  {
    $view = $this->container->getParameter('bag_login.views');
    
    return $this->render($view['page_not_found']);
  }
}
