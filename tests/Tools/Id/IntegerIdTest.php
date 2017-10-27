<?php

namespace FiiSoft\Test\Tools\Id;

use FiiSoft\Test\Stub\OtherIntegerId;
use FiiSoft\Test\Stub\SimpleDoubleIntegersId;
use FiiSoft\Test\Stub\SimpleIntegerId;
use FiiSoft\Tools\Id\Id;

class IntegerIdTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_encapsulates_integer_value()
    {
        $id = new SimpleIntegerId(15);
        
        self::assertSame(15, $id->value());
    }
    
    public function test_it_can_be_casted_to_string()
    {
        $id = new SimpleIntegerId(15);
    
        self::assertSame('15', $id->asString());
        self::assertSame('15', (string) $id);
    }
    
    public function test_it_can_tell_if_is_equal_to_other_value()
    {
        $id = new SimpleIntegerId(15);
        
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
     * @dataProvider getDataForTestItDisallowsToCreateObjectFromOtherObjectOfDifferentType
     */
    public function test_it_disallows_to_create_object_from_other_object_of_different_type(Id $id)
    {
        SimpleIntegerId::from($id);
    }
    
    public function getDataForTestItDisallowsToCreateObjectFromOtherObjectOfDifferentType()
    {
        return [
            [new SimpleDoubleIntegersId([14, 22])],
            [new OtherIntegerId(10)],
        ];
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
    
    public function test_it_allows_to_compare_values_of_id()
    {
        $id = SimpleIntegerId::from(20);
        $other = SimpleIntegerId::from(20);
        
        self::assertSame(0, $id->compare($other));
        self::assertSame(0, $other->compare($id));
        
        $greather = SimpleIntegerId::from(30);
        
        self::assertTrue($id->compare($greather) < 0);
        self::assertTrue($greather->compare($id) > 0);
        
        $lower = SimpleIntegerId::from(10);
        
        self::assertTrue($id->compare($lower) > 0);
        self::assertTrue($lower->compare($id) < 0);
    }
    
    public function test_it_can_be_sorted_thanks_to_compare_method()
    {
        $id1 = SimpleIntegerId::from(15);
        $id2 = SimpleIntegerId::from(5);
        $id3 = SimpleIntegerId::from(25);
        $id4 = SimpleIntegerId::from(10);
        
        $ids = [$id1, $id2, $id3, $id4];
        usort($ids, function (Id $first, Id $second) {return $first->compare($second);});
        
        $expected = [$id2, $id4, $id1, $id3];
        self::assertSame($expected, $ids);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_compare_with_object_of_not_the_same_type_is_not_allowed()
    {
        $id = new SimpleIntegerId(15);
        $other = new OtherIntegerId(15);
        
        $id->compare($other);
    }
}
