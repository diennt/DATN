<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 12/5/13
 * Time: 5:13 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Tarazz\BrandBundle\Form\Factory;


use Doctrine\ORM\EntityManager;

class BrandFactory
{
    /**
     * @var EntityManager
     */
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function makeData($id)
    {
        $brand = $this->em->getRepository("TarazzBrandBundle:Brand")
            ->findOneBy(array('id' => $id));

        return $brand;
    }
}