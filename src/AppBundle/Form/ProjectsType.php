<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Entity\Teams;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProjectsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('teams', EntityType::class, [  'class' => Teams::class,
        	'multiple' => false, // permet de faire des choix multiples, cocher plusieurs
            'expanded' =>true, // passer les input en checkbox (beau)
            'choice_label' => 'name', // afficher category.name devant chaque checkbox

            // si on cherche à lier la table dominée à la dominante (au sens des jointures) - Pour enregistrer relation dans le sens inverse (lier des produits à des catégories car catégories est table dominante (possède annotation inversed by)) rajouter ligne suivante
            'by_reference' => true
       	]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Projects'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_projects';
    }


}
