<?php

namespace Tarazz\BrandBundle\Controller;

use Tarazz\CoreBundle\Controller\Controller as BaseController;

class BrandController extends BaseController
{
    public function gridAction()
    {
        $grid = $this->get('tarazz_brand.brand_grid');

        return $grid->getGridResponse('TarazzBrandBundle:Grid:view.html.twig');
    }
}
