<?php

namespace Tarazz\AuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected  $id;

    /**
     * @var integer
     */
    private $groupId;

    /**
     * @var integer
     */
    private $timeZoneId;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set groupId
     *
     * @param integer $groupId
     * @return User
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set timeZoneId
     *
     * @param integer $timeZoneId
     * @return User
     */
    public function setTimeZoneId($timeZoneId)
    {
        $this->timeZoneId = $timeZoneId;
    
        return $this;
    }

    /**
     * Get timeZoneId
     *
     * @return integer 
     */
    public function getTimeZoneId()
    {
        return $this->timeZoneId;
    }
}