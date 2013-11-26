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

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}