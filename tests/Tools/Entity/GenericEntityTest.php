<?php

namespace FiiSoft\Test\Tools\Entity;

use FiiSoft\Test\Stub\SimpleIntegerId;
use FiiSoft\Tools\Entity\GenericEntity;

class GenericEntityTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_has_no_id_if_not_set()
    {
        $entity = new GenericEntity();
        
        self::assertNull($entity->id());
    }
    
    public function test_it_returns_id_if_set()
    {
        $id = new SimpleIntegerId(15);
        $entity = new GenericEntity($id);
        
        self::assertSame($id, $entity->id());
    }
}