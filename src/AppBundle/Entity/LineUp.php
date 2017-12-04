<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * LineUp
 *
 * @ORM\Table(name="line_up")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LineUpRepository")
 */
class LineUp
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
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255, unique=true)
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Joueur", mappedBy="lineUp")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $joueurs;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->joueurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return LineUp
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return LineUp
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Add joueur
     *
     * @param \AppBundle\Entity\Joueur $joueur
     *
     * @return LineUp
     */
    public function addJoueur(\AppBundle\Entity\Joueur $joueur)
    {
        $this->joueurs[] = $joueur;

        return $this;
    }

    /**
     * Remove joueur
     *
     * @param \AppBundle\Entity\Joueur $joueur
     */
    public function removeJoueur(\AppBundle\Entity\Joueur $joueur)
    {
        $this->joueurs->removeElement($joueur);
    }

    /**
     * Get joueurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJoueurs()
    {
        return $this->joueurs;
    }

    public function __toString()
    {
        return $this->getTag();
    }
}
