<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultation
 *
 * @ORM\Table(name="consultation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsultationRepository")
 */
class Consultation
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
     * @ORM\Column(name="nomPatient", type="string", length=255)
     */
    private $nomPatient;

    /**
     * @var string
     *
     * @ORM\Column(name="nomMedecin", type="string", length=255)
     */
    private $nomMedecin;

    /**
     * @var int
     *
     * @ORM\Column(name="idPatient", type="integer")
     */
    private $idPatient;

    /**
     * @var int
     *
     * @ORM\Column(name="idMedecin", type="integer")
     */
    private $idMedecin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRDV", type="date")
     */
    private $dateRDV;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeRDV", type="time")
     */
    private $timeRDV;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     */
    protected $description;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $etat;

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
     * Set nomPatient
     *
     * @param string $nomPatient
     *
     * @return Consultation
     */
    public function setNomPatient($nomPatient)
    {
        $this->nomPatient = $nomPatient;

        return $this;
    }

    /**
     * Get nomPatient
     *
     * @return string
     */
    public function getNomPatient()
    {
        return $this->nomPatient;
    }

    /**
     * Set nomMedecin
     *
     * @param string $nomMedecin
     *
     * @return Consultation
     */
    public function setNomMedecin($nomMedecin)
    {
        $this->nomMedecin = $nomMedecin;

        return $this;
    }

    /**
     * Get nomMedecin
     *
     * @return string
     */
    public function getNomMedecin()
    {
        return $this->nomMedecin;
    }

    /**
     * Set idPatient
     *
     * @param integer $idPatient
     *
     * @return Consultation
     */
    public function setIdPatient($idPatient)
    {
        $this->idPatient = $idPatient;

        return $this;
    }

    /**
     * Get idPatient
     *
     * @return int
     */
    public function getIdPatient()
    {
        return $this->idPatient;
    }

    /**
     * Set idMedecin
     *
     * @param integer $idMedecin
     *
     * @return Consultation
     */
    public function setIdMedecin($idMedecin)
    {
        $this->idMedecin = $idMedecin;

        return $this;
    }

    /**
     * Get idMedecin
     *
     * @return int
     */
    public function getIdMedecin()
    {
        return $this->idMedecin;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Consultation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateRDV
     *
     * @param \DateTime $dateRDV
     *
     * @return Consultation
     */
    public function setDateRDV($dateRDV)
    {
        $this->dateRDV = $dateRDV;

        return $this;
    }

    /**
     * Get dateRDV
     *
     * @return \DateTime
     */
    public function getDateRDV()
    {
        return $this->dateRDV;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Consultation
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
     * Set timeRDV
     *
     * @param \DateTime $timeRDV
     *
     * @return Consultation
     */
    public function setTimeRDV($timeRDV)
    {
        $this->timeRDV = $timeRDV;

        return $this;
    }

    /**
     * Get timeRDV
     *
     * @return \DateTime
     */
    public function getTimeRDV()
    {
        return $this->timeRDV;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return Consultation
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->consultation = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
