<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity\Fields;

use MsgPhp\Domain\DomainCollectionInterface;
use MsgPhp\Domain\Factory\DomainCollectionFactory;
use MsgPhp\User\Entity\UserRole;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait RolesField
{
    /** @var UserRole[] */
    private $roles;

    public function getRole(string $role): ?UserRole
    {
        foreach ($this->roles as $userRole) {
            if ($userRole->getRole() === $role) {
                return $userRole;
            }
        }

        return null;
    }

    /**
     * @return DomainCollectionInterface|UserRole[]
     */
    public function getRoles(): DomainCollectionInterface
    {
        return $this->roles instanceof DomainCollectionInterface ? $this->roles : ($this->roles = DomainCollectionFactory::create($this->roles));
    }
}
