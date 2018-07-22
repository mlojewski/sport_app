<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\gameRepository")
 */
class game
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
     * @var string
     *
     * @ORM\Column(name="home", type="string", length=255)
     */
    private $home;

    /**
     * @var string
     *
     * @ORM\Column(name="away", type="string", length=255)
     */
    private $away;

    /**
     * @var int
     *
     * @ORM\Column(name="scoreHome", type="smallint")
     */
    private $scoreHome;

    /**
     * @var int
     *
     * @ORM\Column(name="scoreAway", type="smallint")
     */
    private $scoreAway;

    /**
     * @var int
     *
     * @ORM\Column(name="result", type="smallint")
     */
    private $result;


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
     * Set home
     *
     * @param string $home
     *
     * @return game
     */
    public function setHome($home)
    {
        $this->home = $home;

        return $this;
    }

    /**
     * Get home
     *
     * @return string
     */
    public function getHome()
    {
        return $this->home;
    }

    /**
     * Set away
     *
     * @param string $away
     *
     * @return game
     */
    public function setAway($away)
    {
        $this->away = $away;

        return $this;
    }

    /**
     * Get away
     *
     * @return string
     */
    public function getAway()
    {
        return $this->away;
    }

    /**
     * Set scoreHome
     *
     * @param integer $scoreHome
     *
     * @return game
     */
    public function setScoreHome($scoreHome)
    {
        $this->scoreHome = $scoreHome;

        return $this;
    }

    /**
     * Get scoreHome
     *
     * @return int
     */
    public function getScoreHome()
    {
        return $this->scoreHome;
    }

    /**
     * Set scoreAway
     *
     * @param integer $scoreAway
     *
     * @return game
     */
    public function setScoreAway($scoreAway)
    {
        $this->scoreAway = $scoreAway;

        return $this;
    }

    /**
     * Get scoreAway
     *
     * @return int
     */
    public function getScoreAway()
    {
        return $this->scoreAway;
    }

    /**
     * Set result
     *
     * @param integer $result
     *
     * @return game
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }
}

