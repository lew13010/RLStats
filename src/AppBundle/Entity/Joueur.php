<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Joueur
 *
 * @ORM\Table(name="joueur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JoueurRepository")
 */
class Joueur
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
     * @ORM\Column(name="pseudo", type="string", length=255)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="fonction", type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LineUp", inversedBy="joueurs")
     */
    private $lineUp;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="steam_id", type="string", length=255, nullable=true)
     */
    private $steamId;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ranks", mappedBy="joueurs", cascade={"persist", "remove"})
     */
    private $ranks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ranks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Joueur
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Joueur
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set fonction
     *
     * @param string $fonction
     *
     * @return Joueur
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set lineUp
     *
     * @param \AppBundle\Entity\LineUp $lineUp
     *
     * @return Joueur
     */
    public function setLineUp(\AppBundle\Entity\LineUp $lineUp = null)
    {
        $this->lineUp = $lineUp;

        return $this;
    }

    /**
     * Get lineUp
     *
     * @return \AppBundle\Entity\LineUp
     */
    public function getLineUp()
    {
        return $this->lineUp;
    }

    /**
     * Add rank
     *
     * @param \AppBundle\Entity\Ranks $rank
     *
     * @return Joueur
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
        return $this->pseudo;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Joueur
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set steamId
     *
     * @param string $steamId
     *
     * @return Joueur
     */
    public function setSteamId($steamId)
    {
        $this->steamId = $steamId;

        return $this;
    }

    /**
     * Get steamId
     *
     * @return string
     */
    public function getSteamId()
    {
        return $this->steamId;
    }
}
