<?php

namespace FiiSoft\Test\Tools\Id;

use FiiSoft\Test\Stub\SimpleDoubleIntegersId;
use FiiSoft\Test\Stub\SimpleIntegerId;

class TwoIntegersIdTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_can_be_created_from_array_of_integers()
    {
        $id = new SimpleDoubleIntegersId([8, 12]);
        self::assertSame([8, 12], $id->value());
        self::assertSame('8,12', $id->asString());
        self::assertSame('8,12', (string) $id);
    }
    
    public function test_it_can_be_created_from_two_integers_arguments_by_factory_method()
    {
        $id = SimpleDoubleIntegersId::from(2, 3);
        self::assertInstanceOf(SimpleDoubleIntegersId::class, $id);
        self::assertSame([2, 3], $id->value());
    }
    
    public function test_it_can_be_created_from_other_object_by_factory_method()
    {
        $other = SimpleDoubleIntegersId::from([2,3]);
        $id = SimpleDoubleIntegersId::from($other);
        
        self::assertInstanceOf(SimpleDoubleIntegersId::class, $id);
        self::assertSame([2, 3], $id->value());
        self::assertSame($id, $other);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid argument
     */
    public function test_it_cannot_be_created_from_object_of_different_type()
    {
        SimpleDoubleIntegersId::from(new SimpleIntegerId(5));
    }
    
    public function test_it_can_be_created_from_two_numeric_strings_by_factory_method()
    {
        $id = SimpleDoubleIntegersId::from('1', '8');
        self::assertSame([1, 8], $id->value());
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_cannot_be_created_by_factory_method_for_invalid_arguments()
    {
        SimpleDoubleIntegersId::from(5);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_cannot_be_created_from_invalid_values()
    {
        new SimpleDoubleIntegersId([3, 'a']);
    }
    
    public function test_it_can_be_generated_with_default_values_if_not_provided()
    {
        $id = new SimpleDoubleIntegersId();
        self::assertInternalType('array', $id->value());
        self::assertCount(2, $id->value());
    
        foreach ($id->value() as $value) {
            self::assertInternalType('integer', $value);
            self::assertGreaterThanOrEqual(1, $value);
        }
    }
}
