<?php

namespace AppBundle\Entity;

use Application\Sonata\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 * @ORM\Table(name="fos_user_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="vkontakte_id", type="string", length=255, nullable=true)
     */
    protected $vkontakte_id;

    /**
     * @ORM\Column(name="vkontakte_access_token", type="string", length=255, nullable=true)
     */
    protected $vkontakte_access_token;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="sender")
     */
    protected $messages;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="receiver")
     */
    protected $privates;

    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    protected $avatar;

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
     * Set vkontakte_id
     *
     * @param string $vkontakteId
     * @return User
     */
    public function setVkontakteId($vkontakteId)
    {
        $this->vkontakte_id = $vkontakteId;

        return $this;
    }

    /**
     * Get vkontakte_id
     *
     * @return string 
     */
    public function getVkontakteId()
    {
        return $this->vkontakte_id;
    }

    /**
     * Set vkontakte_access_token
     *
     * @param string $vkontakteAccessToken
     * @return User
     */
    public function setVkontakteAccessToken($vkontakteAccessToken)
    {
        $this->vkontakte_access_token = $vkontakteAccessToken;

        return $this;
    }

    /**
     * Get vkontakte_access_token
     *
     * @return string 
     */
    public function getVkontakteAccessToken()
    {
        return $this->vkontakte_access_token;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add messages
     *
     * @param \AppBundle\Entity\Message $messages
     * @return User
     */
    public function addMessage(\AppBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages
     *
     * @param \AppBundle\Entity\Message $messages
     */
    public function removeMessage(\AppBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    public function setSalt($salt)
    {
        if (!$this->salt) {
            $this->salt = $salt;
        }
    }


    /**
     * Add privates
     *
     * @param \AppBundle\Entity\Message $privates
     * @return User
     */
    public function addPrivate(\AppBundle\Entity\Message $privates)
    {
        $this->privates[] = $privates;

        return $this;
    }

    /**
     * Remove privates
     *
     * @param \AppBundle\Entity\Message $privates
     */
    public function removePrivate(\AppBundle\Entity\Message $privates)
    {
        $this->privates->removeElement($privates);
    }

    /**
     * Get privates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrivates()
    {
        return $this->privates;
    }

    /**
     * Set avatar
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $avatar
     * @return User
     */
    public function setAvatar(\Application\Sonata\MediaBundle\Entity\Media $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
