<?php
/**
 * Created by PhpStorm.
 * User: Lew
 * Date: 15/11/2017
 * Time: 00:22
 */

namespace AppBundle\Service;


use AppBundle\Entity\Joueur;
use DiDom\Document;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Api
{
    private $em;
    private $key;
    private $season;

    public function __construct(EntityManager $entityManager, ContainerInterface $container)
    {
        $this->em = $entityManager;
        $this->key = $container->getParameter('api_key');
        $this->season = $container->getParameter('app')['season'];
    }

    public function getSteam($url)
    {
        if (preg_match('/id\//', $url) === 1) {
            $split = preg_split('/id\//', $url);
            $id = str_replace('/', '', $split[1]);
        }

        if (preg_match('/profiles\//', $url) === 1) {
            $split = preg_split('/profiles\//', $url);
            $id = str_replace('/', '', $split[1]);
        }

        if (isset($id)){
            return $id;
        }else{
            return false;
        }
    }

    public function autoUpdate(Joueur $joueur)
    {
        $id = $joueur->getSteamId();

        $url = 'https://rltracker.pro/profiles/' . $id . '/steam';
        $document = new Document($url, true);

        for ($i = 10; $i <= 13; $i++) {
            $type = $i - 9;
            $r = $this->em->getRepository('AppBundle:Ranks')->findOneBy(array('joueurs' => $joueur, 'types' => $type));

            $div = $this->em->getRepository('AppBundle:Division')->findOneBy(array('division' => $document->find('.season'.$this->season.'_div > .playlist_' . $i . ' > .division > span')[0]->getNode()->nodeValue));
            $tier = $this->em->getRepository('AppBundle:Tier')->findOneBy(array('tierName' => $document->find('.season'.$this->season.'_div > .playlist_' . $i . ' > .tier_name')[0]->getNode()->nodeValue));

            $r->setDivisions($div);
            $r->setTiers($tier);
            $r->setNbMatch($document->find('.season'.$this->season.'_div > .playlist_' . $i . ' > .matches > span')[0]->getNode()->nodeValue);
            $r->setPoints($document->find('.season'.$this->season.'_div > .playlist_' . $i . ' > .rating > span')[0]->getNode()->nodeValue);

            $this->em->persist($r);
            $this->em->flush();
        }
    }
}

