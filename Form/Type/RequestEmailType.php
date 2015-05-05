<?php
namespace Bag\LoginBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmailType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('email','email', array(
                    'required' => true,
                    'mapped' => false,
                    'label' => 'form.label.email_required',
                    'constraints' => array(
                      new NotBlank(array('message' => 'validation.not_blank')),
                      new Email(array('message' => 'validation.email'))
                    )
    ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => null,
      'csrf_protection' => true
    ));
  }

  public function getName()
  {
    return 'email';
  }
}
