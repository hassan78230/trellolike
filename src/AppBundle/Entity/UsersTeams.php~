<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersTeams
 *
 * @ORM\Table(name="users_teams", indexes={@ORM\Index(name="teams_id", columns={"teams_id"}), @ORM\Index(name="users_id", columns={"users_id"})})
 * @ORM\Entity
 */
class UsersTeams
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
     * @var \Teams
     *
     * @ORM\ManyToOne(targetEntity="Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="teams_id", referencedColumnName="id")
     * })
     */
    private $teams;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     * })
     */
    private $users;



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
     * Set teams
     *
     * @param \AppBundle\Entity\Teams $teams
     *
     * @return UsersTeams
     */
    public function setTeams(\AppBundle\Entity\Teams $teams = null)
    {
        $this->teams = $teams;

        return $this;
    }

    /**
     * Get teams
     *
     * @return \AppBundle\Entity\Teams
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Set users
     *
     * @param \AppBundle\Entity\Users $users
     *
     * @return UsersTeams
     */
    public function setUsers(\AppBundle\Entity\Users $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \AppBundle\Entity\Users
     */
    public function getUsers()
    {
        return $this->users;
    }
}
