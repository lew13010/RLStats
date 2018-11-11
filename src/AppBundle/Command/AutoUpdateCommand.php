<?php
/**
 * Created by PhpStorm.
 * User: Lew
 * Date: 15/08/2017
 * Time: 10:50
 */

namespace AppBundle\Command;


use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AutoUpdateCommand extends Command implements ContainerAwareInterface
{
    private $container;
    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

    protected function configure()
    {
        $this
            ->setName('app:update')
            ->setDescription('Auto Update ranks')
            ->setHelp('This command allows you to update the ranks')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $joueurs = $em->getRepository('AppBundle:Joueur')->findAll();
        $date = new \DateTime('NOW');
        foreach ($joueurs as $joueur) {
            try{
                $this->container->get('app.service.api')->autoUpdate($joueur);
                $joueur->setLastUpdate($date);
                $em->persist($joueur);
                usleep(500000);
            }catch (\Exception $exception){
            }
        }
        $em->flush();
    }
}