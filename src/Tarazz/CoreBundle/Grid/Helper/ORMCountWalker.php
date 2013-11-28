<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 11/28/13
 * Time: 6:09 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Tarazz\CoreBundle\Grid\Helper;

use APY\DataGridBundle\Grid\Helper\ORMCountWalker as BaseWalker;
use Doctrine\ORM\Query\AST\AggregateExpression;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\AST\SelectExpression;
use Doctrine\ORM\Query\AST\SelectStatement;

class ORMCountWalker extends BaseWalker
{
    public function walkSelectStatement(SelectStatement $AST)
    {
        $rootComponents = array();
        foreach ($this->_getQueryComponents() AS $dqlAlias => $qComp) {
            if (array_key_exists('parent', $qComp) && $qComp['parent'] === null && $qComp['nestingLevel'] == 0) {
                $rootComponents[] = array($dqlAlias => $qComp);
            }
        }

        if (count($rootComponents) > 1) {
            throw new \RuntimeException("Cannot count query which selects two FROM components, cannot make distinction");
        }

        $root = reset($rootComponents);
        $parentName = key($root);
        $parent = current($root);

        $pathExpression = new PathExpression(
            PathExpression::TYPE_STATE_FIELD | PathExpression::TYPE_SINGLE_VALUED_ASSOCIATION, $parentName,
            $parent['metadata']->getSingleIdentifierFieldName()
        );
        $pathExpression->type = PathExpression::TYPE_STATE_FIELD;


        // Remove the variables which are not used by other clauses
        foreach ($AST->selectClause->selectExpressions as $key => $selectExpression) {
            if ($selectExpression->fieldIdentificationVariable == null) {
                unset($AST->selectClause->selectExpressions[$key]);
            } elseif ($selectExpression->expression instanceof PathExpression) {
                $groupByClause[] = $selectExpression->expression;
            }
        }

        // Put the count expression in the first position
        $distinct = $this->_getQuery()->getHint(self::HINT_DISTINCT);
        $AST->selectClause->selectExpressions = array (
            new SelectExpression(
                new AggregateExpression('count', $pathExpression, $distinct), null
            )
        );

        $groupByClause[] = $pathExpression;
        $AST->groupByClause = new \Doctrine\ORM\Query\AST\GroupByClause($groupByClause);

        // ORDER BY is not needed, only increases query execution through unnecessary sorting.
        $AST->orderByClause = null;
    }

}