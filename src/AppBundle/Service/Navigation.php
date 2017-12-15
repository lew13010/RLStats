<?php
/**
 * Created by PhpStorm.
 * User: Lew
 * Date: 11/12/2017
 * Time: 13:01
 */

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Navigation
{
    private $em;
    private $container;

    public function __construct(EntityManager $entityManager, ContainerInterface $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }

    public function lineUps()
    {
        return $this->em->getRepository('AppBundle:LineUp')->findBy(array(), array('rankMin' => 'desc'));
    }

    public function sites()
    {
        return $this->em->getRepository('AppBundle:Site')->findBy(array(), array('id' => 'asc'));
    }
}