<?php

declare(strict_types=1);

namespace MsgPhp\User\Command;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class DeleteUserRoleCommand
{
    public $userId;
    public $role;

    public function __construct($userId, string $role)
    {
        $this->userId = $userId;
        $this->role = $role;
    }
}
