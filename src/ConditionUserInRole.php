<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Security\User;

/**
 * ConditionUserInRole
 *
 * @author Jakub Konečný
 */
class ConditionUserInRole implements IMenuItemCondition {
  use \Nette\SmartObject;
  
  /** @var  User */
  protected $user;
  /** @var string */
  protected $name = "role";
  
  public function __construct(User $user) {
    $this->user = $user;
  }
  
  /**
   * @param string $parameter Role
   * @return bool
   * @throws \InvalidArgumentException
   */
  public function isAllowed($parameter = NULL): bool {
    if(!is_string($parameter)) {
      throw new \InvalidArgumentException("Method " . static::class . "::isAllowed expects string as parameter.");
    }
    return $this->user->isInRole($parameter);
  }
  
  /**
   * @return string
   */
  public function getName(): string {
    return $this->name;
  }
}
?>