<?php

namespace FiiSoft\Tools\Id;

use InvalidArgumentException;
use LogicException;

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
     * @throws LogicException
     * @return integer
     */
    protected function generate()
    {
        throw new LogicException('Operation not supported');
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
}