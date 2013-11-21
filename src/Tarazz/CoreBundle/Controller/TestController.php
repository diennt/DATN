<?php

namespace Tarazz\CoreBundle\Controller;

use Tarazz\CoreBundle\Controller\Controller;

class TestController extends Controller
{
    public function indexAction()
    {
        return $this->render('TarazzCoreBundle:Default:index.html.twig', array('name' => 'diennt'));
    }
}