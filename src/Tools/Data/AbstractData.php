<?php

namespace FiiSoft\Tools\Data;

use FiiSoft\Tools\Id\Id;
use RuntimeException;

abstract class AbstractData
{
    /** @var string */
    protected $isNotEqualBecause = '';
    
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
            if ($value !== null && $name !== 'isNotEqualBecause' && property_exists($this, $name)) {
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
        $objectVars = get_object_vars($this);
        unset($objectVars['isNotEqualBecause']);
        
        if ($notNull) {
            return array_filter($objectVars, function ($value) {
                return $value !== null;
            });
        }
        
        return $objectVars;
    }
    
    /**
     * @param array $conditions
     * @return bool
     */
    final public function equalsConditions(array $conditions)
    {
        foreach ($conditions as $name => $value) {
            if ($name !== 'isNotEqualBecause'
                && property_exists($this, $name)
                && $this->areValuesTheSame($this->$name, $value)
            ) {
                continue;
            }
            
            return false;
        }
        
        return true;
    }
    
    /**
     * @param self $other
     * @throws RuntimeException
     * @return bool
     */
    public function equals($other)
    {
        $this->isNotEqualBecause = '';
        
        if ($this === $other) {
            return true;
        }
        
        if (! $other instanceof $this) {
            $this->isNotEqualBecause = 'Other object has no the same type '.get_class($this);
            return false;
        }
        
        $myData = $this->toArray();
        $otherData = $other->toArray();
        $pkName = $this->pkName();
        
        if (isset($myData[$pkName]) XOR isset($otherData[$pkName])) {
            unset($myData[$pkName], $otherData[$pkName]);
        } elseif (isset($myData[$pkName], $otherData[$pkName]) && $myData[$pkName] !== $otherData[$pkName]) {
            $this->isNotEqualBecause = 'Primary keys are different ('.$myData[$pkName].' vs '.$otherData[$pkName].')';
            return false;
        }
        
        if (count($myData) !== count($otherData)) {
            $this->isNotEqualBecause = 'Number od fields in data are different ('
                .print_r($myData, true).' vs '.print_r($otherData, true).')';
            return false;
        }
        
        foreach ($otherData as $key => $value) {
            if (!array_key_exists($key, $myData)) {
                $this->isNotEqualBecause = 'There is no field "'.$key.'" in my data';
                return false;
            }
            
            if (!$this->areValuesTheSame($value, $myData[$key])) {
                $this->isNotEqualBecause = 'The field "'.$key.'" has different value: mine is '
                    .$myData[$key].' and other is '.$value;
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Get name of PK column.
     * If PK is multicolumn, then return name of first (most important) column in PK.
     *
     * @throws RuntimeException
     * @return string
     */
    protected function pkName()
    {
        $props = get_object_vars($this);
        unset($props['isNotEqualBecause']);
        
        $props = array_keys($props);
        if ($props) {
            return reset($props);
        }
        
        throw new RuntimeException('Cannot determine name of PK column for '.get_class($this));
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
            if ($name !== 'isNotEqualBecause') {
                $this->$name = null;
            }
        }
    }
    
    /**
     * @return string
     */
    public function isNotEqualBecause()
    {
        return $this->isNotEqualBecause;
    }
}