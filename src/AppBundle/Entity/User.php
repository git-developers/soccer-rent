<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"}),
 *          @ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"}),
 *          @ORM\UniqueConstraint(name="dni_UNIQUE", columns={"dni"})
 *      },
 *     indexes={
 *          @ORM\Index(name="FK_8D93D649CCFA12B8", columns={"profile_id"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"dni"},
 *     message="El dni fue registrado por otro usuario"
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="El email fue registrado por otro usuario"
 * )
 * @UniqueEntity(
 *     fields={"username"},
 *     message="El username fue registrado por otro usuario"
 * )
 */
class User extends BaseUser
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSS\Groups({"user"})
     */
    protected $id;

//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="id_increment", type="integer")
//     * @ORM\Id
//     * @ORM\GeneratedValue(strategy="IDENTITY")
//     * @JMSS\Groups({"user"})
//     */
//    private $idIncrement;

    /**
     * @var integer
     *
     * @ORM\Column(name="client_id", type="integer", nullable=true)
     */
    private $clientId;

    /**
     * @var string
     *
     * @JMSS\Groups({"user"})
     */
    protected $username;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="username", type="string", length=45, nullable=false)
//     * @JMSS\Groups({"user"})
//     */
//    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     * @JMSS\Groups({"user"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="device_code", type="string", length=100, nullable=true)
     * @JMSS\Groups({"user"})
     */
    private $deviceCode;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 6,
     *      max = 500,
     *      minMessage = "Su contraseña debe de ser por lo menos de {{ limit }} caracteres",
     *      maxMessage = "Su contraseña no puede ser mayor a {{ limit }} caracteres"
     * )
     */
    protected $password;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="password", type="string", length=100, nullable=true)
//     * @JMSS\Groups({"user"})
//     */
//    private $password;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="salt", type="string", length=45, nullable=true)
//     * @JMSS\Groups({"user"})
//     */
//    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=8, nullable=true)
     * @JMSS\Groups({"user"})
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * @JMSS\Groups({"user"})
     * @Assert\Regex(
     *     pattern="/[^a-zA-Z ]+/",
     *     match=false,
     *     message="Nombre: Agregar solo texto"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100, nullable=true)
     * @JMSS\Groups({"user"})
     * @Assert\Regex(
     *     pattern="/[^a-zA-Z ]+/",
     *     match=false,
     *     message="Apellido: Agregar solo texto"
     * )
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=100, nullable=true)
     */
    private $address;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="email", type="string", length=255, nullable=false)
//     */
//    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=45, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @JMSS\Type("DateTime<'Y-m-d H:i'>")
     * @JMSS\Groups({"user"})
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
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_access", type="datetime", nullable=true)
     */
    private $lastAccess;

    /**
     * @var \AppBundle\Entity\Profile
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profile_id", referencedColumnName="id_increment")
     * })
     */
    private $profile;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PointOfSale", inversedBy="user")
     * @ORM\JoinTable(name="user_has_point_of_sale",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="point_of_sale_id", referencedColumnName="id_increment")
     *   }
     * )
     */
    private $pointOfSale;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pointOfSale = new \Doctrine\Common\Collections\ArrayCollection();
    }


//    /**
//     * Get idIncrement
//     *
//     * @return integer
//     */
//    public function getIdIncrement()
//    {
//        return $this->idIncrement;
//    }

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
     * Set clientId
     *
     * @param integer $clientId
     *
     * @return User
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return integer
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return User
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
     * Set deviceCode
     *
     * @param string $deviceCode
     *
     * @return User
     */
    public function setDeviceCode($deviceCode)
    {
        $this->deviceCode = $deviceCode;

        return $this;
    }

    /**
     * Get deviceCode
     *
     * @return string
     */
    public function getDeviceCode()
    {
        return $this->deviceCode;
    }

//    /**
//     * Set password
//     *
//     * @param string $password
//     *
//     * @return User
//     */
//    public function setPassword($password)
//    {
//        $this->password = $password;
//
//        return $this;
//    }
//
//    /**
//     * Get password
//     *
//     * @return string
//     */
//    public function getPassword()
//    {
//        return $this->password;
//    }

//    /**
//     * Set salt
//     *
//     * @param string $salt
//     *
//     * @return User
//     */
//    public function setSalt($salt)
//    {
//        $this->salt = $salt;
//
//        return $this;
//    }
//
//    /**
//     * Get salt
//     *
//     * @return string
//     */
//    public function getSalt()
//    {
//        return $this->salt;
//    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return User
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return User
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return User
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * Set lastAccess
     *
     * @param \DateTime $lastAccess
     *
     * @return User
     */
    public function setLastAccess($lastAccess)
    {
        $this->lastAccess = $lastAccess;

        return $this;
    }

    /**
     * Get lastAccess
     *
     * @return \DateTime
     */
    public function getLastAccess()
    {
        return $this->lastAccess;
    }

    /**
     * Set profile
     *
     * @param \AppBundle\Entity\Profile $profile
     *
     * @return User
     */
    public function setProfile(\AppBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \AppBundle\Entity\Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Add pointOfSale
     *
     * @param \AppBundle\Entity\PointOfSale $pointOfSale
     *
     * @return User
     */
    public function addPointOfSale(\AppBundle\Entity\PointOfSale $pointOfSale)
    {
        $this->pointOfSale[] = $pointOfSale;

        return $this;
    }

    /**
     * Remove pointOfSale
     *
     * @param \AppBundle\Entity\PointOfSale $pointOfSale
     */
    public function removePointOfSale(\AppBundle\Entity\PointOfSale $pointOfSale)
    {
        $this->pointOfSale->removeElement($pointOfSale);
    }

    /**
     * Get pointOfSale
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPointOfSale()
    {
        return $this->pointOfSale;
    }




    public function getRoles() {
        $roles = [];

        if(is_object($this->getProfile())){
            foreach ($this->getProfile()->getRole() as $key => $role) {
                $roles[] = $role->getSlug();
            }
        }

        $roles[] = 'ROLE_USER';

        return $roles;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
//
//    /** @see \Serializable::serialize() */
//    public function serialize()
//    {
//        return serialize(array(
//            $this->id,
//            $this->username,
//            $this->password,
//            $this->getRoles()
//            // see section on salt below
//            // $this->salt,
//        ));
//    }
//
//    /** @see \Serializable::unserialize() */
//    public function unserialize($serialized)
//    {
//        list (
//            $this->id,
//            $this->username,
//            $this->password,
//            // see section on salt below
//            // $this->salt
//            ) = unserialize($serialized);
//    }

}
