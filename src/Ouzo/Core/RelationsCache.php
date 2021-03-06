<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo;

class RelationsCache
{
    private static $_relations = array();

    /**
     * @param $modelClass
     * @param $params
     * @param $primaryKeyName
     * @return Relations
     */
    public static function getRelations($modelClass, $params, $primaryKeyName)
    {
        if (!isset(self::$_relations[$modelClass])) {
            self::$_relations[$modelClass] = new Relations(get_called_class(), $params, $primaryKeyName);
        }
        return self::$_relations[$modelClass];
    }
}
