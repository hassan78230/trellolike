<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TasksTags
 *
 * @ORM\Table(name="tasks_tags", indexes={@ORM\Index(name="fk_tasks_has_tags_tags1_idx", columns={"tags_id"}), @ORM\Index(name="fk_tasks_has_tags_tasks1_idx", columns={"tasks_id"})})
 * @ORM\Entity
 */
class TasksTags
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
     * @var \Tags
     *
     * @ORM\ManyToOne(targetEntity="Tags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tags_id", referencedColumnName="id")
     * })
     */
    private $tags;

    /**
     * @var \Tasks
     *
     * @ORM\ManyToOne(targetEntity="Tasks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tasks_id", referencedColumnName="id")
     * })
     */
    private $tasks;



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
     * Set tags
     *
     * @param \AppBundle\Entity\Tags $tags
     *
     * @return TasksTags
     */
    public function setTags(\AppBundle\Entity\Tags $tags = null)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return \AppBundle\Entity\Tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set tasks
     *
     * @param \AppBundle\Entity\Tasks $tasks
     *
     * @return TasksTags
     */
    public function setTasks(\AppBundle\Entity\Tasks $tasks = null)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * Get tasks
     *
     * @return \AppBundle\Entity\Tasks
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
