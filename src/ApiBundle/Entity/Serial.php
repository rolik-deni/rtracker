<?php

namespace ApiBundle\Entity;

/**
 * Serial
 */
class Serial implements \JsonSerializable
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
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $yearStart;

    /**
     * @var integer
     */
    private $yearEnd;

    /**
     * @var string
     */
    private $actor;

    /**
     * @var string
     */
    private $imdbId;

    /**
     * @var string
     */
    private $kinopoiskId;

    /**
     * @var \ApiBundle\Entity\TvNetwork
     */
    private $tvNetwork;

    /**
     * @var \ApiBundle\Entity\ValidationStatus
     */
    private $validationStatus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $country;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $genre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $user;

    /**
     * @var array
     */
    private $outputFields;

    /**
     * @var integer
     */
    private $seasonNumber;

    /**
     * @var integer
     */
    private $episodeNumber;

    /**
     * @var string
     */
    private $poster322;

    /**
     * @var string
     */
    private $poster72;

    /**
     * @var string
     */
    private $url;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->country = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genre   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user    = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return sprintf('%d %s', $this->id, $this->title);
    }

    /**
     * Задаёт данные, которые запрошены
     * @param array $fields
     * @return void
     */
    public function setOutputFields(array $fields)
    {
        $this->outputFields = $fields;
    }

    /**
     * Get $outputFields
     * @return array
     */
    public function getOutputFields(): array
    {
        return $this->outputFields;
    }

    /**
     * Задает данные, которые будут сериализованы в JSON
     * @return \ApiBundle\Entity\Serial
     */
    public function jsonSerialize()
    {
        $serial = [];

        foreach ($this->outputFields as $field) {
            if ($field == 'id' || $field == '*') {
                $serial['id'] = $this->id;
            }
            if ($field == 'title' || $field == '*') {
                $serial['title'] = $this->title;
            }
            if ($field == 'originalTitle' || $field == '*') {
                $serial['originalTitle'] = $this->originalTitle;
            }
            if ($field == 'description' || $field == '*') {
                $serial['description'] = $this->description;
            }
            if ($field == 'yearStart' || $field == '*') {
                $serial['yearStart'] = $this->yearStart;
            }
            if ($field == 'yearEnd' || $field == '*') {
                $serial['yearEnd'] = $this->yearEnd;
            }
            if ($field == 'actor' || $field == '*') {
                $serial['actor'] = $this->actor;
            }
            if ($field == 'imdbId' || $field == '*') {
                $serial['imdbId'] = $this->imdbId;
            }
            if ($field == 'kinopoiskId' || $field == '*') {
                $serial['kinopoiskId'] = $this->kinopoiskId;
            }
            if ($field == 'validationStatus' || $field == '*') {
                $serial['validationStatus'] = $this->validationStatus;
            }
            if ($field == 'tvNetwork' || $field == '*') {
                $serial['tvNetwork'] = $this->tvNetwork;
            }

            if ($field == 'country' || $field == '*') {
                foreach ($this->country as $country) {
                    $res                 = new \stdClass;
                    $res->id             = $country->getId();
                    $res->title          = $country->getTitle();
                    $res->code           = $country->getCode();
                    $serial['country'][] = $res;
                }
            }
            if ($field == 'genre' || $field == '*') {
                foreach ($this->genre as $genre) {
                    $res               = new \stdClass;
                    $res->id           = $genre->getId();
                    $res->title        = $genre->getTitle();
                    $serial['genre'][] = $res;
                }
            }
            if ($field == 'seasonNumber' || $field == '*') {
                $serial['seasonNumber'] = $this->seasonNumber;
            }
            if ($field == 'episodeNumber' || $field == '*') {
                $serial['episodeNumber'] = $this->episodeNumber;
            }
            if ($field == 'poster322' || $field == '*') {
                $serial['poster322'] = $this->poster322;
            }
            if ($field == 'poster72' || $field == '*') {
                $serial['poster72'] = $this->poster72;
            }
            if ($field == 'url' || $field == '*') {
                $serial['url'] = $this->url;
            }
        }

        if ($serial) {
            return $serial;
        } else {
            $this->setOutputFields(['*']);
            return $this->jsonSerialize();
        }
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
     * @return Serial
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
     * @return Serial
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
     * Set description
     *
     * @param string $description
     *
     * @return Serial
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
     * Set yearStart
     *
     * @param integer $yearStart
     *
     * @return Serial
     */
    public function setYearStart($yearStart)
    {
        $this->yearStart = $yearStart;

        return $this;
    }

    /**
     * Get yearStart
     *
     * @return integer
     */
    public function getYearStart()
    {
        return $this->yearStart;
    }

    /**
     * Set yearEnd
     *
     * @param integer $yearEnd
     *
     * @return Serial
     */
    public function setYearEnd($yearEnd)
    {
        $this->yearEnd = $yearEnd;

        return $this;
    }

    /**
     * Get yearEnd
     *
     * @return integer
     */
    public function getYearEnd()
    {
        return $this->yearEnd;
    }

    /**
     * Set actor
     *
     * @param string $actor
     *
     * @return Serial
     */
    public function setactor($actor)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return string
     */
    public function getactor()
    {
        return $this->actor;
    }

    /**
     * Set imdbId
     *
     * @param string $imdbId
     *
     * @return Serial
     */
    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    /**
     * Get imdbId
     *
     * @return string
     */
    public function getImdbId()
    {
        return $this->imdbId;
    }

    /**
     * Set kinopoiskId
     *
     * @param string $kinopoiskId
     *
     * @return Serial
     */
    public function setKinopoiskId($kinopoiskId)
    {
        $this->kinopoiskId = $kinopoiskId;

        return $this;
    }

    /**
     * Get kinopoiskId
     *
     * @return string
     */
    public function getKinopoiskId()
    {
        return $this->kinopoiskId;
    }

    /**
     * Set tvNetwork
     *
     * @param \ApiBundle\Entity\TvNetwork $tvNetwork
     *
     * @return Serial
     */
    public function setTvNetwork(\ApiBundle\Entity\TvNetwork $tvNetwork = null)
    {
        $this->tvNetwork = $tvNetwork;

        return $this;
    }

    /**
     * Get tvNetwork
     *
     * @return \ApiBundle\Entity\TvNetwork
     */
    public function getTvNetwork()
    {
        return $this->tvNetwork;
    }

    /**
     * Set validationStatus
     *
     * @param \ApiBundle\Entity\ValidationStatus $validationStatus
     *
     * @return Serial
     */
    public function setValidationStatus(\ApiBundle\Entity\ValidationStatus $validationStatus = null)
    {
        $this->validationStatus = $validationStatus;

        return $this;
    }

    /**
     * Get validationStatus
     *
     * @return \ApiBundle\Entity\ValidationStatus
     */
    public function getValidationStatus()
    {
        return $this->validationStatus;
    }

    /**
     * Add country
     *
     * @param \ApiBundle\Entity\Country $country
     *
     * @return Serial
     */
    public function addCountry(\ApiBundle\Entity\Country $country)
    {
        $this->country[] = $country;

        return $this;
    }

    /**
     * Remove country
     *
     * @param \ApiBundle\Entity\Country $country
     */
    public function removeCountry(\ApiBundle\Entity\Country $country)
    {
        $this->country->removeElement($country);
    }

    /**
     * Get country
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add genre
     *
     * @param \ApiBundle\Entity\Genre $genre
     *
     * @return Serial
     */
    public function addGenre(\ApiBundle\Entity\Genre $genre)
    {
        $this->genre[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param \ApiBundle\Entity\Genre $genre
     */
    public function removeGenre(\ApiBundle\Entity\Genre $genre)
    {
        $this->genre->removeElement($genre);
    }

    /**
     * Get genre
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Add user
     *
     * @param \ApiBundle\Entity\User $user
     *
     * @return Serial
     */
    public function addUser(\ApiBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \ApiBundle\Entity\User $user
     */
    public function removeUser(\ApiBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set seasonNumber
     *
     * @param integer $seasonNumber
     *
     * @return Serial
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
     * Set episodeNumber
     *
     * @param integer $episodeNumber
     *
     * @return Serial
     */
    public function setEpisodeNumber($episodeNumber)
    {
        $this->episodeNumber = $episodeNumber;

        return $this;
    }

    /**
     * Get episodeNumber
     *
     * @return integer
     */
    public function getEpisodeNumber()
    {
        return $this->episodeNumber;
    }

    /**
     * Set poster322
     *
     * @param string $poster322
     *
     * @return Serial
     */
    public function setPoster322($poster322)
    {
        $this->poster322 = $poster322;

        return $this;
    }

    /**
     * Get poster322
     *
     * @return string
     */
    public function getPoster322()
    {
        return $this->poster322;
    }

    /**
     * Set poster72
     *
     * @param string $poster72
     *
     * @return Serial
     */
    public function setPoster72($poster72)
    {
        $this->poster72 = $poster72;

        return $this;
    }

    /**
     * Get poster72
     *
     * @return string
     */
    public function getPoster72()
    {
        return $this->poster72;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Serial
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
