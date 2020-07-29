<?php

namespace ApiBundle\Entity;

use JsonSerializable;

/**
 * Country
 */
class Country implements JsonSerializable
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
  private $code;

  public function __toString()
  {
    return sprintf('%d %s', $this->id, $this->title);
  }

  public function jsonSerialize()
  {
    return [
      'id'    => $this->id,
      'title' => $this->title,
      // 'code'  => $this->code,
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
   * @return Country
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
   * Set code
   *
   * @param string $code
   *
   * @return Country
   */
  public function setCode($code)
  {
    $this->code = $code;

    return $this;
  }

  /**
   * Get code
   *
   * @return string
   */
  public function getCode()
  {
    return $this->code;
  }
}
