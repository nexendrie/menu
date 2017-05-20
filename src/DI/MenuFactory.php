<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Nette\DI\Container,
    Nexendrie\Menu\Menu,
    Nexendrie\Menu\MenuItem,
    Nexendrie\Menu\IMenuItemCondition,
    Nexendrie\Menu\InvalidMenuItemDefinitionException,
    Nexendrie\Menu\MenuItemConditionNotSupportedException;

/**
 * MenuFactory
 *
 * @author Jakub Konečný
 */
class MenuFactory {
  use \Nette\SmartObject;
  
  /** @var Container */
  protected $container;
  /** @var array */
  protected $conditions = [];
  
  function __construct(array $conditions, Container $container) {
    $this->container = $container;
    $this->conditions = $conditions;
  }
  
  function createMenu(string $name, array $config): Menu {
    $menu = new Menu($name, $config["htmlId"]);
    $menu->title = $config["title"];
    foreach($config["items"] as $text => $definition) {
      if(is_string($definition)) {
        $menu[] = new MenuItem($definition, $text);
        continue;
      } elseif(!is_array($definition)) {
        throw new \InvalidArgumentException("Menu item has to be either string or array.");
      } elseif(!array_key_exists("link", $definition)) {
        throw new InvalidMenuItemDefinitionException("Menu item is missing link.");
      }
      $item = new MenuItem($definition["link"], $text);
      if(array_key_exists(MenuExtension::CONDITIONS_SECTION, $definition) AND is_array($definition[MenuExtension::CONDITIONS_SECTION])) {
        foreach($definition[MenuExtension::CONDITIONS_SECTION] as $condition => $value) {
          if(!array_key_exists($condition, $this->conditions)) {
            throw new MenuItemConditionNotSupportedException("Condition $condition is not defined.");
          }
          /** @var IMenuItemCondition $conditionService */
          $conditionService = $this->container->getByType($this->conditions[$condition]);
          $item->addCondition($conditionService, $value);
        }
      }
      $menu[] = $item;
    }
    return $menu;
  }
}
?>