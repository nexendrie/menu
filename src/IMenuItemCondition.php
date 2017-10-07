<?php
declare(strict_types=1);

namespace Nexendrie\Menu;

/**
 * IMenuItemCondition
 *
 * @author Jakub Konečný
 */
interface IMenuItemCondition {
  public function getName(): string;
  public function isAllowed($parameter = NULL): bool;
}
?>