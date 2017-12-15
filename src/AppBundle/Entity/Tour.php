<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tour
 *
 * @ORM\Table(name="tour")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TourRepository")
 */
class Tour
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
     * @var string
     *
     * @ORM\Column(name="round", type="string", length=255, unique=true)
     */
    private $round;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tournois", mappedBy="tours")
     */
    private $tournois;


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
     * Set round
     *
     * @param string $round
     *
     * @return Tour
     */
    public function setRound($round)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round
     *
     * @return string
     */
    public function getRound()
    {
        return $this->round;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tournois = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tournois
     *
     * @param \AppBundle\Entity\Tournois $tournois
     *
     * @return Tour
     */
    public function addTournois(\AppBundle\Entity\Tournois $tournois)
    {
        $this->tournois[] = $tournois;

        return $this;
    }

    /**
     * Remove tournois
     *
     * @param \AppBundle\Entity\Tournois $tournois
     */
    public function removeTournois(\AppBundle\Entity\Tournois $tournois)
    {
        $this->tournois->removeElement($tournois);
    }

    /**
     * Get tournois
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTournois()
    {
        return $this->tournois;
    }

    public function __toString()
    {
        return $this->round;
    }
}
