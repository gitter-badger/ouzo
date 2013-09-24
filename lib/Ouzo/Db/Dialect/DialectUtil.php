<?php
namespace Ouzo\Db\Dialect;

use Ouzo\Db\QueryType;
use Ouzo\Db\WhereClause;
use Ouzo\Utilities\FluentArray;

class DialectUtil
{
    public static function buildQueryPrefix($type)
    {
        return $type == QueryType::$DELETE ? 'DELETE' : 'SELECT';
    }

    public static function _addAliases()
    {
        return function ($alias, $column) {
            return $column . (is_string($alias) ? ' AS ' . $alias : '');
        };
    }

    public static function buildWhereQuery($whereClauses)
    {
        $parts = FluentArray::from($whereClauses)
            ->filter(WhereClause::isNotEmptyFunction())
            ->map('\Ouzo\Db\Dialect\DialectUtil::buildWhereQueryPart')
            ->toArray();
        return implode(' AND ', $parts);
    }

    public static function buildWhereQueryPart($whereClause)
    {
        $wherePart = is_array($whereClause->where) ? implode(' AND ', self::_buildWhereKeys($whereClause->where)) : $whereClause->where;
        return stripos($wherePart, 'OR') ? '(' . $wherePart . ')' : $wherePart;
    }

    private static function _buildWhereKeys($params)
    {
        $keys = array();
        foreach ($params as $key => $value) {
            $keys[] = self::_buildWhereKey($value, $key);
        }
        return $keys;
    }

    private static function _buildWhereKey($value, $key)
    {
        if (is_array($value)) {
            $in = implode(', ', array_fill(0, count($value), '?'));
            return $key . ' IN (' . $in . ')';
        }
        return $key . ' = ?';
    }
}