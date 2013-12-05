<?php

namespace Tarazz\BrandBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
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

        return $grid->getGridResponse('TarazzBrandBundle:Grid:view.html.twig');
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
        $brand = $brandFactory->makeData($id);
        $form = $this->createForm(new BrandType($em), $brand);

        if ($request->getMethod() == "POST") {
            $form->submit($request);
            if ($form->isValid()) {
                $em->beginTransaction();
                try {
                    $em->flush($brand);
                    $em->commit();

                    $this->redirect(
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

        return $this->render('TarazzBrandBundle:Brand:detail.html.twig', array(
            'id' => $id,
            'form' => $form->createView()
        ));
    }
}
