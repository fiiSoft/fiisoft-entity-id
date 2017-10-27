<?php

namespace FiiSoft\Tools\Id;

use InvalidArgumentException;

interface Id
{
    /**
     * Create instance of Id from some value.
     *
     * @param mixed $value
     * @throws InvalidArgumentException if cannot create from given param
     * @return static
     */
    public static function from($value);
    
    /**
     * Get encapsulated value as-it-is.
     *
     * @return mixed encapsulated value
     */
    public function value();
    
    /**
     * Tell if given param is considered as equal to value encapsulated by this Id.
     *
     * @param mixed $id
     * @return bool
     */
    public function equals($id);
    
    /**
     * Get textual representation of string.
     * In most cases result of this method and __toString() is the same, but it is not required.
     *
     * @return string
     */
    public function asString();
    
    /**
     * Sometimes it's neccessary to compare identifiers (in example to sort them).
     * In this case this method should be use and it must return integer less then, equal or greather then zero
     * if value of this Id is considered as less, equal or greater than value of Id passed as argument.
     *
     * @param mixed $other
     * @throws InvalidArgumentException if given param cannot be compared
     * @return int integer less, equal or greather than 0
     */
    public function compare($other);
    
    /**
     * Id must be convertable to string, although result of this method do not have to be the same like asString().
     *
     * @return string
     */
    public function __toString();
}