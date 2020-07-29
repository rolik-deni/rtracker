<?php

namespace ApiBundle\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * Episode
 */
class Episode implements \JsonSerializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $originalTitle;

    /**
     * @var integer
     */
    private $number;

    /**
     * @var integer
     */
    private $seasonNumber;

    /**
     * @var \DateTime
     */
    private $releaseDate;

    /**
     * @var \ApiBundle\Entity\Serial
     */
    private $serial;

    public function __controller()
    {
        $this->releaseDate = new DateTime();
    }

    public function __toString()
    {
        return sprintf('%d %s %s', $this->id, $this->title, $this->originalTitle);
    }

    public function jsonSerialize()
    {
        $episode = [
            'id'            => $this->id,
            'title'         => $this->title,
            'originalTitle' => $this->originalTitle,
            'number'        => $this->number,
            'seasonNumber' => $this->seasonNumber,
            'releaseDate'  => is_object($this->releaseDate) ? $this->releaseDate->format('d.m.Y') : $this->releaseDate,
            'serial'        => $this->serial->getId(),
        ];

        return $episode;
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
     * @return Episode
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
     * Set originalTitle
     *
     * @param string $originalTitle
     *
     * @return Episode
     */
    public function setOriginalTitle($originalTitle)
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    /**
     * Get originalTitle
     *
     * @return string
     */
    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Episode
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set seasonNumber
     *
     * @param integer $seasonNumber
     *
     * @return Episode
     */
    public function setSeasonNumber($seasonNumber)
    {
        $this->seasonNumber = $seasonNumber;

        return $this;
    }

    /**
     * Get seasonNumber
     *
     * @return integer
     */
    public function getSeasonNumber()
    {
        return $this->seasonNumber;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Episode
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set serial
     *
     * @param \ApiBundle\Entity\Serial $serial
     *
     * @return Episode
     */
    public function setSerial(\ApiBundle\Entity\Serial $serial = null)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return \ApiBundle\Entity\Serial
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Update the number of seasons and episodes on postPersist and postRemove
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function updateNumberSeasonEpisode(LifecycleEventArgs $args)
    {
        $episode = $args->getObject();
        $em      = $args->getObjectManager();

        $id = $episode->getSerial()->getId();

        // Get the number of seasons and episodes
        $query = $em->createQuery('
          SELECT
            s.seasonNumber,
            s.episodeNumber,
            COUNT(DISTINCT e.seasonNumber),
            COUNT(e.id)
          FROM ApiBundle:Episode e
          JOIN e.serial s
          WHERE s.id = :serialId
        ');
        $query->setParameter('serialId', $id);
        $result = $query->getOneOrNullResult();

        $seasonNumberOld  = (int) $result['seasonNumber'];
        $episodeNumberOld = (int) $result['episodeNumber'];
        $seasonNumberNew  = (int) $result[1];
        $episodeNumberNew = (int) $result[2];

        if (
            $seasonNumberOld == $seasonNumberNew &&
            $episodeNumberOld == $episodeNumberNew
        ) {
            return;
        }

        // Update the number of seasons and episodes
        $query = $em->createQuery('
        UPDATE ApiBundle:Serial s
        SET
          s.seasonNumber = :seasonNumber,
          s.episodeNumber = :episodeNumber
        WHERE s.id = :serialId
        ');
        $query->setParameters([
            'seasonNumber'  => $seasonNumberNew,
            'episodeNumber' => $episodeNumberNew,
            'serialId'      => $id,
        ]);
        $result = $query->execute();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user.
     *
     * @param \ApiBundle\Entity\User $user
     *
     * @return Episode
     */
    public function addUser(\ApiBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \ApiBundle\Entity\User $user
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUser(\ApiBundle\Entity\User $user)
    {
        return $this->user->removeElement($user);
    }

    /**
     * Get user.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }
}
