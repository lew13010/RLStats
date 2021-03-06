<?php

namespace AppBundle\Repository;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SiteRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllWithAll()
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->select('s', 't', 'l')
            ->leftJoin('s.tournois', 't')
            ->leftJoin('t.lineUps', 'l')
            ->orderBy('t.dateTournois', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }
}
