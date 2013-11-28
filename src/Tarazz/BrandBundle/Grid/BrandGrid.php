<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 11/27/13
 * Time: 10:12 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Tarazz\BrandBundle\Grid;

use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Column\Column;
use APY\DataGridBundle\Grid\Column\NumberColumn;
use Doctrine\ORM\QueryBuilder;
use Tarazz\CoreBundle\Grid\AbstractGrid;
use Tarazz\CoreBundle\Grid\Column\DqlTextColumn;
use Tarazz\CoreBundle\Grid\Source\Entity;
use Tarazz\CoreBundle\Grid\Column\DqlNumberColumn;

class BrandGrid extends AbstractGrid
{
    /**
     * Setup grid
     *
     * @return mixed
     */
    public function setUp()
    {
        $em = $this->container->get('doctrine')->getManager();
        $source = new Entity('TarazzBrandBundle:Brand');

        $source->manipulateQuery(
            function($qb) {
                /** @var $qb QueryBuilder */
                $ra = $qb->getRootAliases();
                $a = reset($ra);

                $qb
                    ->leftJoin("{$a}.products", "p")
                    ->andWhere($qb->expr()->isNull("{$a}.parentId"));
            }
        );

        // Setup the grid
        $this->grid->setSource($source)
            ->setId('brand')
            ->setDefaultOrder("id", "desc")
        ;


        /**
         * Invisible all defaults columns
         * @var $column Column
         */
        foreach ($this->grid->getColumns() as $column) {
            $column->setVisible(false);
        }

        // Add mass action
        $activeAction = new MassAction('Mark as active', array('markAsActive'));
        $this->grid->addMassAction($activeAction);
        $inactiveAction = new MassAction('Mark as inactive', array('markAsInactive'));
        $this->grid->addMassAction($inactiveAction);

        // Add row action ( Edit action)
        // $editAction = new RowAction('Edit', 'tarazz_brand.brand_detail');
        // $this->grid->addRowAction($editAction);

        // Add columns to the grid
        // ID column
        $idColumn = new DqlNumberColumn(array(
            'id' => "idCol",
            'title' => 'ID',
            'source' => true
        ));
        $idColumn->setDqlField("__root__.id", "idCol");
        $this->grid->addColumn($idColumn);

        // Name column
        $nameColumn = new DqlTextColumn(array(
            'id' => "nameCol",
            'title' => 'Name',
            'source' => true
        ));
        $nameColumn->setDqlField("__root__.name", "nameCol");
        $this->grid->addColumn($nameColumn);

        // Active Column
        $activeColumn = new DqlTextColumn(array(
            'id' => "activeCol",
            'title' => 'Active',
            'source' => true
        ));
        $activeColumn->setDqlField("__root__.active", "activeCol");
        $this->grid->addColumn($activeColumn);

        // Products Column
        $productsColumn = new DqlTextColumn(array(
            'id' => "productsCol",
            'title' => 'Products',
            'source' => true
        ));
        $productsColumn->setDqlField("COUNT(p.id)", "productsCol");
        $this->grid->addColumn($productsColumn);
    }

    /**
     * Action set active list of brands
     *
     * @param array $ids
     */
    public function markAsActive(array $ids)
    {

    }

    /**
     * Action set inactive list of brand
     *
     * @param array $ids
     */
    public function markAsInactive(array $ids)
    {

    }
}