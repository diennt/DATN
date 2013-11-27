<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 11/27/13
 * Time: 11:52 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Tarazz\BrandBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tarazz\BrandBundle\Entity\Brand;


class LoadBrandData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $now = new \DateTime('now');
            $brand = new Brand();
            $brand->setName('brand ' . $i);
            $brand->setLogo('logo ' . $i);
            $brand->setActive(true);
            $brand->setParentId(null);
            $brand->setCreated($now);
            $brand->setUpdated($now);
            $manager->persist($brand);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}