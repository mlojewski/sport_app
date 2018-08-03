<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\teamRepository")
 */
class team
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=1000)
     */
    private $logo;

    /**
    * @var int
    * @ORM\Column(name="points_for", type="integer")
    */

    private $pointsFor;

    /**
    * @var int
    * @ORM\Column(name="scores_for", type="integer")
    */

    private $scoresFor;

    /**
    * @var int
    * @ORM\Column(name="scores_against", type="integer")
    */

    private $scoresAgainst;

    /**
    *@ORM\ManyToMany(targetEntity="Game", inversedBy="teams", cascade={"persist", "merge"})
    *@ORM\JoinTable(name="team_games",
      * joinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")},
      * inverseJoinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="id")}
      *)
    **/

    private $games;



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
     * Set name
     *
     * @param string $name
     *
     * @return team
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
     * Set password
     *
     * @param string $password
     *
     * @return team
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return team
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }
    public function __toString()
    {
      return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add game
     *
     * @param \AppBundle\Entity\Game $game
     *
     * @return team
     */
    public function addGame(\AppBundle\Entity\Game $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove game
     *
     * @param \AppBundle\Entity\Game $game
     */
    public function removeGame(\AppBundle\Entity\Game $game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Set pointsFor
     *
     * @param integer $pointsFor
     *
     * @return team
     */
    public function setPointsFor($pointsFor)
    {
        $this->pointsFor = $pointsFor;

        return $this;
    }

    /**
     * Get pointsFor
     *
     * @return integer
     */
    public function getPointsFor()
    {
        return $this->pointsFor;
    }

    /**
     * Set scoresFor
     *
     * @param integer $scoresFor
     *
     * @return team
     */
    public function setScoresFor($scoresFor)
    {
        $this->scoresFor = $scoresFor;

        return $this;
    }

    /**
     * Get scoresFor
     *
     * @return integer
     */
    public function getScoresFor()
    {
        return $this->scoresFor;
    }

    /**
     * Set scoresAgainst
     *
     * @param integer $scoresAgainst
     *
     * @return team
     */
    public function setScoresAgainst($scoresAgainst)
    {
        $this->scoresAgainst = $scoresAgainst;

        return $this;
    }

    /**
     * Get scoresAgainst
     *
     * @return integer
     */
    public function getScoresAgainst()
    {
        return $this->scoresAgainst;
    }
}
