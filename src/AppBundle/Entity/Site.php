<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="site")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SiteRepository")
 */
class Site
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tournois", mappedBy="sites")
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
     * @return Site
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

    public function __toString()
    {
        return $this->name;
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
     * @return Site
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
