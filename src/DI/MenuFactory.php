<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Nexendrie\Menu\Menu;
use Nexendrie\Menu\MenuItem;
use Nexendrie\Menu\IMenuItemCondition;
use Nexendrie\Menu\InvalidMenuItemDefinitionException;
use Nexendrie\Menu\MenuItemConditionNotSupportedException;
use Nexendrie\Menu\IMenuItemLinkRender;

/**
 * MenuFactory
 *
 * @author Jakub Konečný
 * @internal
 */
final class MenuFactory {
  use \Nette\SmartObject;
  
  protected const SECTION_CONDITIONS = "conditions";

  /** @var IMenuItemLinkRender[] */
  protected $linkRenders;
  /** @var IMenuItemCondition[] */
  protected $conditions;

  /**
   * @param IMenuItemLinkRender[] $linkRenders
   * @param IMenuItemCondition[] $conditions
   */
  public function __construct(array $linkRenders, array $conditions) {
    $this->linkRenders = $linkRenders;
    $this->conditions = $conditions;
  }
  
  /**
   * @throws MenuItemConditionNotSupportedException
   */
  protected function getCondition(string $name): IMenuItemCondition {
    foreach($this->conditions as $condition) {
      if($condition->getName() === $name) {
        return $condition;
      }
    }
    throw new MenuItemConditionNotSupportedException("Condition $name is not defined.");
  }
  
  /**
   * @throws MenuItemConditionNotSupportedException
   */
  protected function insertConditions(MenuItem &$item, array $definition): void {
    if(!array_key_exists(static::SECTION_CONDITIONS, $definition) OR !is_array($definition[static::SECTION_CONDITIONS])) {
      return;
    }
    foreach($definition[static::SECTION_CONDITIONS] as $condition => $value) {
      try {
        $conditionService = $this->getCondition($condition);
      } catch(MenuItemConditionNotSupportedException $e) {
        throw $e;
      }
      $item->addCondition($conditionService, $value);
    }
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
    $this->insertConditions($item, $definition);
    if(isset($definition["items"]) AND is_array($definition["items"])) {
      foreach($definition["items"] as $subtext => $subdefinition) {
        $item[] = $this->createItem($subtext, $subdefinition);
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
      $item = $this->createItem($text, $definition);
      foreach($this->linkRenders as $render) {
        $item->addLinkRender($render);
      }
      $menu[] = $item;
    }
    return $menu;
  }
}
?>