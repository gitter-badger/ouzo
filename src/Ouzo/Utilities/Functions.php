<?php
namespace Ouzo\Utilities;

use Exception;

class Functions
{
    public static function extractId()
    {
        return function ($object) {
            return $object->getId();
        };
    }

    public static function extractField($name)
    {
        return function ($object) use ($name) {
            return $object->$name;
        };
    }

    public static function extractFieldRecursively($names)
    {
        return function ($object) use ($names) {
            return Objects::getValueRecursively($object, $names);
        };
    }

    public static function extractExpression($selector)
    {
        if (is_callable($selector)) {
            return $selector;
        } else if (!is_string($selector)) {
            throw new Exception('Invalid selector: ' . $selector);
        } else if (preg_match('/\(\)|->/', $selector)) {
            return Functions::extractFieldRecursively($selector);
        } else {
            return Functions::extractField($selector);
        }
    }

    public static function identity()
    {
        return function ($object) {
            return $object;
        };
    }

    public static function trim()
    {
        return function ($string) {
            return trim($string);
        };
    }

    public static function not($predicate)
    {
        return function ($object) use ($predicate) {
            return !$predicate($object);
        };
    }

    public static function isArray()
    {
        return function ($object) {
            return is_array($object);
        };
    }

    public static function prepend($prefix)
    {
        return function ($string) use ($prefix) {
            return $prefix . $string;
        };
    }

    public static function append($suffix)
    {
        return function ($string) use ($suffix) {
            return $string . $suffix;
        };
    }

    public static function notEmpty()
    {
        return function ($object) {
            return !empty($object);
        };
    }

    public static function notBlank()
    {
        return function ($string) {
            return Strings::isNotBlank($string);
        };
    }

    public static function removePrefix($prefix)
    {
        return function ($string) use ($prefix) {
            return Strings::removePrefix($string, $prefix);
        };
    }

    public static function startsWith($prefix)
    {
        return function ($string) use ($prefix) {
            return Strings::startsWith($string, $prefix);
        };
    }

    public static function formatDateTime($format = Date::DEFAULT_TIME_FORMAT)
    {
        return function ($date) use ($format) {
            return Date::formatDateTime($date, $format);
        };
    }

    public static function call($function, $argument)
    {
        return call_user_func($function, $argument);
    }

    /**
     * Returns the composition of two functions.
     * composition is defined as the function h such that h(a) == A(B(a)) for each a.
     * @param $functionA
     * @param $functionB
     * @return callable
     */
    public static function compose($functionA, $functionB)
    {
        return function ($input) use ($functionA, $functionB) {
            return Functions::call($functionA, Functions::call($functionB, $input));
        };
    }

    public static function toString()
    {
        return function ($object) {
            return Objects::toString($object);
        };
    }

    /**
     * @SuppressWarnings("unused")
     * $type is just a hint for dynamicReturnType plugin
     */
    public static function extract($type = null)
    {
        return new NonCallableExtractor();
    }

    public static function surroundWith($character)
    {
        return function ($string) use ($character) {
            return $character . $string . $character;
        };
    }
}