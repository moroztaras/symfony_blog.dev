<?php
namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class User
 * @package UserBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="user_account", options={"collate"="utf8_general_ci"})
 * @Vich\Uploadable
 */
class UserAccount
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="account")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @ORM\Column(type="string")
     */
    private $firstName;
    /**
     * @ORM\Column(type="string")
     */
    private $lastName;
    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;
    /**
     * @ORM\Column(type="string")
     */
    private $region;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $tokenRecover;

    private $entities;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="avatarFileName")
     *
     * @var File
     */
    private $avatarFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $avatarFileName;

    public function __construct()
    {
        $this->avatarFileName="no avatar";
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return UserAccount
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return UserAccount
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
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return UserAccount
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return UserAccount
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set tokenRecover
     *
     * @param string $tokenRecover
     *
     * @return UserAccount
     */
    public function setTokenRecover($tokenRecover)
    {
        $this->tokenRecover = $tokenRecover;

        return $this;
    }

    /**
     * Get tokenRecover
     *
     * @return string
     */
    public function getTokenRecover()
    {
        return $this->tokenRecover;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return UserAccount
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setEntities($entities, $machine_name)
    {
        $this->entities[$machine_name] = $entities;
    }

    public function getEntities($machine_name)
    {
        return isset($this->entities[$machine_name]) ? $this->entities[$machine_name] : NULL;
    }
    /**
     * @param File|UploadedFile $avatarFile
     *
     * @return UserAccount
     */
    public function setAvatarFile(File $avatarFile = null)
    {
        $this->avatarFile = $avatarFile;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    /**
     * @param string $avatarFileName
     *
     * @return UserAccount
     */
    public function setAvatarFileName($avatarFileName)
    {
        $this->avatarFileName = $avatarFileName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvatarFileName()
    {
        return $this->avatarFileName;
    }
}
