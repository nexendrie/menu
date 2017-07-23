<?php
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