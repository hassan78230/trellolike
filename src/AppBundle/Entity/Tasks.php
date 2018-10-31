<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tasks
 *
 * @ORM\Table(name="tasks", indexes={@ORM\Index(name="fk_tasks_projects1_idx", columns={"projects_id"})})
 * @ORM\Entity
 */
class Tasks
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
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private $status;

    /**
     * @var \Date
     *
     * @ORM\Column(name="creationDate", type="datetime", nullable=false)
     */
    private $creationdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=false)
     */
    private $duration;

    /**
     * @var \Date
     *
     * @ORM\Column(name="startDate", type="datetime", nullable=false)
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime", nullable=false)
     */
    private $enddate;

    /**
     * @var \Projects
     *
     * @ORM\ManyToOne(targetEntity="Projects" , inversedBy="tasks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="projects_id", referencedColumnName="id")
     * })
     */
    private $project;

    /**
     * @ORM\ManyToMany(targetEntity="Tags", inversedBy="tagtasks")
     * @ORM\JoinTable(name="tasks_tags",
     *   joinColumns={
     *     @ORM\JoinColumn(name="tasks_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tags_id", referencedColumnName="id")
     *   }
     * )
     */
    private $tasktags;

    /**
     * @ORM\ManyToMany(targetEntity="Users", inversedBy="taskusers")
     * @ORM\JoinTable(name="users_tasks",
     *   joinColumns={
     *     @ORM\JoinColumn(name="tasks_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     *   }
     * )
     */
    private $userstask;



    public function __construct()
    {

        $this->tasktags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userstask = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Tasks
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
     * Set description
     *
     * @param string $description
     *
     * @return Tasks
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
     * Set status
     *
     * @param string $status
     *
     * @return Tasks
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set creationdate
     *
     * @param \DateTime $creationdate
     *
     * @return Tasks
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;

        return $this;
    }

    /**
     * Get creationdate
     *
     * @return \DateTime
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Tasks
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return Tasks
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     *
     * @return Tasks
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Projects $projects
     *
     * @return Tasks
     */
    public function setProject(\AppBundle\Entity\Projects $projects)
    {
        $this->project = $projects;

        return $this;
    }

    /**
     * Get projects
     *
     * @return \AppBundle\Entity\Projects
     */
    public function getProject()
    {
        return $this->project;
    }



    /**
     * Add tasktag
     *
     * @param \AppBundle\Entity\Tasks $tasktag
     *
     * @return Tasks
     */
    public function addTasktag(\AppBundle\Entity\Tasks $tasktag)
    {
        $this->tasktags[] = $tasktag;

        return $this;
    }

    /**
     * Remove tasktag
     *
     * @param \AppBundle\Entity\Tasks $tasktag
     */
    public function removeTasktag(\AppBundle\Entity\Tasks $tasktag)
    {
        $this->tasktags->removeElement($tasktag);
    }

    /**
     * Get tasktags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasktags()
    {
        return $this->tasktags;
    }

    /**
     * Add userstask
     *
     * @param \AppBundle\Entity\Users $userstask
     *
     * @return Tasks
     */
    public function addUserstask(\AppBundle\Entity\Users $userstask)
    {
        $this->userstask[] = $userstask;

        return $this;
    }

    /**
     * Remove userstask
     *
     * @param \AppBundle\Entity\Users $userstask
     */
    public function removeUserstask(\AppBundle\Entity\Users $userstask)
    {
        $this->userstask->removeElement($userstask);
    }

    /**
     * Get userstask
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserstask()
    {
        return $this->userstask;
    }
}
