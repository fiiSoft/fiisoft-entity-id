<?php

namespace FiiSoft\Test\Tools\Id;

use FiiSoft\Test\Stub\SimpleDoubleIntegersId;
use FiiSoft\Test\Stub\SimpleIntegerId;

class IntegerIdTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_encapsulates_integer_value()
    {
        $id = new SimpleIntegerId(15);
        
        self::assertSame(15, $id->value());
        self::assertSame('15', $id->asString());
        self::assertSame('15', (string) $id);
        
        self::assertTrue($id->equals($id));
        self::assertTrue($id->equals(new SimpleIntegerId(15)));
        self::assertTrue($id->equals(15));
        
        self::assertFalse($id->equals(10));
        self::assertFalse($id->equals('15'));
        self::assertFalse($id->equals(new SimpleIntegerId(10)));
    }
    
    public function test_it_can_generate_some_random_value()
    {
        $id = new SimpleIntegerId();
        
        self::assertInternalType('integer', $id->value());
        self::assertGreaterThanOrEqual(1, $id->value());
    }
    
    public function test_it_allows_only_for_values_integers_greather_than_or_equal_one()
    {
        try {
            new SimpleIntegerId('non integer');
            self::fail('Exception expected');
        } catch (\InvalidArgumentException $e) {
            self::assertSame('Invalid argument', $e->getMessage());
        }
        
        try {
            new SimpleIntegerId(-15);
            self::fail('Exception expected');
        } catch (\InvalidArgumentException $e) {
            self::assertSame('Invalid argument', $e->getMessage());
        }
    }
    
    public function test_it_allows_to_create_id_object_from_other_object_by_static_factory_method()
    {
        $other = new SimpleIntegerId(15);
        $id = SimpleIntegerId::from($other);
        
        self::assertInstanceOf(SimpleIntegerId::class, $id);
        self::assertSame(15, $id->value());
        self::assertSame($id, $other);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid argument
     */
    public function test_it_disallows_to_create_object_from_other_object_of_different_type()
    {
        SimpleIntegerId::from(new SimpleDoubleIntegersId([14, 22]));
    }
    
    public function test_it_allows_to_create_id_object_from_integer_by_static_factory_method()
    {
        $id = SimpleIntegerId::from(15);
        self::assertInstanceOf(SimpleIntegerId::class, $id);
        self::assertSame(15, $id->value());
    }
    
    public function test_it_allows_to_create_id_object_from_numeric_string_by_factory_method()
    {
        $id = SimpleIntegerId::from('15');
        self::assertInstanceOf(SimpleIntegerId::class, $id);
        self::assertSame(15, $id->value());
    }
}
