<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tier
 *
 * @ORM\Table(name="tier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TierRepository")
 */
class Tier
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
     * @var int
     *
     * @ORM\Column(name="tier_id", type="integer")
     */
    private $tierId;

    /**
     * @var string
     *
     * @ORM\Column(name="tier_name", type="string", length=255, nullable=false)
     */
    private $tierName;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LineUp", mappedBy="rankMin")
     */
    private $lineUp;


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
     * Set tier
     *
     * @param integer $tier
     *
     * @return Tier
     */
    public function setTier($tier)
    {
        $this->tier = $tier;

        return $this;
    }

    /**
     * Get tier
     *
     * @return int
     */
    public function getTier()
    {
        return $this->tier;
    }

    /**
     * Set tierId
     *
     * @param integer $tierId
     *
     * @return Tier
     */
    public function setTierId($tierId)
    {
        $this->tierId = $tierId;

        return $this;
    }

    /**
     * Get tierId
     *
     * @return integer
     */
    public function getTierId()
    {
        return $this->tierId;
    }

    /**
     * Set tierName
     *
     * @param string $tierName
     *
     * @return Tier
     */
    public function setTierName($tierName)
    {
        $this->tierName = $tierName;

        return $this;
    }

    /**
     * Get tierName
     *
     * @return string
     */
    public function getTierName()
    {
        return $this->tierName;
    }

    public function __toString()
    {
        return $this->tierName;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Tier
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lineUp = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lineUp
     *
     * @param \AppBundle\Entity\LineUp $lineUp
     *
     * @return Tier
     */
    public function addLineUp(\AppBundle\Entity\LineUp $lineUp)
    {
        $this->lineUp[] = $lineUp;

        return $this;
    }

    /**
     * Remove lineUp
     *
     * @param \AppBundle\Entity\LineUp $lineUp
     */
    public function removeLineUp(\AppBundle\Entity\LineUp $lineUp)
    {
        $this->lineUp->removeElement($lineUp);
    }

    /**
     * Get lineUp
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLineUp()
    {
        return $this->lineUp;
    }
}
