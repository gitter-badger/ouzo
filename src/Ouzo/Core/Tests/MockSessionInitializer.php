<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;

class MockSessionInitializer
{
    public function startSession()
    {
        $_SESSION = isset($_SESSION) ? $_SESSION : array();
    }
}
