<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class TournoisType extends AbstractType
{

    private $em;
    private $username;

    public function __construct(EntityManager $entityManager, ContainerInterface $container)
    {
        $this->em = $entityManager;
        $this->username = $container->get('security.token_storage')->getToken()->getUser()->getUsername();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateTournois', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Date du tournois'
            ))
            ->add('sites', EntityType::class, array(
                'class' => 'AppBundle\Entity\Site',
                'choice_label' => 'name',
                'label' => 'Site du tournois'
            ))
            ->add('types', EntityType::class, array(
                'class' => 'AppBundle\Entity\Type',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('type')
                        ->where('type.id = 1')
                        ->orWhere('type.id = 2')
                        ->orWhere('type.id = 4')
                        ->orderBy('type.id', 'ASC');
                },
                'label' => 'Type de tournois'
            ))
            ->add('tours', EntityType::class, array(
                'class' => 'AppBundle\Entity\Tour',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.id', 'ASC');
                },
                'label' => 'Resultats'
            ))
            ->add('commentaires');

        if ($this->username != 'admin') {
            $builder->add('lineUps', EntityType::class, array(
                'class' => 'AppBundle\Entity\LineUp',
                'query_builder' => function (EntityRepository $er) {
                    $lu = $this->em->getRepository('AppBundle:LineUp')->findOneBy(array('tag' => $this->username))->getId();
                    return $er->createQueryBuilder('l')
                        ->where('l.id = :id')
                        ->setParameter('id', $lu);
                },
                'choice_label' => 'tag',
                'label' => 'Line Up'
            ));
        }else{
            $builder->add('lineUps', EntityType::class, array(
                'class' => 'AppBundle\Entity\LineUp',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.tag', 'ASC');
                },
                'choice_label' => 'tag',
                'label' => 'Line Up'
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tournois'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tournois';
    }


}
