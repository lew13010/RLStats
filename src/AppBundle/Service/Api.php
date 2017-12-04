<?php
/**
 * Created by PhpStorm.
 * User: Lew
 * Date: 15/11/2017
 * Time: 00:22
 */

namespace AppBundle\Service;


use AppBundle\Entity\Joueur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Api
{
    private $em;
    private $key;

    public function __construct(EntityManager $entityManager, ContainerInterface $container)
    {
        $this->em = $entityManager;
        $this->key = $container->getParameter('api_key');
    }

    public function getRanking($url)
    {
        if (preg_match('/id\//', $url) === 1) {
            $split = preg_split('/id\//', $url);
            $id = str_replace('/', '', $split[1]);
        }

        if (preg_match('/profiles\//', $url) === 1) {
            $split = preg_split('/profiles\//', $url);
            $id = str_replace('/', '', $split[1]);
        }

        if (isset($id)) {
            $endpoint = 'https://api.rocketleaguestats.com/v1/player?unique_id=' . $id . '&platform_id=1&apikey='.$this->key;
            try {
                $json = json_decode(file_get_contents($endpoint), true);
                return array('json' => $json, 'steamId' => $id);
            }catch (\Exception $e){
                return false;
            }
        } else {
            return false;
        }
    }

    public function autoUpdate(Joueur $joueur)
    {
        $id = $joueur->getSteamId();

        $endpoint = 'https://api.rocketleaguestats.com/v1/player?unique_id=' . $id . '&platform_id=1&apikey='.$this->key;
        $json = json_decode(file_get_contents($endpoint), true);

        $ranks = $json['rankedSeasons'][6];
        $i=0;

        for ($i = 10; $i <= 13; $i++) {
            $typeId = ($i - 9);
            $type = $this->em->getRepository('AppBundle:Type')->find($typeId);
            $r = $this->em->getRepository('AppBundle:Ranks')->findOneBy(array('joueurs' => $joueur, 'types' => $type));
            if (isset($ranks[$i])) {
                $tier = $this->em->getRepository('AppBundle:Tier')->find($ranks[$i]['tier'] + 1);
                if ($ranks[$i]['tier'] > 0) {
                    $division = $this->em->getRepository('AppBundle:Division')->find($ranks[$i]['division'] + 2);
                } else {
                    $division = $this->em->getRepository('AppBundle:Division')->find(1);
                }
                $rankPoints = $ranks[$i]['rankPoints'];
                $rankPlayed = $ranks[$i]['matchesPlayed'];
            } else {
                $rankPoints = 100;
                $rankPlayed = 0;
                $tier = $this->em->getRepository('AppBundle:Tier')->find(1);
                $division = $this->em->getRepository('AppBundle:Division')->find(1);
            }
            $r->setPoints($rankPoints);
            $r->setNbMatch($rankPlayed);
            $r->setTiers($tier);
            $r->setDivisions($division);
            $this->em->persist($r);
            $this->em->flush();
        }
    }
}

