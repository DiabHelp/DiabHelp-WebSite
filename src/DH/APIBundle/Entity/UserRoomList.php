<?php

namespace DH\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRoomList
 *
 * @ORM\Table(name="user_room_list")
 * @ORM\Entity
 */
class UserRoomList
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_room", type="integer", nullable=false)
     */
    private $idRoom;

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
     * Set idRoom
     *
     * @param integer $idRoom
     *
     * @return UserRoomList
     */
    public function setIdRoom($idRoom)
    {
        $this->idRoom = $idRoom;

        return $this;
    }

    /**
     * Get idRoom
     *
     * @return integer
     */
    public function getIdRoom()
    {
        return $this->idRoom;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return UserRoomList
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
}
