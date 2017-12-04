<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Ranks
 *
 * @ORM\Table(
 *     name="ranks",
 *     uniqueConstraints={
 *          @UniqueConstraint(name="unique_multiple", columns={"joueurs_id", "types_id"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RanksRepository")
 */
class Ranks
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Joueur", inversedBy="ranks", cascade={"persist", "remove"})
     */
    private $joueurs;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type", inversedBy="ranks")
     */
    private $types;

    /**
     * @ORM\Column(name="points", type="integer", nullable=false)
     */
    private $points;

    /**
     * @ORM\Column(name="nb_match", type="integer", nullable=false)
     */
    private $nbMatch;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tier")
     */
    private $tiers;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Division")
     */
    private $divisions;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return Ranks
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set nbMatch
     *
     * @param integer $nbMatch
     *
     * @return Ranks
     */
    public function setNbMatch($nbMatch)
    {
        $this->nbMatch = $nbMatch;

        return $this;
    }

    /**
     * Get nbMatch
     *
     * @return integer
     */
    public function getNbMatch()
    {
        return $this->nbMatch;
    }

    /**
     * Set joueurs
     *
     * @param \AppBundle\Entity\Joueur $joueurs
     *
     * @return Ranks
     */
    public function setJoueurs(\AppBundle\Entity\Joueur $joueurs = null)
    {
        $this->joueurs = $joueurs;

        return $this;
    }

    /**
     * Get joueurs
     *
     * @return \AppBundle\Entity\Joueur
     */
    public function getJoueurs()
    {
        return $this->joueurs;
    }

    /**
     * Set types
     *
     * @param \AppBundle\Entity\Type $types
     *
     * @return Ranks
     */
    public function setTypes(\AppBundle\Entity\Type $types = null)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get types
     *
     * @return \AppBundle\Entity\Type
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Set tiers
     *
     * @param \AppBundle\Entity\Tier $tiers
     *
     * @return Ranks
     */
    public function setTiers(\AppBundle\Entity\Tier $tiers = null)
    {
        $this->tiers = $tiers;

        return $this;
    }

    /**
     * Get tiers
     *
     * @return \AppBundle\Entity\Tier
     */
    public function getTiers()
    {
        return $this->tiers;
    }

    /**
     * Set divisions
     *
     * @param \AppBundle\Entity\Division $divisions
     *
     * @return Ranks
     */
    public function setDivisions(\AppBundle\Entity\Division $divisions = null)
    {
        $this->divisions = $divisions;

        return $this;
    }

    /**
     * Get divisions
     *
     * @return \AppBundle\Entity\Division
     */
    public function getDivisions()
    {
        return $this->divisions;
    }
}
