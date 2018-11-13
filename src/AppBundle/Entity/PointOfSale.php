<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMSS;

/**
 * PointOfSale
 *
 * @ORM\Table(name="point_of_sale", uniqueConstraints={@ORM\UniqueConstraint(name="code_UNIQUE", columns={"code"})}, indexes={@ORM\Index(name="fk_point_of_sale_point_of_sale1_idx", columns={"point_of_sale_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PointOfSaleRepository")
 */
class PointOfSale
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_increment", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @JMSS\Groups({"pointofsale", "reserva"})
     */
    private $idIncrement;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=45, nullable=true)
     * @JMSS\Groups({"pointofsale", "reserva"})
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     * @JMSS\Groups({"pointofsale", "reserva"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100, nullable=false)
     * @JMSS\Groups({"pointofsale"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=11, scale=8, nullable=true)
     * @JMSS\Groups({"pointofsale"})
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=11, scale=8, nullable=true)
     * @JMSS\Groups({"pointofsale"})
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     * @JMSS\Groups({"pointofsale"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="text", length=45, nullable=true)
     * @JMSS\Groups({"pointofsale"})
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_por_hora", type="text", length=45, nullable=true)
     * @JMSS\Groups({"pointofsale"})
     */
    private $precioPorHora;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text", length=65535, nullable=true)
     * @JMSS\Groups({"pointofsale"})
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @JMSS\Type("DateTime<'Y-m-d H:i'>")
     * @JMSS\Groups({"pointofsale"})
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
     * @var \AppBundle\Entity\PointOfSale
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PointOfSale")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="point_of_sale_id", referencedColumnName="id_increment")
     * })
     */
    private $pointOfSale;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="pointOfSale")
     */
    private $user;

//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="category_id", type="integer", nullable=true)
//     * @JMSS\Groups({"pointofsale"})
//     */
//    private $categoryId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return sprintf('%s - %s', $this->idIncrement, $this->name);
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
     * Set code
     *
     * @param string $code
     *
     * @return PointOfSale
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return PointOfSale
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
     * Set slug
     *
     * @param string $slug
     *
     * @return PointOfSale
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return PointOfSale
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return PointOfSale
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PointOfSale
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PointOfSale
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
     * @return PointOfSale
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
     * @return PointOfSale
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
     * Set pointOfSale
     *
     * @param \AppBundle\Entity\PointOfSale $pointOfSale
     *
     * @return PointOfSale
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
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return PointOfSale
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getPrecioPorHora()
    {
        return $this->precioPorHora;
    }

    /**
     * @param string $precioPorHora
     */
    public function setPrecioPorHora($precioPorHora)
    {
        $this->precioPorHora = $precioPorHora;
    }





//    /**
//     * Set categoryId
//     *
//     * @param integer $categoryId
//     *
//     * @return PointOfSale
//     */
//    public function setCategoryId($categoryId)
//    {
//        $this->categoryId = $categoryId;
//
//        return $this;
//    }
//
//    /**
//     * Get categoryId
//     *
//     * @return integer
//     */
//    public function getCategoryId()
//    {
//        return $this->categoryId;
//    }
}
