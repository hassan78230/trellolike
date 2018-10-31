<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Email;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use AppBundle\Entity\Tags;

class UsersType extends AbstractType
{
  /**
  * {@inheritdoc}
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('firstname',TextType::class,array(
      'label'=>'firstname',
      'constraints' => array(
        new NotBlank(array('message' => 'veuillez remplir le champs')),
        new Regex(array('pattern' => '/^[a-zA-Z-\'éèàê]+$/',
        'message' => 'veuillez rentrer un nom valide')),
        new Length(array('max' => 100,
        'min' => 2,
        'maxMessage' => "Le nom est trop long, < 100 lettres",
        'minMessage' => "Le nom est trop court, > 2 lettres"))
      )))
      ->add('lastname', TextType::class,array(
        'label' => 'lastname',
        'constraints' => array(
        new NotBlank(array('message' => 'veuillez remplir le champs')),
        new Regex(array('pattern' => '/^[a-zA-Z-\'éèàê]+$/',
         'message' => 'veuillez rentrer un nom valide')),
        new Length(array('max' => 100,
         'min' => 2,
         'maxMessage' => "Le nom est trop long, < 100 lettres",
         'minMessage' => "Le nom est trop court, > 2 lettres"))
      )))
      ->add('email', EmailType::class,array('label' => 'email'))
      ->add('password', PasswordType::class,array('label' => 'Password',
        'constraints' => array(
        new NotBlank(array('message' => 'veuillez remplir le champs')),
        new Regex(array('pattern' => '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{8,})$/',
         'message' => 'veuillez rentrer un mot de passe valide'))
      )))
      ->add('tags', EntityType::class, [  'class' => Tags::class,
        'multiple' => true,
        'expanded' =>true,
        'choice_label' => 'name',
        'by_reference' => false
      ]);

    }/**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'AppBundle\Entity\Users'
      ));
    }

    /**
    * {@inheritdoc}
    */
    public function getBlockPrefix()
    {
      return 'appbundle_users';
    }


  }
