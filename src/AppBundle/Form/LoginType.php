<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class LoginType extends AbstractType
{
  /**
  * {@inheritdoc}
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('email',TextType::class,array(
      'label'=>'Email',
      'constraints' => array(
        new NotBlank(array('message' => 'veuillez remplir le champs')),

      )))

      ->add('password', PasswordType::class,array('label' => 'Password'))
      ->add('submit', SubmitType::class, array(
            'label' => "Valider"))
      ;
    }/**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Users'
        ]);

    }

    /**
    * {@inheritdoc}
    */
    public function getBlockPrefix()
    {
      return null;
    }


  }
