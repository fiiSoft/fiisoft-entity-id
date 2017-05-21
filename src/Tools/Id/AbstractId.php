<?php

namespace FiiSoft\Tools\Id;

abstract class AbstractId implements Id
{
    /** @var mixed */
    protected $value;
    
    /**
     * @param mixed|null $value
     */
    public function __construct($value = null)
    {
        if ($value === null) {
            $value = $this->generate();
        }
        
        $this->setValue($value);
    }
    
    /**
     * @return string
     */
    final public function __toString()
    {
        return $this->asString();
    }
    
    /**
     * @return mixed
     */
    final public function value()
    {
        return $this->value;
    }
    
    /**
     * @param mixed $id
     * @return bool
     */
    final public function equals($id)
    {
        if ($this === $id) {
            return true;
        }
    
        if (is_object($id)) {
            return $id instanceof $this && $this->value === $id->value;
        }
        
        return $this->value === $id;
    }
    
    /**
     * @return mixed
     */
    abstract protected function generate();
    
    /**
     * @param mixed $value
     * @return void
     */
    abstract protected function setValue($value);
}