<?php
namespace Bag\LoginBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class UserEvent extends Event
{
  private $user;
  private $isUserNew;
  private $channel;
  private $network;

  public function __construct($user, $isUserNew = false, $channel = null, $network = null)
  {
    $this->user = $user;
    $this->isUserNew = $isUserNew;
    $this->channel = $channel;
    $this->network = $network;
  }

  /**
   * @return $this->user
   */
  public function getUser()
  {
    return $this->user;
  }

  /**
   * @return boolean
   */
  public function isUserNew()
  {
    return $this->isUserNew;
  }

  /**
   * @return string
   */
  public function getChannel()
  {
    return $this->channel;
  }

  /**
   * @return string
   */
  public function getNetwork()
  {
    return $this->network;
  }
}
