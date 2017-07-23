<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * ConditionABC
 *
 * @author Jakub Konečný
 */
class ConditionABC extends BaseCondition {
  public function isAllowed($parameter = NULL): bool {
    return true;
  }
}
?>