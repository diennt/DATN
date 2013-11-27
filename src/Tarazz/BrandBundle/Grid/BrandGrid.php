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
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\Column;
use APY\DataGridBundle\Grid\Column\NumberColumn;
use Doctrine\ORM\QueryBuilder;
use Tarazz\CoreBundle\Grid\AbstractGrid;
use APY\DataGridBundle\Grid\Source\Entity;

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

                $qb->andWhere($qb->expr()->isNull("{$a}.parentId"));
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
//        $editAction = new RowAction('Edit', 'tarazz_brand.brand_detail');
//        $this->grid->addRowAction($editAction);

        // Add columns to the grid

        // ID column
        $idColumn = new NumberColumn(array(
            'title' => 'ID',
            'id' => 'id',
            'field' => 'id',
            'source' => true,
            'sortable' => true
        ));
        $this->grid->addColumn($idColumn);

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