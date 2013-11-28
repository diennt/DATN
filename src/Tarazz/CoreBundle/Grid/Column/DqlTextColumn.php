<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 11/28/13
 * Time: 4:46 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Tarazz\CoreBundle\Grid\Column;

use Tarazz\CoreBundle\Grid\Column\DqlColumn as Column;
use APY\DataGridBundle\Grid\Filter;

/**
 * Class DqlColumn
 * @package Tarazz\CoreBundle\Grid\Column
 */
class DqlTextColumn extends Column
{
    public function isQueryValid($query)
    {
        $result = array_filter((array) $query, "is_string");

        return !empty($result);
    }

    public function getFilters($source)
    {
        $parentFilters = parent::getFilters($source);

        $filters = array();
        /** @var $parentFilters Filter[] */
        foreach($parentFilters as $filter) {
            switch ($filter->getOperator()) {
                case self::OPERATOR_ISNULL:
                    $filters[] =  new Filter(self::OPERATOR_ISNULL);
                    $filters[] =  new Filter(self::OPERATOR_EQ, '');
                    $this->setDataJunction(self::DATA_DISJUNCTION);
                    break;
                case self::OPERATOR_ISNOTNULL:
                    $filters[] =  new Filter(self::OPERATOR_ISNOTNULL);
                    $filters[] =  new Filter(self::OPERATOR_NEQ, '');
                    break;
                default:
                    $filters[] = $filter;
            }
        }

        return $filters;
    }
}