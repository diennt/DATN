<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 11/28/13
 * Time: 4:45 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Tarazz\CoreBundle\Grid\Source;

use APY\DataGridBundle\Grid\Column\Column;
use APY\DataGridBundle\Grid\Source\Entity as BaseEntity;
use Doctrine\ORM\NoResultException;
use Tarazz\CoreBundle\Grid\Column\DqlColumn;
use APY\DataGridBundle\Grid\Helper\ORMCountWalker;
use Doctrine\ORM\Query;

/**
 * Class Entity
 * @package Tarazz\CoreBundle\Grid\Source
 */
class Entity extends BaseEntity
{
    /**
     * Distinct mode hint name
     */
    const HINT_DISTINCT = 'doctrine_paginator.distinct';

    /**
     * @param Column $column
     * @param bool $withAlias
     * @return string
     * @throws \LogicException
     */
    protected function getFieldName($column, $withAlias = -1)
    {
        if ('dql' === $column->getType() ) {
            /** @var $column DqlColumn */
            $dqlFieldExpr = $column->getDqlFieldExpr();

            if (!$dqlFieldExpr) {
                throw new \LogicException('DQL field expression has not been defined');
            }

            $dqlFieldExpr = str_replace('__root__', $this->tableAlias, $dqlFieldExpr);
            $dqlFieldAlias = $column->getDqlFieldAlias();
            $dqlFieldAlias = $dqlFieldAlias ?: '_dql_' . md5($dqlFieldExpr);

            if (-1 === $withAlias) {
                return $dqlFieldAlias;
            } elseif (false === $withAlias) {
                return $dqlFieldExpr;
            }

            return $dqlFieldExpr . ' as ' . $dqlFieldAlias;
        }

        return parent::getFieldName($column, $withAlias);
    }

    /**
     * @param null $maxResults
     *
     * @return int|number
     */
    public function getTotalCount($maxResults = null)
    {
        // From Doctrine\ORM\Tools\Pagination\Paginator::count()
        $countQuery = $this->query->getQuery();

        if (!$countQuery->getHint(ORMCountWalker::HINT_DISTINCT)) {
            $countQuery->setHint(ORMCountWalker::HINT_DISTINCT, true);
        }

        $countQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('Tarazz\CoreBundle\Grid\Helper\ORMCountWalker'));
        $countQuery->setFirstResult(null)->setMaxResults($maxResults);

        try {
            $data  = $countQuery->getScalarResult();
            $data  = array_map('current', $data);
            $count = array_sum($data);
        } catch (NoResultException $e) {
            $count = 0;
        }

        return $count;
    }
}