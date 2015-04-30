<?php
namespace Bag\LoginBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OAuth2\OAuth2ServerException;

class SocialController extends Controller
{
  /**
   * @param Request $request
   * @param String $network
   * 
   * @return type
   */
  public function getSocialTokenAction(Request $request, $network)
  {
    if (!in_array(strtolower($network),User::socialNetworks()))
      throw new OAuth2ServerException('400 Bad Request', 'invalid_request', 'Invalid network parameter or parameter missing');
    
    $server = $this->get('nip_oauth_server.server');
    
    try {
        return $server->grantAccessToken($request, $network);
    } catch (OAuth2ServerException $e) {
        return $e->getHttpResponse();
    }
  }
}
