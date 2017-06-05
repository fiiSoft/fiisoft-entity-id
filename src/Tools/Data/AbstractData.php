<?php

namespace FiiSoft\Tools\Data;

use FiiSoft\Tools\Id\Id;

abstract class AbstractData
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }
    
    /**
     * @param array $data
     * @return void
     */
    final public function setData(array $data = [])
    {
        foreach ($data as $name => $value) {
            if ($value !== null && property_exists($this, $name)) {
                $this->$name = $value;
            }
        }
    }
    
    /**
     * @param bool $notNull (default true) if true then filter out null values from array
     * @return array
     */
    final public function toArray($notNull = true)
    {
        if ($notNull) {
            return array_filter(get_object_vars($this), function ($value) {
                return $value !== null;
            });
        }
        
        return get_object_vars($this);
    }
    
    /**
     * @param array $conditions
     * @return bool
     */
    final public function equalsConditions(array $conditions)
    {
        foreach ($conditions as $name => $value) {
            if (property_exists($this, $name) && $this->areValuesTheSame($this->$name, $value)) {
                continue;
            }
            
            return false;
        }
        
        return true;
    }
    
    /**
     * @param mixed $prop
     * @param mixed $value
     * @return bool
     */
    protected function areValuesTheSame($prop, $value)
    {
        if ($prop instanceof Id) {
            return $prop->equals($value);
        }
        
        if ($value instanceof Id) {
            return $value->equals($prop);
        }
        
        return $prop === $value;
    }
    
    /**
     * Set values of all properties to null.
     *
     * @return void
     */
    final public function clear()
    {
        foreach (array_keys(get_object_vars($this)) as $name) {
            $this->$name = null;
        }
    }
}