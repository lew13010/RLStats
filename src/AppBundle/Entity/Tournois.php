<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tournois
 *
 * @ORM\Table(name="tournois")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TournoisRepository")
 */
class Tournois
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
     * @var date
     *
     * @ORM\Column(name="date_tournois", type="date")
     */
    private $dateTournois;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Site", inversedBy="tournois")
     */
    private $sites;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LineUp", inversedBy="tournois")
     */
    private $lineUps;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tour", inversedBy="tournois")
     */
    private $tours;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type", inversedBy="tournois")
     */
    private $types;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="text", nullable=true)
     */
    private $commentaires;


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
     * Constructor
     */
    public function __construct()
    {
        $this->sites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lineUps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return Tournois
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires
     *
     * @return string
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add site
     *
     * @param \AppBundle\Entity\Site $site
     *
     * @return Tournois
     */
    public function addSite(\AppBundle\Entity\Site $site)
    {
        $this->sites[] = $site;

        return $this;
    }

    /**
     * Remove site
     *
     * @param \AppBundle\Entity\Site $site
     */
    public function removeSite(\AppBundle\Entity\Site $site)
    {
        $this->sites->removeElement($site);
    }

    /**
     * Get sites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * Add lineUp
     *
     * @param \AppBundle\Entity\LineUp $lineUp
     *
     * @return Tournois
     */
    public function addLineUp(\AppBundle\Entity\LineUp $lineUp)
    {
        $this->lineUps[] = $lineUp;

        return $this;
    }

    /**
     * Remove lineUp
     *
     * @param \AppBundle\Entity\LineUp $lineUp
     */
    public function removeLineUp(\AppBundle\Entity\LineUp $lineUp)
    {
        $this->lineUps->removeElement($lineUp);
    }

    /**
     * Get lineUps
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLineUps()
    {
        return $this->lineUps;
    }

    /**
     * Set tours
     *
     * @param \AppBundle\Entity\Tour $tours
     *
     * @return Tournois
     */
    public function setTours(\AppBundle\Entity\Tour $tours = null)
    {
        $this->tours = $tours;

        return $this;
    }

    /**
     * Get tours
     *
     * @return \AppBundle\Entity\Tour
     */
    public function getTours()
    {
        return $this->tours;
    }

    /**
     * Set types
     *
     * @param \AppBundle\Entity\Type $types
     *
     * @return Tournois
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
     * Set sites
     *
     * @param \AppBundle\Entity\Site $sites
     *
     * @return Tournois
     */
    public function setSites(\AppBundle\Entity\Site $sites = null)
    {
        $this->sites = $sites;

        return $this;
    }

    /**
     * Set lineUps
     *
     * @param \AppBundle\Entity\LineUp $lineUps
     *
     * @return Tournois
     */
    public function setLineUps(\AppBundle\Entity\LineUp $lineUps = null)
    {
        $this->lineUps = $lineUps;

        return $this;
    }

    /**
     * @return date
     */
    public function getDateTournois()
    {
        return $this->dateTournois;
    }

    /**
     * @param date $dateTournois
     */
    public function setDateTournois($dateTournois)
    {
        $this->dateTournois = $dateTournois;
    }
}
