<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SessionRepository")
 * @ORM\Table(name="sessions")
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\Column(type="binary", length=128)
     */
    protected $sess_id;

    /**
     * @ORM\Column(type="blob")
     */
    protected $sess_data;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sess_time;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sess_lifetime;

    /**
     * Set sess_id
     *
     * @param binary $sessId
     * @return Session
     */
    public function setSessId($sessId)
    {
        $this->sess_id = $sessId;

        return $this;
    }

    /**
     * Get sess_id
     *
     * @return binary 
     */
    public function getSessId()
    {
        return $this->sess_id;
    }

    /**
     * Set sess_data
     *
     * @param string $sessData
     * @return Session
     */
    public function setSessData($sessData)
    {
        $this->sess_data = $sessData;

        return $this;
    }

    /**
     * Get sess_data
     *
     * @return string 
     */
    public function getSessData()
    {
        return $this->sess_data;
    }

    /**
     * Set sess_time
     *
     * @param integer $sessTime
     * @return Session
     */
    public function setSessTime($sessTime)
    {
        $this->sess_time = $sessTime;

        return $this;
    }

    /**
     * Get sess_time
     *
     * @return integer 
     */
    public function getSessTime()
    {
        return $this->sess_time;
    }

    /**
     * Set sess_lifetime
     *
     * @param integer $sessLifetime
     * @return Session
     */
    public function setSessLifetime($sessLifetime)
    {
        $this->sess_lifetime = $sessLifetime;

        return $this;
    }

    /**
     * Get sess_lifetime
     *
     * @return integer 
     */
    public function getSessLifetime()
    {
        return $this->sess_lifetime;
    }
}
