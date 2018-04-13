<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traitement
 *
 * @ORM\Table(name="traitement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TraitementRepository")
 */
class Traitement
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(name="medecinId", type="integer")
     */
     private $medecinId;

     /**
      * @ORM\Column(name="patientId", type="integer")
      */
      private $patientId;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return Traitement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Traitement
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }


    /**
     * Set patient
     *
     * @param \AppBundle\Entity\Patient $patient
     *
     * @return Traitement
     */
    public function setPatient(\AppBundle\Entity\Patient $patient)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get patient
     *
     * @return \AppBundle\Entity\Patient
     */
    public function getPatient()
    {
        return $this->patient;
    }



    /**
     * Set medecinId
     *
     * @param integer $medecinId
     *
     * @return Traitement
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

    /**
     * Set patientId
     *
     * @param integer $patientId
     *
     * @return Traitement
     */
    public function setPatientId($patientId)
    {
        $this->patientId = $patientId;

        return $this;
    }

    /**
     * Get patientId
     *
     * @return integer
     */
    public function getPatientId()
    {
        return $this->patientId;
    }
}
