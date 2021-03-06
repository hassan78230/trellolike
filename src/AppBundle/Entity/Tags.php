<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity
 */
class Tags
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

     /**
      * @ORM\ManyToMany(targetEntity="Users", mappedBy="tags")
      */
    private $tagusers;

    /**
     * @ORM\ManyToMany(targetEntity="Tasks", mappedBy="tasktags")
     */
   private $tagtasks;

    public function __construct()
    {
        $this->tagusers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tagtasks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Tags
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
     * Add taguser
     *
     * @param \AppBundle\Entity\Users $taguser
     *
     * @return Tags
     */
    public function addTaguser(\AppBundle\Entity\Users $user)
    {
        $this->tagusers[] = $user;

        return $this;
    }

    /**
     * Remove taguser
     *
     * @param \AppBundle\Entity\Users $taguser
     */
    public function removeTaguser(\AppBundle\Entity\Users $user)
    {
        $this->tagusers->removeElement($user);
    }

    /**
     * Get tagusers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTagusers()
    {
        return $this->users;
    }

    /**
     * Add tagtask
     *
     * @param \AppBundle\Entity\Tasks $tagtask
     *
     * @return Tags
     */
    public function addTagtask(\AppBundle\Entity\Tasks $tagtask)
    {
        $this->tagtasks[] = $tagtask;

        return $this;
    }

    /**
     * Remove tagtask
     *
     * @param \AppBundle\Entity\Tasks $tagtask
     */
    public function removeTagtask(\AppBundle\Entity\Tasks $tagtask)
    {
        $this->tagtasks->removeElement($tagtask);
    }

    /**
     * Get tagtasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTagtasks()
    {
        return $this->tagtasks;
    }
}
