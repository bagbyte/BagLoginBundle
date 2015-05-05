<?php
namespace Bag\LoginBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BaseType extends AbstractType
{
  protected $container;

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   */
  public function __construct(Container $container)
  {
    $this->container = $container;
  }
}
