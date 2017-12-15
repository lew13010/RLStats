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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchTournoisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mois', ChoiceType::class, array(
                'placeholder' => '-- Mois --',
                'choices' => array(
                  'Janvier' => '01',
                  'Fevrier' => '02',
                  'Mars' => '03',
                  'Avril' => '04',
                  'Mai' => '05',
                  'Juin' => '06',
                  'Juillet' => '07',
                  'Aout' => '08',
                  'Septembre' => '09',
                  'Octobre' => '10',
                  'Novembre' => '11',
                  'Decembre' => '12',
                ),
                'required' => false,
            ))
            ->add('site', EntityType::class, array(
                'class' => 'AppBundle\Entity\Site',
                'choice_label' => 'name',
                'placeholder' => '-- Tournois --',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                },
                'required' => false,
            ))
            ->add('lineUp', EntityType::class, array(
                'class' => 'AppBundle\Entity\LineUp',
                'choice_label' => 'tag',
                'placeholder' => '-- Line Up --',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.rankMin', 'DESC');
                },
                'required' => false,
            ))
            ->add('categorie', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Type',
                    'choice_label' => 'name',
                    'placeholder' => '-- Categorie --',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orWhere('c.id = 1')
                            ->orWhere('c.id = 2')
                            ->orWhere('c.id = 4')
                            ->orderBy('c.id', 'ASC');
                    },
                    'required' => false,
            ))
            ->add('resultats', EntityType::class, array(
                'class' => 'AppBundle\Entity\Tour',
                'choice_label' => function ($tour){
                    return $tour->getRound();
                },
                'placeholder' => '-- Resultats Min. --',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.id', 'ASC');
                },
                'required' => false,
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Chercher',
                'attr' => array(
                    'class' => 'btn btn-dark',
                )
            ));
    }
}