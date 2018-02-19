<?php
/**
 * Created by PhpStorm.
 * User: Lew
 * Date: 21/11/2017
 * Time: 09:12
 */

namespace AppBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchJoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rankMin', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Tier',
                    'choice_label' => 'tierName',
                    'placeholder' => '-- Rank Min --',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->orderBy('t.id', 'ASC');
                    },
                    'required' => true,
                )
            )
            ->add('rankMax', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Tier',
                    'choice_label' => 'tierName',
                    'placeholder' => '-- Rank Max --',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->orderBy('t.id', 'ASC');
                    },
                    'required' => true,
                )
            )
            ->add('categorie', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Type',
                    'choice_label' => 'name',
                    'placeholder' => '-- Categorie --',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->orderBy('t.id', 'ASC');
                    },
                    'required' => false,
                )
            )
            ->add('submit', SubmitType::class, array(
                'label' => 'Chercher',
                'attr' => array(
                    'class' => 'btn btn-dark',
                )
            ));
    }
}