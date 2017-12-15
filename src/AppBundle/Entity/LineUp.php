<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * LineUp
 *
 * @ORM\Table(name="line_up")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LineUpRepository")
 * @Vich\Uploadable
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="esport", type="boolean")
     */
    private $esport;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Joueur", mappedBy="lineUp")
     * @JoinColumn(onDelete="SET NULL")
     */
    private $joueurs;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tournois", mappedBy="lineUps")
     */
    private $tournois;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tier", inversedBy="lineUp")
     */
    private $rankMin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

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

    /**
     * Add tournois
     *
     * @param \AppBundle\Entity\Tournois $tournois
     *
     * @return LineUp
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

    /**
     * Set rankMin
     *
     * @param \AppBundle\Entity\Tier $rankMin
     *
     * @return LineUp
     */
    public function setRankMin(\AppBundle\Entity\Tier $rankMin = null)
    {
        $this->rankMin = $rankMin;

        return $this;
    }

    /**
     * Get rankMin
     *
     * @return \AppBundle\Entity\Tier
     */
    public function getRankMin()
    {
        return $this->rankMin;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return LineUp
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set esport
     *
     * @param boolean $esport
     *
     * @return LineUp
     */
    public function setEsport($esport)
    {
        $this->esport = $esport;

        return $this;
    }

    /**
     * Get esport
     *
     * @return boolean
     */
    public function getEsport()
    {
        return $this->esport;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTime());
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setUpdatedAt(\DateTime $date)
    {
        $this->updatedAt = $date;
        return $this;
    }
}
