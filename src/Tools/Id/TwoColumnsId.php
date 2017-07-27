<?php

namespace FiiSoft\Tools\Id;

use InvalidArgumentException;
use LogicException;

abstract class TwoColumnsId extends AbstractId
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
        
        return new static($v);
    }
    
    /**
     * @throws LogicException
     * @return mixed
     */
    protected function generate()
    {
        throw new LogicException('Operation not supported');
    }
    
    /**
     * @return string
     */
    final public function asString()
    {
        return implode(',', $this->value);
    }
}