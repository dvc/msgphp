<?php

declare(strict_types=1);

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\Exception\EntityNotFoundException;
use MsgPhp\Domain\Factory\EntityAwareFactoryInterface;
use MsgPhp\Domain\Message\{DomainMessageBusInterface, MessageDispatchingTrait};
use MsgPhp\User\Command\AddUserRoleCommand;
use MsgPhp\User\Entity\User;
use MsgPhp\User\Entity\UserRole;
use MsgPhp\User\Event\UserRoleAddedEvent;
use MsgPhp\User\Repository\UserRepositoryInterface;
use MsgPhp\User\Repository\UserRoleRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class AddUserRoleHandler
{
    use MessageDispatchingTrait;

    private $repository;
    private $userRepository;

    public function __construct(EntityAwareFactoryInterface $factory, DomainMessageBusInterface $bus, UserRoleRepositoryInterface $repository, UserRepositoryInterface $userRepository)
    {
        $this->factory = $factory;
        $this->bus = $bus;
        $this->repository = $repository;
    }

    public function __invoke(AddUserRoleCommand $command): void
    {
        $userRole = $this->factory->create(UserRole::class, [
            'user' =>
        ]
        try {
            $userRole = $this->repository->find($this->factory->identify(User::class, $command->userId), $command->role);
        } catch (EntityNotFoundException $e) {
            return;
        }

        $this->repository->delete($userRole);
        $this->dispatch(UserRoleAddedEvent::class, [$userRole]);
    }
}
