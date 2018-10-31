<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Projects
 *
 * @ORM\Table(name="projects", indexes={@ORM\Index(name="fk_projects_teams_idx", columns={"teams_id"}), @ORM\Index(name="fk_projects_chats1_idx", columns={"chats_id"})})
 * @ORM\Entity
 */
class Projects
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
     * @var \Chats
     *
     * @ORM\ManyToOne(targetEntity="Chats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chats_id", referencedColumnName="id")
     * })
     */
    private $chats;

    /**
     * @var \Teams
     *
     * @ORM\ManyToOne(targetEntity="Teams",inversedBy="projects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="teams_id", referencedColumnName="id")
     * })
     */
    private $team;

    /**
    * @ORM\OneToMany(targetEntity="Tasks", mappedBy="project")
    */
   private $tasks;


   public function __construct()
   {
       $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Projects
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
     * Set chats
     *
     * @param \AppBundle\Entity\Chats $chats
     *
     * @return Projects
     */
    public function setChats(\AppBundle\Entity\Chats $chats = null)
    {
        $this->chats = $chats;

        return $this;
    }

    /**
     * Get chats
     *
     * @return \AppBundle\Entity\Chats
     */
    public function getChats()
    {
        return $this->chats;
    }

    /**
     * Set teams
     *
     * @param \AppBundle\Entity\Teams $teams
     *
     * @return Projects
     */
    public function setTeams(\AppBundle\Entity\Teams $teams)
    {
        $this->team = $teams;

        return $this;
    }

    /**
     * Get teams
     *
     * @return \AppBundle\Entity\Teams
     */
    public function getTeams()
    {
        return $this->team;
    }


    /**
     * Add task
     *
     * @param \AppBundle\Entity\Tasks $task
     *
     * @return Projects
     */
    public function addTask(\AppBundle\Entity\Tasks $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \AppBundle\Entity\Tasks $task
     */
    public function removeTask(\AppBundle\Entity\Tasks $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
