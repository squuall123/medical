<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @UniqueEntity(fields="email", message="This email address is already in use")
 */
class Medecin implements UserInterface
{
    /**
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $role;

    /**
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $ssn;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $phone;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Service",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
    */
     private $specialite;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $etat;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="verif_file", fileNameProperty="justificatifName", size="justificatifSize")
     * 
     * @var File
     */
    private $justificatifFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $justificatifName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setJustificatifFile(?File $file = null): void
    {
        $this->justificatifFile = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getJustificatifFile(): ?File
    {
        return $this->justificatifFile;
    }

    public function setJustificatifName(?string $justificatifName): void
    {
        $this->justificatifName = $justificatifName;
    }

    public function getJustificatifName(): ?string
    {
        return $this->justificatifName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Justificatif
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

    public function eraseCredentials()
    {
        return null;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role = null)
    {
        $this->role = $role;
    }

    public function getRoles()
    {
        return [$this->getRole()];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * Set ssn
     *
     * @param string $ssn
     *
     * @return Patient
     */
    public function setSsn($ssn)
    {
        $this->ssn = $ssn;

        return $this;
    }

    /**
     * Get ssn
     *
     * @return string
     */
    public function getSsn()
    {
        return $this->ssn;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Patient
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
     * Set specialite
     *
     * @param string $specialite
     *
     * @return Medecin
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return Medecin
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
     * Set justificatif
     *
     * @param string $justificatif
     *
     * @return Medecin
     */
    public function setJustificatif($justificatif)
    {
        $this->justificatif = $justificatif;

        return $this;
    }

    /**
     * Get justificatif
     *
     * @return string
     */
    public function getJustificatif()
    {
        return $this->justificatif;
    }
}
