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
  
  protected const SECTION_CONDITIONS = "conditions";
  
  /** @var Container */
  protected $container;
  
  public function __construct(Container $container) {
    $this->container = $container;
  }
  
  /**
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
  
  /**
   * @param string|array $definition
   * @throws \InvalidArgumentException
   * @throws InvalidMenuItemDefinitionException
   * @throws MenuItemConditionNotSupportedException
   */
  protected function createItem(string $text, $definition): MenuItem {
    if(is_string($definition)) {
      return new MenuItem($definition, $text);
    } elseif(!is_array($definition)) {
      throw new \InvalidArgumentException("Menu item has to be either string or array.");
    } elseif(!array_key_exists("link", $definition)) {
      throw new InvalidMenuItemDefinitionException("Menu item is missing link.");
    }
    $item = new MenuItem($definition["link"], $text);
    if(array_key_exists(static::SECTION_CONDITIONS, $definition) AND is_array($definition[static::SECTION_CONDITIONS])) {
      foreach($definition[static::SECTION_CONDITIONS] as $condition => $value) {
        try {
          $conditionService = $this->getCondition($condition);
        } catch(MenuItemConditionNotSupportedException $e) {
          throw $e;
        }
        $item->addCondition($conditionService, $value);
      }
    }
    return $item;
  }
  
  /**
   * @throws \InvalidArgumentException
   * @throws InvalidMenuItemDefinitionException
   * @throws MenuItemConditionNotSupportedException
   */
  public function createMenu(string $name, array $config): Menu {
    $menu = new Menu($name, $config["htmlId"]);
    $menu->title = $config["title"];
    foreach($config["items"] as $text => $definition) {
      $menu[] = $this->createItem($text, $definition);
    }
    return $menu;
  }
}
?>