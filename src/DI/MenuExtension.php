<?php
declare(strict_types=1);

namespace Nexendrie\Menu\DI;

use Nexendrie\Menu\IMenuControlFactory,
    Nexendrie\Menu\Menu,
    Nexendrie\Menu\MenuItem,
    Nette\DI\Config\Helpers;

/**
 * MenuExtension
 *
 * @author Jakub Konečný
 */
class MenuExtension extends \Nette\DI\CompilerExtension {
  /** @var array */
  protected $defaults = [
    "default" => [],
  ];
  
  protected $menuDefaults = [
    "type" => "inline",
    "title" => "",
    "items" => [],
  ];
  
  function loadConfiguration(): void {
    $config = $this->getConfig($this->defaults);
    $builder = $this->getContainerBuilder();
    $builder->addDefinition($this->prefix("component"))
      ->setImplement(IMenuControlFactory::class);
    $data = Helpers::merge($config["default"], $this->menuDefaults);
    $builder->addDefinition($this->prefix("menu"))
      ->setFactory(self::class . "::createMenu", [$data]);
  }
  
  static function createMenu(array $config): Menu {
    $menu = new Menu;
    $menu->title = $config["title"];
    $menu->type = $config["type"];
    foreach($config["items"] as $text => $link) {
      $menu[] = new MenuItem($link, $text);
    }
    return $menu;
  }
}
?>