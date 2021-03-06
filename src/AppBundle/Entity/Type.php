<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeRepository")
 */
class Type
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ranks", mappedBy="types")
     */
    private $ranks;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tournois", mappedBy="types")
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
     * Set name
     *
     * @param string $name
     *
     * @return Type
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ranks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add rank
     *
     * @param \AppBundle\Entity\Ranks $rank
     *
     * @return Type
     */
    public function addRank(\AppBundle\Entity\Ranks $rank)
    {
        $this->ranks[] = $rank;

        return $this;
    }

    /**
     * Remove rank
     *
     * @param \AppBundle\Entity\Ranks $rank
     */
    public function removeRank(\AppBundle\Entity\Ranks $rank)
    {
        $this->ranks->removeElement($rank);
    }

    /**
     * Get ranks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRanks()
    {
        return $this->ranks;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add tournois
     *
     * @param \AppBundle\Entity\Tournois $tournois
     *
     * @return Type
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
}
