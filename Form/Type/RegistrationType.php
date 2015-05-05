<?php
namespace Bag\LoginBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends BaseType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('email', 'email', array('required' => true));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $userClass = $this->container->getParameter('bag_login.user_class');
    $resolver->setDefaults(array(
      'data_class' => $userClass,
      'csrf_protection' => true
    ));
  }

  public function getName()
  {
    return 'registration';
  }
}
