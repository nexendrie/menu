<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * Authenticator
 *
 * @author Jakub Konečný
 */
class Authenticator extends \Nette\Security\SimpleAuthenticator {
  function __construct() {
    $userList = [
      "test" => "test",
    ];
    $usersRoles = [
      "test" => "abc",
    ];
    parent::__construct($userList, $usersRoles);
  }
}
?>