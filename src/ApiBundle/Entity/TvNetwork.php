<?php

namespace ApiBundle\Entity;

use JsonSerializable;

/**
 * TvNetwork
 */
class TvNetwork implements JsonSerializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    public function __toString()
    {
        return sprintf('%d %s', $this->id, $this->title);
    }

    public function jsonSerialize()
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
        ];
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
     * @return TvNetwork
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
}
