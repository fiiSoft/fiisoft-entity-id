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
            if (!property_exists($this, $name)) {
                return false;
            }
    
            $prop = $this->$name;
            
            if ($prop instanceof Id) {
                if (!$prop->equals($value)) {
                    return false;
                }
            } elseif ($value instanceof Id) {
                if (!$value->equals($prop)) {
                    return false;
                }
            } elseif ($prop !== $value) {
                return false;
            }
        }
        
        return true;
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