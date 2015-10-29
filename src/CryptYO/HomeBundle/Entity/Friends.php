<?php

namespace CryptYO\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Friends
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Friends
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="CryptYO\HomeBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $friendOne;

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="CryptYO\HomeBundle\Entity\User", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $friendTwo;


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
     * Set friendOne
     *
     * @param integer $friendOne
     *
     * @return Friends
     */
    public function setFriendOne($friendOne)
    {
        $this->friendOne = $friendOne;

        return $this;
    }

    /**
     * Get friendOne
     *
     * @return integer
     */
    public function getFriendOne()
    {
        return $this->friendOne;
    }

    /**
     * Set friendTwo
     *
     * @param integer $friendTwo
     *
     * @return Friends
     */
    public function setFriendTwo($friendTwo)
    {
        $this->friendTwo = $friendTwo;

        return $this;
    }

    /**
     * Get friendTwo
     *
     * @return integer
     */
    public function getFriendTwo()
    {
        return $this->friendTwo;
    }
}

