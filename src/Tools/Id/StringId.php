<?php

namespace FiiSoft\Tools\Id;

use InvalidArgumentException;

abstract class StringId extends AbstractId
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
        
        return new static($value);
    }
    
    /**
     * @return string
     */
    protected function generate()
    {
        return str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    }
    
    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     * @return void
     */
    protected function setValue($value)
    {
        if (!is_string($value) || $value === '') {
            throw new InvalidArgumentException('Invalid argument');
        }
        
        $this->value = $value;
    }
    
    /**
     * @return string
     */
    final public function asString()
    {
        return $this->value;
    }
    
    /**
     * @param mixed $other
     * @throws InvalidArgumentException
     * @return int integer less, equal or greather than 0
     */
    final public function compare($other)
    {
        if ($other instanceof $this) {
            return strcmp($this->value, $other->value);
        }
    
        throw new InvalidArgumentException('Invalid type of param other');
    }
}