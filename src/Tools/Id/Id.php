<?php

namespace FiiSoft\Tools\Id;

use InvalidArgumentException;

interface Id
{
    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     * @return static
     */
    public static function from($value);
    
    /**
     * @return mixed
     */
    public function value();
    
    /**
     * @param mixed $id
     * @return bool
     */
    public function equals($id);
    
    /**
     * @return string
     */
    public function asString();
}