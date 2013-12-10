<?php

namespace Tarazz\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    public function getManager()
    {
        $em = $this->getDoctrine()->getManager();

        return $em;
    }

    /**
     * {@inheritdoc}
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $breadcrumbs = array();
        if ($this->get('security.context')->isGranted('ROLE_REPORTS')
            || $this->get('security.context')->isGranted('ROLE_ORDERS_LIST')
            || $this->get('security.context')->isGranted('ROLE_ORDERS_VIEW')
            || $this->get('security.context')->isGranted('ROLE_ORDERS_EDIT')
            || $this->get('security.context')->isGranted('ROLE_ORDERS_ADMIN')
        ) {
            $breadcrumbs['Home'] = $this->generateUrl('tarazz_core_homepage');
        }

        if (!isset($parameters['breadcrumbs'])) {
            $parameters['breadcrumbs'] = $breadcrumbs;
        } else {
            $parameters['breadcrumbs'] = $breadcrumbs + $parameters['breadcrumbs'];
        }

        return parent::render($view, $parameters, $response);
    }
}
