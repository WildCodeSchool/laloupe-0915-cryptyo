<?php
// src/CryptYO/HomeBundle/Entity/User.php

namespace CryptYO\HomeBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="CryptYO\HomeBundle\Entity\UserRepository")
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
     * @ORM\ManyToMany(targetEntity="CryptYO\HomeBundle\Entity\User", mappedBy="friends")
     */

    private $friends;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }




    // GENERATED CODE

    /**
     * Add friend
     *
     * @param \CryptYO\HomeBundle\Entity\User $friend
     *
     * @return User
     */
    public function addFriend(\CryptYO\HomeBundle\Entity\User $friend)
    {
        $this->friends[] = $friend;

        return $this;
    }

    /**
     * Remove friend
     *
     * @param \CryptYO\HomeBundle\Entity\User $friend
     */
    public function removeFriend(\CryptYO\HomeBundle\Entity\User $friend)
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends()
    {
        return $this->friends;
    }
}
