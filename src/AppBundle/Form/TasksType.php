<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Tags;
use AppBundle\Entity\Users;

class TasksType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('title')
              ->add('description')
              ->add('status', ChoiceType::class, array(
                'choices'  => array(
                  'En cours' => 'wip',
                  'a faire' => 'todo',
                  'fait' => 'done')))
              ->add('duration')
              ->add('startdate' , DateType::class)
              ->add('enddate', DateType::class)
              ->add('tasktags', EntityType::class, [  'class' => Tags::class,
                  'multiple' => true,
                  'expanded' =>true,
                  'choice_label' => 'name',
                  'by_reference' => true
                  ])
              ->add('userstask', EntityType::class, [  'class' => Users::class,
                  'multiple' => true,
                  'expanded' =>true,
                  'choice_label' => 'email',
                  'by_reference' => true
                  ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tasks'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tasks';
    }


}
