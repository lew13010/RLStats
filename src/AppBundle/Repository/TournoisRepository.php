<?php

namespace AppBundle\Repository;

/**
 * TournoisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TournoisRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSearch($mois, $annee, $lineUp, $site, $categorie, $resultats)
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->select('t', 'l', 's')
            ->leftJoin('t.lineUps', 'l')
            ->leftJoin('t.sites', 's')
            ->orderBy('t.dateTournois', 'DESC')
        ;

        if ($annee != false && $mois != false) {
            $date = new \DateTime($annee . '-' . $mois . '-01');
            $dateStart = $date->format('Y-m-d');
            $dateEnd = $date->format('Y-m-t');
        }

        if ($annee != false && $mois == false) {
            $firstDate = new \DateTime($annee . '-01-01');
            $lastDate = new \DateTime($annee . '-12-31');
            $dateStart = $firstDate->format('Y-m-d');
            $dateEnd = $lastDate->format('Y-m-d');
        }

        if ($annee == false && $mois != false) {
            $now = new \DateTime();
            $year = $now->format('Y');
            $date = new \DateTime($year . '-' . $mois . '-01');
            $dateStart = $date->format('Y-m-d');
            $dateEnd = $date->format('Y-m-t');
        }

        if ($annee == false && $mois == false) {
            $date = new \DateTime('2017-01-01');
            $now = new \DateTime();
            $dateStart = $date->format('Y-m-d');
            $dateEnd = $now->format('Y-m-d');
        }

        $qb
            ->andWhere('t.dateTournois >= :dateStart')
            ->andWhere('t.dateTournois <= :dateEnd')
            ->setParameter(':dateStart', $dateStart)
            ->setParameter(':dateEnd', $dateEnd)
        ;

        if ($lineUp != false) {
            $qb
                ->andWhere('l.id = :lineUp')
                ->setParameter(':lineUp', $lineUp)
            ;
        }

        if ($site != false) {
            $qb
                ->andWhere('s.id = :site')
                ->setParameter(':site', $site)
            ;
        }

        if ($categorie != false) {
            $qb
                ->andWhere('t.types = :categorie')
                ->setParameter(':categorie', $categorie)
            ;
        }

        if ($resultats != false) {
            $qb
                ->andWhere('t.tours >= :resultats')
                ->setParameter(':resultats', $resultats)
            ;
        }


        return $qb->getQuery()->getResult();

    }
}
