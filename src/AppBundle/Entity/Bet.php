<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMSS;

/**
 * Bet
 *
 * @ORM\Table(name="bet", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_D044D5D4A76ED395", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BetRepository")
 */
class Bet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_increment", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idIncrement;

    /**
     * @var string
     *
     * @ORM\Column(name="matchKey", type="string", length=45, nullable=true)
     */
    private $matchKey;

    /**
     * @var string
     *
     * @ORM\Column(name="team_home", type="string", length=45, nullable=true)
     */
    private $teamHome;

    /**
     * @var string
     *
     * @ORM\Column(name="team_away", type="string", length=45, nullable=true)
     */
    private $teamAway;

    /**
     * @var integer
     *
     * @ORM\Column(name="team_home_score", type="integer", length=5, nullable=true)
     */
    private $teamHomeScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="team_away_score", type="integer", length=5, nullable=true)
     */
    private $teamAwayScore;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=45, nullable=true)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     * @JMSS\Type("DateTime<'Y-m-d H:i'>")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;



    /**
     * Get idIncrement
     *
     * @return integer
     */
    public function getIdIncrement()
    {
        return $this->idIncrement;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Session
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Session
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Session
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Session
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Session
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getMatchKey()
    {
        return $this->matchKey;
    }

    /**
     * @param string $matchKey
     */
    public function setMatchKey($matchKey)
    {
        $this->matchKey = $matchKey;
    }

    /**
     * @return string
     */
    public function getTeamHome()
    {
        return $this->teamHome;
    }

    /**
     * @param string $teamHome
     */
    public function setTeamHome($teamHome)
    {
        $this->teamHome = $teamHome;
    }

    /**
     * @return string
     */
    public function getTeamAway()
    {
        return $this->teamAway;
    }

    /**
     * @param string $teamAway
     */
    public function setTeamAway($teamAway)
    {
        $this->teamAway = $teamAway;
    }

    /**
     * @return int
     */
    public function getTeamHomeScore()
    {
        return $this->teamHomeScore;
    }

    /**
     * @param int $teamHomeScore
     */
    public function setTeamHomeScore($teamHomeScore)
    {
        $this->teamHomeScore = $teamHomeScore;
    }

    /**
     * @return int
     */
    public function getTeamAwayScore()
    {
        return $this->teamAwayScore;
    }

    /**
     * @param int $teamAwayScore
     */
    public function setTeamAwayScore($teamAwayScore)
    {
        $this->teamAwayScore = $teamAwayScore;
    }


}
