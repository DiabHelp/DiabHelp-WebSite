<?php

namespace DH\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CdsSave
 *
 * @ORM\Table(name="cds_save")
 * @ORM\Entity
 */
class CdsSave
{

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", length=65535, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="text", length=65535, nullable=false)
     */
    private $place;

    /**
     * @var float
     *
     * @ORM\Column(name="glucide", type="float", precision=10, scale=0, nullable=false)
     */
    private $glucide;

    /**
     * @var string
     *
     * @ORM\Column(name="activity", type="text", length=65535, nullable=false)
     */
    private $activity;

    /**
     * @var string
     *
     * @ORM\Column(name="activity_type", type="text", length=65535, nullable=false)
     */
    private $activityType;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=65535, nullable=false)
     */
    private $notes;

    /**
     * @var float
     *
     * @ORM\Column(name="fast_insu", type="float", precision=10, scale=0, nullable=false)
     */
    private $fastInsu;

    /**
     * @var float
     *
     * @ORM\Column(name="slow_insu", type="float", precision=10, scale=0, nullable=false)
     */
    private $slowInsu;

    /**
     * @var float
     *
     * @ORM\Column(name="hba1c", type="float", precision=10, scale=0, nullable=false)
     */
    private $hba1c;

    /**
     * @var string
     *
     * @ORM\Column(name="hour", type="text", length=65535, nullable=false)
     */
    private $hour;

    /**
     * @var float
     *
     * @ORM\Column(name="glycemy", type="float", precision=10, scale=0, nullable=false)
     */
    private $glycemy;

    /**
     * @var integer
     *
     * @ORM\Column(name="breakfast", type="integer", nullable=false)
     */
    private $breakfast;

    /**
     * @var integer
     *
     * @ORM\Column(name="lunch", type="integer", nullable=false)
     */
    private $lunch;

    /**
     * @var integer
     *
     * @ORM\Column(name="diner", type="integer", nullable=false)
     */
    private $diner;

    /**
     * @var integer
     *
     * @ORM\Column(name="encas", type="integer", nullable=false)
     */
    private $encas;

    /**
     * @var integer
     *
     * @ORM\Column(name="sleep", type="integer", nullable=false)
     */
    private $sleep;

    /**
     * @var integer
     *
     * @ORM\Column(name="wakeup", type="integer", nullable=false)
     */
    private $wakeup;

    /**
     * @var integer
     *
     * @ORM\Column(name="night", type="integer", nullable=false)
     */
    private $night;

    /**
     * @var integer
     *
     * @ORM\Column(name="workout", type="integer", nullable=false)
     */
    private $workout;

    /**
     * @var integer
     *
     * @ORM\Column(name="hypogly", type="integer", nullable=false)
     */
    private $hypogly;

    /**
     * @var integer
     *
     * @ORM\Column(name="hypergly", type="integer", nullable=false)
     */
    private $hypergly;

    /**
     * @var integer
     *
     * @ORM\Column(name="work", type="integer", nullable=false)
     */
    private $work;

    /**
     * @var integer
     *
     * @ORM\Column(name="athome", type="integer", nullable=false)
     */
    private $athome;

    /**
     * @var integer
     *
     * @ORM\Column(name="alcohol", type="integer", nullable=false)
     */
    private $alcohol;

    /**
     * @var integer
     *
     * @ORM\Column(name="period", type="integer", nullable=false)
     */
    private $period;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return CdsSave
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set place
     *
     * @param string $place
     *
     * @return CdsSave
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set glucide
     *
     * @param float $glucide
     *
     * @return CdsSave
     */
    public function setGlucide($glucide)
    {
        $this->glucide = $glucide;

        return $this;
    }

    /**
     * Get glucide
     *
     * @return float
     */
    public function getGlucide()
    {
        return $this->glucide;
    }

    /**
     * Set activity
     *
     * @param string $activity
     *
     * @return CdsSave
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set activityType
     *
     * @param string $activityType
     *
     * @return CdsSave
     */
    public function setActivityType($activityType)
    {
        $this->activityType = $activityType;

        return $this;
    }

    /**
     * Get activityType
     *
     * @return string
     */
    public function getActivityType()
    {
        return $this->activityType;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return CdsSave
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set fastInsu
     *
     * @param float $fastInsu
     *
     * @return CdsSave
     */
    public function setFastInsu($fastInsu)
    {
        $this->fastInsu = $fastInsu;

        return $this;
    }

    /**
     * Get fastInsu
     *
     * @return float
     */
    public function getFastInsu()
    {
        return $this->fastInsu;
    }

    /**
     * Set slowInsu
     *
     * @param float $slowInsu
     *
     * @return CdsSave
     */
    public function setSlowInsu($slowInsu)
    {
        $this->slowInsu = $slowInsu;

        return $this;
    }

    /**
     * Get slowInsu
     *
     * @return float
     */
    public function getSlowInsu()
    {
        return $this->slowInsu;
    }

    /**
     * Set hba1c
     *
     * @param float $hba1c
     *
     * @return CdsSave
     */
    public function setHba1c($hba1c)
    {
        $this->hba1c = $hba1c;

        return $this;
    }

    /**
     * Get hba1c
     *
     * @return float
     */
    public function getHba1c()
    {
        return $this->hba1c;
    }

    /**
     * Set hour
     *
     * @param string $hour
     *
     * @return CdsSave
     */
    public function setHour($hour)
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * Get hour
     *
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * Set glycemy
     *
     * @param float $glycemy
     *
     * @return CdsSave
     */
    public function setGlycemy($glycemy)
    {
        $this->glycemy = $glycemy;

        return $this;
    }

    /**
     * Get glycemy
     *
     * @return float
     */
    public function getGlycemy()
    {
        return $this->glycemy;
    }

    /**
     * Set breakfast
     *
     * @param integer $breakfast
     *
     * @return CdsSave
     */
    public function setBreakfast($breakfast)
    {
        $this->breakfast = $breakfast;

        return $this;
    }

    /**
     * Get breakfast
     *
     * @return integer
     */
    public function getBreakfast()
    {
        return $this->breakfast;
    }

    /**
     * Set lunch
     *
     * @param integer $lunch
     *
     * @return CdsSave
     */
    public function setLunch($lunch)
    {
        $this->lunch = $lunch;

        return $this;
    }

    /**
     * Get lunch
     *
     * @return integer
     */
    public function getLunch()
    {
        return $this->lunch;
    }

    /**
     * Set diner
     *
     * @param integer $diner
     *
     * @return CdsSave
     */
    public function setDiner($diner)
    {
        $this->diner = $diner;

        return $this;
    }

    /**
     * Get diner
     *
     * @return integer
     */
    public function getDiner()
    {
        return $this->diner;
    }

    /**
     * Set encas
     *
     * @param integer $encas
     *
     * @return CdsSave
     */
    public function setEncas($encas)
    {
        $this->encas = $encas;

        return $this;
    }

    /**
     * Get encas
     *
     * @return integer
     */
    public function getEncas()
    {
        return $this->encas;
    }

    /**
     * Set sleep
     *
     * @param integer $sleep
     *
     * @return CdsSave
     */
    public function setSleep($sleep)
    {
        $this->sleep = $sleep;

        return $this;
    }

    /**
     * Get sleep
     *
     * @return integer
     */
    public function getSleep()
    {
        return $this->sleep;
    }

    /**
     * Set wakeup
     *
     * @param integer $wakeup
     *
     * @return CdsSave
     */
    public function setWakeup($wakeup)
    {
        $this->wakeup = $wakeup;

        return $this;
    }

    /**
     * Get wakeup
     *
     * @return integer
     */
    public function getWakeup()
    {
        return $this->wakeup;
    }

    /**
     * Set night
     *
     * @param integer $night
     *
     * @return CdsSave
     */
    public function setNight($night)
    {
        $this->night = $night;

        return $this;
    }

    /**
     * Get night
     *
     * @return integer
     */
    public function getNight()
    {
        return $this->night;
    }

    /**
     * Set workout
     *
     * @param integer $workout
     *
     * @return CdsSave
     */
    public function setWorkout($workout)
    {
        $this->workout = $workout;

        return $this;
    }

    /**
     * Get workout
     *
     * @return integer
     */
    public function getWorkout()
    {
        return $this->workout;
    }

    /**
     * Set hypogly
     *
     * @param integer $hypogly
     *
     * @return CdsSave
     */
    public function setHypogly($hypogly)
    {
        $this->hypogly = $hypogly;

        return $this;
    }

    /**
     * Get hypogly
     *
     * @return integer
     */
    public function getHypogly()
    {
        return $this->hypogly;
    }

    /**
     * Set hypergly
     *
     * @param integer $hypergly
     *
     * @return CdsSave
     */
    public function setHypergly($hypergly)
    {
        $this->hypergly = $hypergly;

        return $this;
    }

    /**
     * Get hypergly
     *
     * @return integer
     */
    public function getHypergly()
    {
        return $this->hypergly;
    }

    /**
     * Set work
     *
     * @param integer $work
     *
     * @return CdsSave
     */
    public function setWork($work)
    {
        $this->work = $work;

        return $this;
    }

    /**
     * Get work
     *
     * @return integer
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * Set athome
     *
     * @param integer $athome
     *
     * @return CdsSave
     */
    public function setAthome($athome)
    {
        $this->athome = $athome;

        return $this;
    }

    /**
     * Get athome
     *
     * @return integer
     */
    public function getAthome()
    {
        return $this->athome;
    }

    /**
     * Set alcohol
     *
     * @param integer $alcohol
     *
     * @return CdsSave
     */
    public function setAlcohol($alcohol)
    {
        $this->alcohol = $alcohol;

        return $this;
    }

    /**
     * Get alcohol
     *
     * @return integer
     */
    public function getAlcohol()
    {
        return $this->alcohol;
    }

    /**
     * Set period
     *
     * @param integer $period
     *
     * @return CdsSave
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return integer
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return CdsSave
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
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
     * @var integer
     */
    private $idSynchro;

    /**
     * @var \DateTime
     */
    private $dateEdition;


    /**
     * Set idSynchro
     *
     * @param integer $idSynchro
     *
     * @return CdsSave
     */
    public function setIdSynchro($idSynchro)
    {
        $this->idSynchro = $idSynchro;

        return $this;
    }

    /**
     * Get idSynchro
     *
     * @return integer
     */
    public function getIdSynchro()
    {
        return $this->idSynchro;
    }

    /**
     * Set dateEdition
     *
     * @param mixed $dateEdition
     *
     * @return CdsSave
     */
    public function setDateEdition($dateEdition)
    {
        $this->dateEdition = $dateEdition;

        return $this;
    }

    /**
     * Get dateEdition
     *
     * @return mixed
     */
    public function getDateEdition()
    {
        return $this->dateEdition;
    }
}
