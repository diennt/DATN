<?php

namespace Tarazz\BrandBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Tarazz\BrandBundle\Entity\Brand;
use Tarazz\BrandBundle\Form\Type\BrandType;
use Tarazz\BrandBundle\Form\Factory\BrandFactory;
use Tarazz\CoreBundle\Controller\Controller as BaseController;

class BrandController extends BaseController
{
    /**
     * View brand grid
     *
     * @return Response
     */
    public function gridAction()
    {
        $grid = $this->get('tarazz_brand.brand_grid');
        $dashboardUrl = $this->generateUrl('tarazz_core_homepage');
        $brandUrl = $this->generateUrl('tarazz_brand_grid');
        $breadcrumbs = array(
            'Home' => $dashboardUrl,
            'Brands' => $brandUrl,
        );

        return $grid->getGridResponse('TarazzBrandBundle:Grid:view.html.twig', array(
            'breadcrumbs' => $breadcrumbs,
        ));
    }

    /**
     * View brand detail
     */
    public function detailAction($id)
    {
        $request = $this->getRequest();
        /** @var $em EntityManager */
        $em = $this->getManager();
        $brandFactory = new BrandFactory($em);
        /** @var $brand Brand */
        $brand = $brandFactory->makeData($id);
        $form = $this->createForm(new BrandType($em), $brand);

        if ($request->getMethod() == "POST") {
            $form->submit($request);
            if ($form->isValid()) {
                $em->beginTransaction();
                try {
                    $brandName = $brand->getName();
                    if ($brand->getTitle() == '') {
                        $brand->setTitle($brandName);
                    }
                    if ($brand->getDescription() == '') {
                        $brand->setDescription($brandName);
                    }
                    $em->flush($brand);
                    $em->commit();

                    return $this->redirect(
                        $this->generateUrl('tarazz_brand_detail', array(
                            'id' => $id
                        ))
                    );
                } catch (\Exception $e) {
                    $em->rollback();
                    throw $e;
                }
            }
        }

        $brandName = $brand->getName();
        $brandUrl = $this->generateUrl('tarazz_brand_detail', array('id' => $id));

        return $this->render('TarazzBrandBundle:Brand:detail.html.twig', array(
            'id' => $id,
            'form' => $form->createView(),
            'breadcrumbs' => array(
                $brandName => $brandUrl
            )
        ));
    }

    public function render($view, array $parameters = array(), Response $response = null)
    {
        $dashboardUrl = $this->generateUrl('tarazz_core_homepage');
        $brandUrl = $this->generateUrl('tarazz_brand_grid');
        if (!isset($parameters['breadcrumbs'])) {
            $parameters['breadcrumbs'] = array();
        }
        $parameters['breadcrumbs'] = array_merge(
            array(
                'Home' => $dashboardUrl,
                'Brands' => $brandUrl,
            ),
            $parameters['breadcrumbs']
        );

        return parent::render($view, $parameters, $response);
    }
}
