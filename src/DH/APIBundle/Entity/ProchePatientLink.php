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
     * @var \DH\APIBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="DH\APIBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_patient", referencedColumnName="id")
     * })
     */
    private $patient;

    /**
     * @var \DH\APIBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="DH\APIBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_proche", referencedColumnName="id")
     * })
     */
    private $proche;

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
     * Set proche
     *
     * @param \DH\APIBundle\Entity\User $proche
     *
     * @return ProchePatientLink
     */
    public function setProche(\DH\APIBundle\Entity\User $proche = null)
    {
        $this->proche = $proche;

        return $this;
    }

    /**
     * Get proche
     *
     * @return \DH\APIBundle\Entity\User
     */
    public function getProche()
    {
        return $this->proche;
    }

    /**
     * Set patient
     *
     * @param \DH\APIBundle\Entity\User $patient
     *
     * @return ProchePatientLink
     */
    public function setPatient(\DH\APIBundle\Entity\User $patient = null)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get patient
     *
     * @return \DH\APIBundle\Entity\User
     */
    public function getPatient()
    {
        return $this->patient;
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
