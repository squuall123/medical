<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idSender", type="integer")
     */
    private $idSender;

    /**
     * @var int
     *
     * @ORM\Column(name="idReceiver", type="integer")
     */
    private $idReceiver;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="receiverRole", type="string", length=255)
     */
    private $receiverRole;

    /**
     * @var string
     *
     * @ORM\Column(name="senderRole", type="string", length=255)
     */
    private $senderRole;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idSender
     *
     * @param integer $idSender
     *
     * @return Message
     */
    public function setIdSender($idSender)
    {
        $this->idSender = $idSender;

        return $this;
    }

    /**
     * Get idSender
     *
     * @return int
     */
    public function getIdSender()
    {
        return $this->idSender;
    }

    /**
     * Set idReceiver
     *
     * @param integer $idReceiver
     *
     * @return Message
     */
    public function setIdReceiver($idReceiver)
    {
        $this->idReceiver = $idReceiver;

        return $this;
    }

    /**
     * Get idReceiver
     *
     * @return int
     */
    public function getIdReceiver()
    {
        return $this->idReceiver;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Message
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set receiverRole
     *
     * @param string $receiverRole
     *
     * @return Message
     */
    public function setReceiverRole($receiverRole)
    {
        $this->receiverRole = $receiverRole;

        return $this;
    }

    /**
     * Get receiverRole
     *
     * @return string
     */
    public function getReceiverRole()
    {
        return $this->receiverRole;
    }

    /**
     * Set senderRole
     *
     * @param string $senderRole
     *
     * @return Message
     */
    public function setSenderRole($senderRole)
    {
        $this->senderRole = $senderRole;

        return $this;
    }

    /**
     * Get senderRole
     *
     * @return string
     */
    public function getSenderRole()
    {
        return $this->senderRole;
    }
}

