<?php

namespace Tarazz\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TarazzCoreBundle:Default:index.html.twig', array('name' => 'diennt'));
    }
}
