<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Security\User;

/**
 * ConditionUserInRole
 *
 * @author Jakub Konečný
 */
class ConditionUserInRole extends BaseCondition {
  /** @var User */
  protected $user;
  /** @var string */
  protected $name = "role";
  
  public function __construct(User $user) {
    $this->user = $user;
  }
  
  /**
   * @param string $parameter Role
   * @throws \InvalidArgumentException
   */
  public function isAllowed($parameter = NULL): bool {
    if(!is_string($parameter)) {
      throw new \InvalidArgumentException("Method " . __METHOD__ . " expects string as parameter.");
    }
    return $this->user->isInRole($parameter);
  }
}
?>