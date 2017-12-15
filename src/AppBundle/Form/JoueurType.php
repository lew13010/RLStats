<?php

namespace AppBundle\Form;

use AppBundle\Entity\LineUp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoueurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, array(
                'required' => true
            ))
            ->add('url', TextType::class, array(
                'required' => true
            ))
            ->add('functions', EntityType::class, array(
                    'label' => 'Fonction',
                    'class' => 'AppBundle\Entity\Fonction',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                )
            )
            ->add('lineUp', EntityType::class, array(
                    'class' => 'AppBundle\Entity\LineUp',
                    'choice_label' => 'tag',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                )
            )
            ->add('comment', TextType::class, array(
                'required' => false,
            ))
            ->add('association', CheckboxType::class, array(
                'label' => 'Membre de l\'association',
                'required' => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Joueur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_joueur';
    }


}
