<?php

namespace Tarazz\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class Controller extends BaseController
{
    public function getManager()
    {
        $em = $this->getDoctrine()->getManager();

        return $em;
    }
}
