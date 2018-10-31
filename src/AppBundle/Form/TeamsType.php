<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Users;
use AppBundle\Entity\Teams;

class TeamsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('users', EntityType::class, [  'class' => Users::class,
        	'multiple' => true, // permet de faire des choix multiples, cocher plusieurs
            'expanded' =>true, // passer les input en checkbox (beau)
            'choice_label' => 'email', // afficher category.name devant chaque checkbox

            // si on cherche à lier la table dominée à la dominante (au sens des jointures) - Pour enregistrer relation dans le sens inverse (lier des produits à des catégories car catégories est table dominante (possède annotation inversed by)) rajouter ligne suivante
            'by_reference' => false
       	])
        ->add('submit', SubmitType::class, array('label' => 'Create Team'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Teams'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_teams';
    }


}
