<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DisabledDate
 *
 * @ORM\Table(name="disabled_date")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DisabledDateRepository")
 */
class DisabledDate
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
     * @var \DateTime
     *
     * @ORM\Column(name="disabledDate", type="date")
     */
    private $disabledDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="disabledTime", type="time")
     */
    private $disabledTime;


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
     * Set disabledDate
     *
     * @param \DateTime $disabledDate
     *
     * @return DisabledDate
     */
    public function setDisabledDate($disabledDate)
    {
        $this->disabledDate = $disabledDate;

        return $this;
    }

    /**
     * Get disabledDate
     *
     * @return \DateTime
     */
    public function getDisabledDate()
    {
        return $this->disabledDate;
    }

    /**
     * Set disabledTime
     *
     * @param \DateTime $disabledTime
     *
     * @return DisabledDate
     */
    public function setDisabledTime($disabledTime)
    {
        $this->disabledTime = $disabledTime;

        return $this;
    }

    /**
     * Get disabledTime
     *
     * @return \DateTime
     */
    public function getDisabledTime()
    {
        return $this->disabledTime;
    }
}
