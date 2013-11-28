<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 11/28/13
 * Time: 4:49 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Tarazz\CoreBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class DqlColumn
 * @package Tarazz\CoreBundle\Grid\Column
 */
class DqlColumn extends Column
{
    /**
     * @var string
     */
    protected $dqlFieldExpr;

    /**
     * @var string
     */
    protected $dqlFieldAlias;

    /**
     * @return string
     */
    public function getType()
    {
        return 'dql';
    }

    /**
     * @param string $dqlFieldExpr
     * @param string $dqlFieldAlias
     * @return $this
     */
    public function setDqlField($dqlFieldExpr, $dqlFieldAlias = '')
    {
        $this->dqlFieldExpr = $dqlFieldExpr;
        $this->dqlFieldAlias = $dqlFieldAlias;

        return $this;
    }

    /**
     * @return string
     */
    public function getDqlFieldExpr()
    {
        return $this->dqlFieldExpr;
    }

    /**
     * @return string
     */
    public function getDqlFieldAlias()
    {
        return $this->dqlFieldAlias;
    }

    /**
     * @param null $matches
     * @return bool|int
     */
    public function hasDQLFunction(&$matches = null)
    {
        $regex = '/(GROUP_CONCAT)|(SUM)|(COUNT)/i';

        if (preg_match($regex, $this->dqlFieldExpr)) {

            return true;
        }

        return parent::hasDQLFunction($matches);
    }
}