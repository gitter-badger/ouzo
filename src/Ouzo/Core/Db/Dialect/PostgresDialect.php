<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Db\Dialect;

use Ouzo\Utilities\Arrays;

class PostgresDialect extends Dialect
{
    public function getConnectionErrorCodes()
    {
        return array('57000', '57014', '57P01', '57P02', '57P03');
    }

    public function getErrorCode($errorInfo)
    {
        return Arrays::getValue($errorInfo, 0);
    }
}
