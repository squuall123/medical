<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FreeDays
 *
 * @ORM\Table(name="free_days")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FreeDaysRepository")
 */
class FreeDays
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
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\Column(name="medecinId", type="integer")
     */
     private $medecinId;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FreeDays
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set medecinId
     *
     * @param integer $medecinId
     *
     * @return FreeDays
     */
    public function setMedecinId($medecinId)
    {
        $this->medecinId = $medecinId;

        return $this;
    }

    /**
     * Get medecinId
     *
     * @return integer
     */
    public function getMedecinId()
    {
        return $this->medecinId;
    }
}
