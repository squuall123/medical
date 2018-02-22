<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Justificatif
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // ... other fields

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
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $justificatifSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
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
    
    public function setJustificatifSize(?int $justificatifSize): void
    {
        $this->justificatifSize = $justificatifSize;
    }

    public function getJustificatifSize(): ?int
    {
        return $this->justificatifSize;
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
}
