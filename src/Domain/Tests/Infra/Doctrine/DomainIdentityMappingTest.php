<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Infra\Doctrine;

use MsgPhp\Domain\DomainIdInterface;
use MsgPhp\Domain\Exception\InvalidClassException;
use MsgPhp\Domain\Infra\Doctrine\DomainIdentityMapping;
use MsgPhp\Domain\Tests\Fixtures\Entities;
use PHPUnit\Framework\TestCase;

final class DomainIdentityMappingTest extends TestCase
{
    use EntityManagerTrait;

    public function testGetIdentifierFieldNames(): void
    {
        $mapping = new DomainIdentityMapping(self::$em);

        $this->assertSame(['id'], $mapping->getIdentifierFieldNames(Entities\TestEntity::class));
        $this->assertSame(['idA', 'idB'], $mapping->getIdentifierFieldNames(Entities\TestCompositeEntity::class));
    }

    public function testGetIdentifierFieldNamesWithInvalidClass(): void
    {
        $mapping = new DomainIdentityMapping(self::$em);

        $this->expectException(InvalidClassException::class);

        $mapping->getIdentifierFieldNames('foo');
    }

    public function testGetIdentity(): void
    {
        $mapping = new DomainIdentityMapping(self::$em);
        $entity = Entities\TestEntity::create(['strField' => 'foo']);
        $entity->identify($id = $this->createMock(DomainIdInterface::class));

        $this->assertSame(['id' => $id], $mapping->getIdentity($entity));
        $this->assertSame(['idA' => $id], $mapping->getIdentity(Entities\TestCompositeEntity::create(['idA' => $id])));
        $this->assertSame(['idA' => $id, 'idB' => 'foo'], $mapping->getIdentity(Entities\TestCompositeEntity::create(['idA' => $id, 'idB' => 'foo'])));
        $this->assertSame(['idB' => 'foo'], $mapping->getIdentity(Entities\TestCompositeEntity::create(['idA' => null, 'idB' => 'foo'])));
    }

    public function testGetIdentityWithInvalidClass(): void
    {
        $mapping = new DomainIdentityMapping(self::$em);

        $this->expectException(InvalidClassException::class);

        $mapping->getIdentity(new class() {
        });
    }
}
