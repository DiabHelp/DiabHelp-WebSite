<?php

namespace DH\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProchePatientLink
 *
 * @ORM\Table(name="proche_patient_link")
 * @ORM\Entity
 */
class ProchePatientLink
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_patient", type="integer", nullable=false)
     */
    private $idPatient;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_proche", type="integer", nullable=false)
     */
    private $idProche;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set idPatient
     *
     * @param integer $idPatient
     *
     * @return ProchePatientLink
     */
    public function setIdPatient($idPatient)
    {
        $this->idPatient = $idPatient;

        return $this;
    }

    /**
     * Get idPatient
     *
     * @return integer
     */
    public function getIdPatient()
    {
        return $this->idPatient;
    }

    /**
     * Set idProche
     *
     * @param integer $idProche
     *
     * @return ProchePatientLink
     */
    public function setIdProche($idProche)
    {
        $this->idProche = $idProche;

        return $this;
    }

    /**
     * Get idProche
     *
     * @return integer
     */
    public function getIdProche()
    {
        return $this->idProche;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return ProchePatientLink
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
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
}
