<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 11/27/13
 * Time: 10:35 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Tarazz\BrandBundle\Services;


class TestService
{
    private $container;

    function __construct($container)
    {
        $this->container = $container;
    }

    public function test()
    {
        return 5;
    }
}