<?php
namespace Bag\LoginBundle;

class BagLoginFunctions
{
  private $container;
  
  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }
  
  /**
   * @return array of strings containing the available networks 
   * setup by the user in the configuration <strong>bag_login.social_network<strong>
   */
  public function getSocialNetworks() {
    $networks = array();
    
    $socialNetworks = $this->container->gasParameter('bag_login.social_network');
    $allNetworks = $this->container->gasParameter('bag_login.supported_social_networks');
    
    foreach ($allNetworks as $current) {
      if (in_array($current, $socialNetworks))
        $networks[] = $current;
    }
    
    return $networks;
  }
}
