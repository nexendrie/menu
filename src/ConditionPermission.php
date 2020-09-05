<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

use Nette\Security\User;
use Nette\Utils\Strings;

/**
 * ConditionPermission
 *
 * @author Jakub Konečný
 */
final class ConditionPermission extends BaseCondition {
  /** @var User */
  private $user;
  /** @var string */
  protected $name = "acl";
  
  public function __construct(User $user) {
    $this->user = $user;
  }
  
  /**
   * @param string $parameter
   * @throws \InvalidArgumentException
   * @throws \OutOfBoundsException
   */
  public function isAllowed($parameter = null): bool {
    if(!is_string($parameter)) {
      throw new \InvalidArgumentException("Method " . __METHOD__ . " expects string as parameter.");
    } elseif(!str_contains($parameter, ":")) {
      throw new \OutOfBoundsException("Method " . __METHOD__ . " expects parameter in format resource:privilege.");
    }
    return $this->user->isAllowed(Strings::before($parameter, ":"), Strings::after($parameter, ":"));
  }
}
?>