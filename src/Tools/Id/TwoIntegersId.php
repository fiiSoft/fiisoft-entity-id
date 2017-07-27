<?php

namespace FiiSoft\Tools\Id;

use InvalidArgumentException;

abstract class TwoIntegersId extends TwoColumnsId
{
    /**
     * @param mixed $value
     * @param mixed $value2
     * @throws InvalidArgumentException
     * @return static
     */
    public static function from($value, $value2 = null)
    {
        if ($value instanceof static) {
            return $value;
        }
    
        if ($value2 !== null) {
            $v = [$value, $value2];
        } elseif (is_array($value) && count($value) === 2) {
            $v = array_values($value);
        } else {
            throw new InvalidArgumentException('Invalid argument');
        }
    
        if (is_string($v[0]) && is_numeric($v[0]) && ctype_digit($v[0])) {
            $v[0] = (int) $v[0];
        }
    
        if (is_string($v[1]) && is_numeric($v[1]) && ctype_digit($v[1])) {
            $v[1] = (int) $v[1];
        }
    
        return new static($v);
    }
    
    /**
     * @return mixed
     */
    protected function generate()
    {
        return [mt_rand(1, PHP_INT_MAX), mt_rand(1, PHP_INT_MAX)];
    }
    
    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     * @return void
     */
    protected function setValue($value)
    {
        if (!is_array($value) || count($value) !== 2
            || !isset($value[0], $value[1])
            || !is_int($value[0]) || $value[0] < 1
            || !is_int($value[1]) || $value[1] < 1
        ) {
            throw new InvalidArgumentException('Invalid argument');
        }
        
        $this->value = $value;
    }
}