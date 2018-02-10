<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class AddUserRoleCommand
{
    public $userId;
    public $role;
    public $context;

    public function __construct($userId, string $role, array $context = [])
    {
        $this->userId = $userId;
        $this->role = $role;
        $this->context = $context;
    }
}
