<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 11/28/13
 * Time: 5:13 PM
 * To change this template use File | Settings | File Templates.
 */


namespace Tarazz\CoreBundle\Grid\Column;

use Tarazz\CoreBundle\Grid\Column\DqlColumn as Column;

/**
 * Class DqlColumn
 * @package Tarazz\CoreBundle\Grid\Column
 */
class DqlDateTimeColumn extends Column
{
    public function __initialize(array $params)
    {
        $params['filter'] = 'select';
        $params['selectFrom'] = 'values';
        $params['operators'] = array(self::OPERATOR_EQ);
        $params['defaultOperator'] = self::OPERATOR_EQ;
        $params['operatorsVisible'] = false;
        $params['selectMulti'] = false;

        parent::__initialize($params);

        $this->setAlign($this->getParam('align', 'center'));
        $this->setSize($this->getParam('size', '30'));
        $this->setValues($this->getParam('values', array(1 => 'true', 0 => 'false')));
    }

    public function isQueryValid($query)
    {
        $query = (array) $query;
        if ($query[0] === true || $query[0] === false || $query[0] == 0 || $query[0] == 1 ) {
            return true;
        }

        return false;
    }

    public function renderCell($value, $row, $router)
    {
        $value = parent::renderCell($value, $row, $router);

        return $value ?: 'false';
    }

    public function getDisplayedValue($value)
    {
        return is_bool($value) ? ($value ? 1 : 0) : $value;
    }
}