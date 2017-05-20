<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * CustomCondition
 *
 * @author Jakub Konečný
 */
class CustomCondition implements IMenuItemCondition {
  function getName(): string {
    return "custom";
  }
  
  function isAllowed($parameter = NULL): bool {
    return true;
  }
}
?>