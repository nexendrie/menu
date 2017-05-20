<?php
namespace Nexendrie\Menu;

/**
 * IMenuItemCondition
 *
 * @author Jakub Konečný
 */
interface IMenuItemCondition {
  function getName(): string;
  function isAllowed($parameter = NULL): bool;
}
?>