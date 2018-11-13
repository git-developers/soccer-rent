<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMSS;

/**
 * Reserva
 *
 * @ORM\Table(name="reserva", indexes={@ORM\Index(name="fk_reserva_point_of_sale1_idx", columns={"point_of_sale_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservaRepository")
 */
class Reserva
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_increment", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @JMSS\Groups({"reserva"})
     */
    private $idIncrement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @JMSS\Type("DateTime<'Y-m-d H:i'>")
     * @JMSS\Groups({"reserva"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inicio", type="datetime", nullable=true)
     * @JMSS\Type("DateTime<'Y-m-d'>")
     * @JMSS\Groups({"reserva"})
     */
    private $inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="datetime", nullable=true)
     * @JMSS\Groups({"reserva"})
     */
    private $fin;

    /**
     * @var string
     *
     * @ORM\Column(name="time", type="string", length=80, nullable=true)
     * @JMSS\Groups({"reserva"})
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     * @JMSS\Groups({"reserva"})
     */
    private $name;

    /**
     * @var \AppBundle\Entity\PointOfSale
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PointOfSale")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="point_of_sale_id", referencedColumnName="id_increment")
     * })
     * @JMSS\Groups({"reserva"})
     */
    private $pointOfSale;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="string", length=11, nullable=true)
     * @JMSS\Groups({"reserva"})
     */
    private $userId;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get idIncrement
     *
     * @return integer
     */
    public function getIdIncrement()
    {
        return $this->idIncrement;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Reserva
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Reserva
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Reserva
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set inicio
     *
     * @param \DateTime $inicio
     *
     * @return Reserva
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     *
     * @return Reserva
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Reserva
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set pointOfSale
     *
     * @param \AppBundle\Entity\PointOfSale $pointOfSale
     *
     * @return Reserva
     */
    public function setPointOfSale(\AppBundle\Entity\PointOfSale $pointOfSale = null)
    {
        $this->pointOfSale = $pointOfSale;

        return $this;
    }

    /**
     * Get pointOfSale
     *
     * @return \AppBundle\Entity\PointOfSale
     */
    public function getPointOfSale()
    {
        return $this->pointOfSale;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }


}
