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

        if (isset($id)) {
            return $id;
        } else {
            return false;
        }
    }

    public function autoUpdate(Joueur $joueur)
    {
        $id = $joueur->getSteamId();
        $em = $this->em;

        $url = 'https://rocketleague.tracker.network/profile/steam/' . $id;
        $document = new Document($url, true);
        $modes = [1 => 'Ranked Duel 1v1 ', 2 => 'Ranked Doubles 2v2', 3 => 'Ranked Solo Standard 3v3', 4 => 'Ranked Standard 3v3'];
        foreach ($modes as $key => $mode) {
            $r = $em->getRepository('AppBundle:Ranks')->findOneBy(array('joueurs' => $joueur->getId(), 'types' => $key));
            $tr = $document->find('#season-9 tr > td:contains(' . $mode . ')')[0]->parent();

            if ($tr->find('td:nth-child(6) > small') != null) {
                $subString = trim(explode(' ', $tr->find('td:nth-child(6) > small')[0]->getNode()->nodeValue)[0]);
                $nbMatch = intval(str_replace($subString, '', trim(explode(' ', $tr->find('td:nth-child(6)')[0]->getNode()->nodeValue)[0])));
            }
            $nbMatch = intval(trim(explode(' ', $tr->find('td:nth-child(6)')[0]->getNode()->nodeValue)[0]));
            $mmr = intval(str_replace(',', '', trim(explode(' ', $tr->find('td:nth-child(4)')[0]->getNode()->nodeValue)[0])));

            if ($nbMatch < 10) {
                $div = $em->getRepository('AppBundle:Division')->findOneBy(array('id' => 1));
                $tier = $em->getRepository('AppBundle:Tier')->findOneBy(array('id' => 1));
            } else {
                $explodeRank = explode('Division', $tr->find('td:nth-child(2) > small')[0]->getNode()->nodeValue);
                $rank = trim($explodeRank[0]);
                $division = trim($explodeRank[1]);
                $tier = $em->getRepository('AppBundle:Tier')->findOneBy(array('tierName' => $rank));
                $div = $em->getRepository('AppBundle:Division')->findOneBy(array('division' => $division));
            }

            $r->setDivisions($div);
            $r->setNbMatch($nbMatch);
            $r->setPoints($mmr);
            $r->setTiers($tier);
            $em->persist($r);
        }
        $em->flush();
    }
}

