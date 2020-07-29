<?php

namespace ApiBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface, \Serializable, \JsonSerializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTime
     */
    private $registrationTime;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $serial;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $episode;

    private $isActive;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registrationTime = new \DateTime();
        $this->serial           = new \Doctrine\Common\Collections\ArrayCollection();
        $this->episode          = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive         = true;
    }

    public function __toString()
    {
        return sprintf('%d %s', $this->id, $this->email);
    }

    public function jsonSerialize()
    {
        $user = [
            'id'                => $this->id,
            'email'             => $this->email,
            'password'          => $this->password,
            'is_active'         => $this->isActive,
            'registration_time' => is_object($this->registrationTime) ? $this->registrationTime->format('d.m.Y H:i') : $this->registrationTime,
            'serial'            => null,
            'episode'           => null,
        ];

        foreach ($this->serial as $serial) {
            $temp                = new \stdClass();
            $temp->id            = $serial->getId();
            $temp->title         = $serial->getTitle();
            $temp->originalTitle = $serial->getOriginalTitle();
            $user['serial'][]    = $temp;
        }

        foreach ($this->episode as $episode) {
            $temp                = new \stdClass();
            $temp->id            = $episode->getId();
            $temp->title         = $episode->getTitle();
            $temp->originalTitle = $episode->getOriginalTitle();
            $user['episode'][]   = $temp;
        }
        return $user;
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
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
     * Set registrationTime
     *
     * @param \DateTime $registrationTime
     *
     * @return User
     */
    public function setRegistrationTime($registrationTime)
    {
        $this->registrationTime = $registrationTime;

        return $this;
    }

    /**
     * Get registrationTime
     *
     * @return \DateTime
     */
    public function getRegistrationTime()
    {
        return $this->registrationTime;
    }

    /**
     * Add serial
     *
     * @param \ApiBundle\Entity\Serial $serial
     *
     * @return User
     */
    public function addSerial(\ApiBundle\Entity\Serial $serial)
    {
        $this->serial[] = $serial;

        return $this;
    }

    /**
     * Remove serial
     *
     * @param \ApiBundle\Entity\Serial $serial
     */
    public function removeSerial(\ApiBundle\Entity\Serial $serial)
    {
        $this->serial->removeElement($serial);
    }

    public function clearSerial(){
        $this->serial->clear();

        return $this;
    }

    /**
     * Get serial
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Add episode
     *
     * @param \ApiBundle\Entity\Episode $episode
     *
     * @return User
     */
    public function addEpisode(\ApiBundle\Entity\Episode $episode)
    {
        $this->episode[] = $episode;

        return $this;
    }

    /**
     * Remove episode
     *
     * @param \ApiBundle\Entity\Episode $episode
     */
    public function removeEpisode(\ApiBundle\Entity\Episode $episode)
    {
        $this->episode->removeElement($episode);
    }

    public function clearEpisode(){
        $this->episode->clear();

        return $this;
    }

    /**
     * Get episode
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->getEmail(),
            $this->getPassword(),
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password
        ) = unserialize($serialized);
    }
}
