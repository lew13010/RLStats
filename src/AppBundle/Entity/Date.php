<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Date
 *
 * @ORM\Table(name="date")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DateRepository")
 */
class Date
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
     * @var \DateTime
     *
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;

    /**
     * @var array
     *
     * @ORM\Column(name="erreur", type="array", nullable=true)
     */
    private $erreur;


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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Date
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set erreur
     *
     * @param array $erreur
     *
     * @return Date
     */
    public function setErreur($erreur)
    {
        $this->erreur = $erreur;

        return $this;
    }

    /**
     * Get erreur
     *
     * @return array
     */
    public function getErreur()
    {
        return $this->erreur;
    }
}
