<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * CustomCondition
 *
 * @author Jakub Konečný
 */
class CustomCondition implements IMenuItemCondition {
  public function getName(): string {
    return "custom";
  }
  
  public function isAllowed($parameter = NULL): bool {
    return true;
  }
}
?>