<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\ExceptionHandling;

use Exception;
use Ouzo\Utilities\Arrays;

class OuzoException extends Exception
{
    private $_httpCode;
    private $_errors;
    private $_headers = array();

    public function __construct($httpCode, $errors, $headers = array())
    {
        $this->_httpCode = $httpCode;
        $this->_errors = Arrays::toArray($errors);
        $this->_headers = $headers;

        $firstError = Arrays::first($this->_errors);
        parent::__construct($firstError->getMessage(), $firstError->getCode());
    }

    public function getHttpCode()
    {
        return $this->_httpCode;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function asExceptionData()
    {
        return new OuzoExceptionData($this->_httpCode, $this->_errors, $this->getTraceAsString(), $this->getHeaders());
    }

    public function getHeaders()
    {
        return $this->_headers;
    }
}
