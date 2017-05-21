<?php

namespace FiiSoft\Tools\Id;

use InvalidArgumentException;

abstract class IntegerId extends AbstractId
{
    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     * @return static
     */
    public static function from($value)
    {
        if ($value instanceof static) {
            return $value;
        }
    
        if (is_string($value) && is_numeric($value) && ctype_digit($value)) {
            $value = (int) $value;
        }
    
        return new static($value);
    }
    
    /**
     * @return integer
     */
    protected function generate()
    {
        return mt_rand(1, PHP_INT_MAX);
    }
    
    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     * @return void
     */
    protected function setValue($value)
    {
        if (!is_int($value) || $value < 1) {
            throw new InvalidArgumentException('Invalid argument');
        }
        
        $this->value = $value;
    }
    
    /**
     * @return string
     */
    final public function asString()
    {
        return (string) $this->value;
    }
}