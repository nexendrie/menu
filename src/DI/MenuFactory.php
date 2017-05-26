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
 * @internal
 */
class MenuFactory {
  use \Nette\SmartObject;
  
  /** @var Container */
  protected $container;
  
  function __construct(Container $container) {
    $this->container = $container;
  }
  
  /**
   * @param string $name
   * @return IMenuItemCondition
   * @throws MenuItemConditionNotSupportedException
   */
  protected function getCondition(string $name): IMenuItemCondition {
    foreach($this->container->findByType(IMenuItemCondition::class) as $serviceName) {
      /** @var IMenuItemCondition $service */
      $service = $this->container->createService($serviceName);
      if($service->getName() === $name) {
        return $service;
      }
    }
    throw new MenuItemConditionNotSupportedException("Condition $name is not defined.");
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
      if(array_key_exists(MenuExtension::SECTION_CONDITIONS, $definition) AND is_array($definition[MenuExtension::SECTION_CONDITIONS])) {
        foreach($definition[MenuExtension::SECTION_CONDITIONS] as $condition => $value) {
          try {
            $conditionService = $this->getCondition($condition);
          } catch(MenuItemConditionNotSupportedException $e) {
            throw $e;
          }
          $item->addCondition($conditionService, $value);
        }
      }
      $menu[] = $item;
    }
    return $menu;
  }
}
?>