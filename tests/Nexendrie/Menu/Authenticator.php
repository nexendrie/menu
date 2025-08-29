<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Authenticator
 *
 * @author Jakub Konečný
 */
final class Authenticator extends \Nette\Security\SimpleAuthenticator
{
    public function __construct()
    {
        $userList = [
            "test" => "test",
        ];
        $usersRoles = [
            "test" => "abc",
        ];
        parent::__construct($userList, $usersRoles);
    }
}
