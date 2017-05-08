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
  const COMPONENT_SERVICE = "componentFactory";
  
  /** @var array */
  protected $defaults = [
    "default" => [],
  ];
  
  protected $menuDefaults = [
    "title" => "",
    "htmlId" => "menu",
    "items" => [],
  ];
  
  function loadConfiguration(): void {
    $config = $this->getConfig($this->defaults);
    $builder = $this->getContainerBuilder();
    $builder->addDefinition($this->prefix(static::COMPONENT_SERVICE))
      ->setImplement(IMenuControlFactory::class);
    foreach($config as $name => $menu) {
      $data = Helpers::merge($menu, $this->menuDefaults);
      $builder->addDefinition($this->prefix($name))
        ->setFactory(self::class . "::createMenu", [$name, $data])
        ->setAutowired(($name === "default"));
    }
  }
  
  function beforeCompile(): void {
    $builder = $this->getContainerBuilder();
    $control = $builder->getDefinition($this->prefix(static::COMPONENT_SERVICE));
    $menus = $builder->findByType(Menu::class);
    foreach($menus as $menuName => $menu) {
      $control->addSetup('?->addMenu(?);', ["@self", "@$menuName"]);
    }
  }
  
  static function createMenu(string $name, array $config): Menu {
    $menu = new Menu($name, $config["htmlId"]);
    $menu->title = $config["title"];
    foreach($config["items"] as $text => $link) {
      $menu[] = new MenuItem($link, $text);
    }
    return $menu;
  }
}
?>