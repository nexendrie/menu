<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Security\User;

/**
 * ConditionUserLoggedIn
 *
 * @author Jakub Konečný
 */
class ConditionUserLoggedIn implements IMenuItemCondition {
  use \Nette\SmartObject;
  
  /** @var  User */
  protected $user;
  /** @var string */
  protected $name = "loggedIn";
  
  function __construct(User $user) {
    $this->user = $user;
  }
  
  /**
   * @param bool $parameter
   * @return bool
   * @throws \InvalidArgumentException
   */
  function isAllowed($parameter = NULL): bool {
    if(is_null($parameter)) {
      return true;
    } elseif(!is_bool($parameter)) {
      throw new \InvalidArgumentException("Method " . static::class . "::isAllowed expects boolean as parameter.");
    } else {
      return ($parameter === $this->user->isLoggedIn());
    }
  }
  
  /**
   * @return string
   */
  function getName(): string {
    return $this->name;
  }
}
?>