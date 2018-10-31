<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table(name="messages", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Messages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=65535, nullable=false)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="sendMessages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $sender;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", inversedBy="receiveMessages")
     * @ORM\JoinTable(name="user_message",
     *      joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $receivers;

    public function __construct()
    {
        $this->receivers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Messages
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
     * Set text
     *
     * @param string $text
     *
     * @return Messages
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Messages
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }



    /**
     * Get sender
     *
     * @return \AppBundle\Entity\Users
     */
    public function getsender()
    {
        return $this->sender;
    }

    /**
     * Set sender
     *
     * @param \AppBundle\Entity\Users $sender
     *
     * @return Messages
     */
    public function setSender(\AppBundle\Entity\Users $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Add receiver
     *
     * @param \AppBundle\Entity\Users $receiver
     *
     * @return Messages
     */
    public function addReceiver(\AppBundle\Entity\Users $receiver)
    {
        $this->receivers[] = $receiver;

        return $this;
    }

    /**
     * Remove receiver
     *
     * @param \AppBundle\Entity\Users $receiver
     */
    public function removeReceiver(\AppBundle\Entity\Users $receiver)
    {
        $this->receivers->removeElement($receiver);
    }

    /**
     * Get receivers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReceivers()
    {
        return $this->receivers;
    }
}
